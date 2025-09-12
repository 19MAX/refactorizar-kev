<?php

namespace App\Services;

use App\Models\RegistrationsModel;
use App\Models\PaymentsModel;
use App\Models\EventsModel;
use App\Models\CertificatesSentModel;
use Exception;

class CertificateService
{
    protected $registrationsModel;
    protected $paymentsModel;
    protected $eventsModel;
    protected $certificatesSentModel;

    public function __construct()
    {
        $this->registrationsModel = new RegistrationsModel();
        $this->paymentsModel = new PaymentsModel();
        $this->eventsModel = new EventsModel();
        $this->certificatesSentModel = new CertificatesSentModel();
    }

    /**
     * Enviar certificado individual a la cola
     */
    public function sendCertificateToQueue($registrationId)
    {
        try {
            // Obtener información del usuario y pago
            $registration = $this->registrationsModel->find($registrationId);
            if (!$registration) {
                return ['success' => false, 'message' => 'Registro no encontrado'];
            }

            // Verificar que el pago esté completado
            $payment = $this->paymentsModel->where('id_register', $registrationId)
                ->where('payment_status', 2)
                ->first();

            if (!$payment) {
                return ['success' => false, 'message' => 'No hay pago completado para este registro'];
            }

            // Verificar si ya se envió el certificado
            if ($this->certificatesSentModel->isCertificateSent($registrationId, $payment['id'])) {
                return ['success' => false, 'message' => 'El certificado ya fue enviado anteriormente'];
            }

            // Obtener información del evento
            $event = $this->eventsModel->find($registration['event_cod']);

            // Preparar datos para el certificado
            $certificateData = [
                'user_name' => $registration['full_name_user'],
                'event_name' => $event['event_name'] ?? $registration['event_name'],
                'event_date' => $event['event_date'] ?? null,
                'event_modality' => $event['modality'] ?? null,
                'registration_id' => $registrationId,
                'payment_id' => $payment['id'],
                'user_email' => $registration['email']
            ];

            // Datos para correo de tipo certificado
            $emailDataCertificate = [
                'to' => $registration['email'],
                'subject' => 'Certificado de Participación - ' . $certificateData['event_name'],
                'message' => "mensaje",
                'htmlContent' => '', // El contenido HTML puede estar vacío si no es necesario
                'pdfFilename' => 'certificado_' . str_replace(' ', '_', $certificateData['user_name']) . '_' . date('Y-m-d') . '.pdf',
                'emailType' => 'send_email_certificate',
                'certificateData' => $certificateData,
                'sentBy' => session('user_id')
            ];

            // Añadir el trabajo a la cola para certificado
            service('queue')->push('emails', 'email', $emailDataCertificate);

            return ['success' => true, 'message' => 'Certificado agregado a la cola de envío'];

        } catch (Exception $e) {
            log_message('error', 'Error enviando certificado: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()];
        }
    }

    /**
     * Enviar certificados masivos a la cola
     */
    public function sendBulkCertificatesToQueue($eventId = null, $filters = [])
    {
        try {
            $sentCount = 0;
            $errorCount = 0;
            $alreadySentCount = 0;

            // Obtener registraciones con pagos completados
            $query = $this->registrationsModel
                ->select('registrations.*, payments.id as payment_id')
                ->join('payments', 'payments.id_register = registrations.id')
                ->where('payments.payment_status', 2);

            if ($eventId) {
                $query->where('registrations.event_cod', $eventId);
            }

            // Aplicar filtros adicionales si existen
            if (!empty($filters['date_from'])) {
                $query->where('registrations.created_at >=', $filters['date_from']);
            }
            if (!empty($filters['date_to'])) {
                $query->where('registrations.created_at <=', $filters['date_to']);
            }

            $registrations = $query->findAll();

            foreach ($registrations as $registration) {
                // Verificar si ya se envió el certificado
                if ($this->certificatesSentModel->isCertificateSent($registration['id'], $registration['payment_id'])) {
                    $alreadySentCount++;
                    continue;
                }

                $result = $this->sendCertificateToQueue($registration['id']);

                if ($result['success']) {
                    $sentCount++;
                } else {
                    $errorCount++;
                    log_message('error', "Error enviando certificado para registro {$registration['id']}: " . $result['message']);
                }
            }

            return [
                'success' => true,
                'message' => "Proceso completado. Enviados: {$sentCount}, Ya enviados: {$alreadySentCount}, Errores: {$errorCount}",
                'stats' => [
                    'sent' => $sentCount,
                    'already_sent' => $alreadySentCount,
                    'errors' => $errorCount,
                    'total' => count($registrations)
                ]
            ];

        } catch (Exception $e) {
            log_message('error', 'Error en envío masivo de certificados: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()];
        }
    }

    /**
     * Obtener mensaje del email para certificado
     */
    private function getCertificateEmailMessage($userName, $eventName)
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #333;'>¡Felicitaciones {$userName}!</h2>
            
            <p>Nos complace adjuntar su certificado de participación en el evento:</p>
            
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;'>
                <h3 style='color: #007bff; margin: 0;'>{$eventName}</h3>
            </div>
            
            <p>Su certificado ha sido generado automáticamente y está adjunto a este correo electrónico.</p>
            
            <p style='margin-top: 30px;'>
                Gracias por su participación.<br>
                <strong>Equipo Organizador</strong>
            </p>
            
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='font-size: 12px; color: #666;'>
                Este es un correo automático, por favor no responda a este mensaje.
            </p>
        </div>";
    }

    /**
     * Obtener estadísticas de certificados enviados
     */
    public function getCertificateStats($eventId = null)
    {
        try {
            $query = $this->certificatesSentModel->select('COUNT(*) as total_sent');

            if ($eventId) {
                $query->where('event_id', $eventId);
            }

            $totalSent = $query->first()['total_sent'] ?? 0;

            // Obtener total de registraciones con pago completado
            $totalQuery = $this->registrationsModel
                ->select('COUNT(*) as total')
                ->join('payments', 'payments.id_register = registrations.id')
                ->where('payments.payment_status', 2);

            if ($eventId) {
                $totalQuery->where('registrations.event_cod', $eventId);
            }

            $totalEligible = $totalQuery->first()['total'] ?? 0;
            $pending = $totalEligible - $totalSent;

            return [
                'success' => true,
                'stats' => [
                    'total_eligible' => $totalEligible,
                    'total_sent' => $totalSent,
                    'pending' => $pending,
                    'percentage_sent' => $totalEligible > 0 ? round(($totalSent / $totalEligible) * 100, 2) : 0
                ]
            ];

        } catch (Exception $e) {
            log_message('error', 'Error obteniendo estadísticas de certificados: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error obteniendo estadísticas'];
        }
    }
}