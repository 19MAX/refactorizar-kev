<?php

namespace App\Services;

use App\Models\RegistrationsModel;
use App\Models\PaymentsModel;
use App\Models\EventsModel;
use App\Models\CertificatesSentModel;
use App\Models\ConfigModel;
use App\Services\EmailApi;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class CertificateService
{
    protected $registrationsModel;
    protected $paymentsModel;
    protected $eventsModel;
    protected $certificatesSentModel;
    protected $configModel;
    protected $emailApi;

    public function __construct()
    {
        $this->registrationsModel = new RegistrationsModel();
        $this->paymentsModel = new PaymentsModel();
        $this->eventsModel = new EventsModel();
        $this->certificatesSentModel = new CertificatesSentModel();
        $this->configModel = new ConfigModel();
        $this->emailApi = new EmailApi();
    }

    public function sendCertificate($registrationId, $sentBy = null, $certificateData = [])
    {
        try {
            // Obtener información del usuario y pago
            $registration = $this->registrationsModel->find($registrationId);
            if (!$registration) {
                return [
                    'success' => false,
                    'message' => 'Registro no encontrado'
                ];
            }

            // Verificar que el pago esté completado
            $payment = $this->paymentsModel->where('id_register', $registrationId)
                ->where('payment_status', 2)
                ->first();

            if (!$payment) {
                return [
                    'success' => false,
                    'message' => 'No hay pago completado para este registro'
                ];
            }

            // Verificar si ya se envió el certificado
            // if ($this->certificatesSentModel->isCertificateSent($registrationId, $payment['id'])) {
            //     return [
            //         'success' => false,
            //         'message' => 'El certificado ya fue enviado anteriormente'
            //     ];
            // }

            // Obtener información del evento
            // $event = $this->eventsModel->find($registration['event_cod']);

            // Preparar datos para el certificado
            // $certificateData = [
            //     'user_name' => $registration['full_name_user'],
            //     'event_name' => $event['event_name'] ?? $registration['event_name'],
            //     'event_date' => $event['event_date'] ?? null,
            //     'event_modality' => $event['modality'] ?? null,
            //     'registration_id' => $registrationId,
            //     'payment_id' => $payment['id']
            // ];

            // Generar y enviar certificado
            $emailResult = $this->generateAndSendCertificate($certificateData, $registration['email'], $sentBy);

            if ($emailResult['success']) {
                log_message('info', 'Certificado enviado exitosamente', [
                    'registration_id' => $registrationId,
                    'email' => $registration['email']
                ]);

                return [
                    'success' => true,
                    'message' => 'Certificado enviado correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al enviar certificado: ' . $emailResult['message']
                ];
            }

        } catch (Exception $e) {
            log_message('error', 'Error enviando certificado: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ];
        }
    }

    protected function generateAndSendCertificate($certificateData, $userEmail, $sentBy = null)
    {
        // Obtener configuración de la empresa
        $companyConfig = $this->configModel->getCompanyConfig();
        try {

            // Generar el PDF del certificado usando la misma lógica del job
            $pdfOutput = $this->generateCertificatePdf($certificateData, $companyConfig);

            if (!$pdfOutput) {
                return [
                    'success' => false,
                    'message' => 'Error al generar el PDF del certificado'
                ];
            }

            // Guardar el PDF en el sistema
            $pdfInfo = $this->saveCertificateToSystem($pdfOutput, $certificateData);
            if (!$pdfInfo) {
                return [
                    'success' => false,
                    'message' => 'Error al guardar certificado en el sistema'
                ];
            }

            // Preparar datos para el email
            $subject = 'Certificado de Participación - ' . $certificateData['event_name'];
            $message = $this->buildCertificateEmailMessage($certificateData);

            $attachments = [$pdfInfo['path']]; // Enviar la ruta física del archivo

            log_message('debug', 'Preparando envío de certificado', [
                'archivo_fisico' => $pdfInfo['path'],
                'destinatario' => $userEmail,
                'evento' => $certificateData['event_name']
            ]);

            // Enviar email usando EmailApi
            $emailResult = $this->emailApi->sendEmail($subject, $message, $attachments, $userEmail);

            if ($emailResult['status']) {
                // Registrar el certificado como enviado usando la misma estructura del job
                $this->certificatesSentModel->recordSentCertificate([
                    'registration_id' => $certificateData['registration_id'],
                    'payment_id' => $certificateData['payment_id'],
                    'user_name' => $certificateData['user_name'],
                    'user_email' => $userEmail,
                    'event_name' => $certificateData['event_name'],
                    'event_date' => $certificateData['event_date'],
                    'event_modality' => $certificateData['event_modality'],
                    'certificate_path' => $pdfInfo['filename'],
                    'sent_by' => $sentBy ?? session('user_id')
                ]);

                log_message('info', 'Certificado enviado exitosamente a: ' . $userEmail);
                return [
                    'success' => true,
                    'message' => 'Certificado enviado correctamente',
                    'pdf_path' => $pdfInfo['url']
                ];
            } else {
                log_message('error', 'Error al enviar certificado: ' . $emailResult['message']);
                return [
                    'success' => false,
                    'message' => 'Error al enviar email: ' . $emailResult['message']
                ];
            }

        } catch (Exception $e) {
            log_message('error', 'Error en generateAndSendCertificate: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generar PDF del certificado usando la misma lógica del job
     */
    protected function generateCertificatePdf($certificateData, $companyConfig = [])
    {
        try {
            // Obtener configuración de la empresa
            // $companyConfig = $this->configModel->getCompanyConfig();

            // Configurar opciones de Dompdf para certificados (igual que el job)
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'DejaVu Sans');
            // $options->set('enable_font_subsetting', true);
            // $options->set('isPhpEnabled', true);

            $dompdf = new Dompdf($options);

            // Generar HTML del certificado usando la plantilla existente
            $html = view('certificates/template', [
                'config' => $companyConfig,
                'participant_name' => $certificateData['user_name'],
                'event_name' => $certificateData['event_name'],
                'event_date' => $certificateData['event_date'],
                'event_modality' => $certificateData['event_modality'],
                'certificate_number' => 'CERT-' . date('Y') . '-' . str_pad($certificateData['registration_id'] ?? '001', 3, '0', STR_PAD_LEFT),
                'issue_date' => date('Y-m-d'),
                'city' => 'Guaranda'
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return $dompdf->output();

        } catch (Exception $e) {
            log_message('error', 'Error generando PDF del certificado: ' . $e->getMessage());
            throw new Exception('Error generando PDF del certificado: ' . $e->getMessage());
        }
    }

    /**
     * Guardar certificado en el sistema
     */
    protected function saveCertificateToSystem($pdfOutput, $certificateData)
    {
        try {
            // Crear directorio para certificados si no existe
            $uploadsDir = FCPATH . 'uploads/certificados/';
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }

            // Usar la misma estructura de nombres del job
            $pdfFilename = 'certificado_' . $certificateData['registration_id'] . '_' . date('Y-m-d') . '.pdf';


            // Ruta completa del archivo
            $filePath = $uploadsDir . $pdfFilename;

            // Guardar archivo
            if (file_put_contents($filePath, $pdfOutput) !== false) {
                log_message('info', 'Certificado PDF guardado exitosamente: ' . $filePath);

                // Verificar que el archivo se creó correctamente
                if (file_exists($filePath)) {
                    $fileSize = filesize($filePath);
                    log_message('info', 'Certificado verificado - tamaño: ' . $fileSize . ' bytes');

                    // Retornar información del archivo
                    $fileUrl = base_url('uploads/certificados/' . $pdfFilename);

                    return [
                        'path' => $filePath,      // Ruta física del archivo
                        'url' => $fileUrl,        // URL accesible del archivo
                        'filename' => $pdfFilename // Solo el nombre del archivo
                    ];
                } else {
                    log_message('error', 'Certificado no existe después de guardarlo: ' . $filePath);
                    return false;
                }
            }

            log_message('error', 'No se pudo escribir el certificado: ' . $filePath);
            return false;

        } catch (Exception $e) {
            log_message('error', 'Error guardando certificado PDF: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mensaje HTML del email usando el mismo formato del job getCertificateEmailMessage
     */
    protected function buildCertificateEmailMessage($certificateData)
    {
        $message = "
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Certificado de Participación</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background-color: #f4f4f4; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .details { background-color: #f9f9f9; padding: 15px; border-left: 4px solid #28a745; margin: 20px 0; }
                .details ul { list-style: none; padding: 0; }
                .details li { padding: 5px 0; }
                .details strong { color: #28a745; }
                .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
                .congratulations { background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 15px; margin: 20px 0; text-align: center; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>Certificado de Participación</h2>
            </div>
            <div class='content'>
                <div class='congratulations'>
                    <h3>¡Felicitaciones {$certificateData['user_name']}!</h3>
                    <p>Has completado exitosamente tu participación en el evento.</p>
                </div>
            </div>
            <div class='footer'>
                <p>Este es un mensaje automático, por favor no responda a este correo.</p>
                <p>Si tiene alguna consulta sobre su certificado, póngase en contacto con nuestro equipo de soporte.</p>
            </div>
        </body>
        </html>";

        return $message;
    }

    /**
     * Método para limpiar certificados antiguos
     */
    public function cleanOldCertificates($daysOld = 90)
    {
        $uploadsDir = FCPATH . 'uploads/certificados/';
        if (!is_dir($uploadsDir)) {
            return false;
        }

        $files = glob($uploadsDir . '*.pdf');
        $cutoffTime = time() - ($daysOld * 24 * 60 * 60);
        $deletedCount = 0;

        foreach ($files as $file) {
            if (filemtime($file) < $cutoffTime) {
                if (unlink($file)) {
                    $deletedCount++;
                    log_message('info', 'Certificado antiguo eliminado: ' . $file);
                }
            }
        }

        log_message('info', "Limpieza de certificados completada. {$deletedCount} archivos eliminados.");
        return $deletedCount;
    }
}