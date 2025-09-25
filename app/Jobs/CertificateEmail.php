<?php

namespace App\Jobs;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use CodeIgniter\Queue\BaseJob;
use CodeIgniter\Queue\Interfaces\JobInterface;
use App\Models\ConfigModel;
use App\Models\CertificatesSentModel;

class CertificateEmail extends BaseJob implements JobInterface
{
    protected int $retryAfter = 300; // Aumentar tiempo entre reintentos a 5 minutos
    protected int $tries = 3;

    public function process()
    {
        $to = $this->data['to'];
        $subject = $this->data['subject'];
        $message = $this->data['message'];
        $certificateData = $this->data['certificateData'];
        $registrationId = $this->data['registrationId'];
        $paymentId = $this->data['paymentId'];
        $sentBy = $this->data['sentBy'] ?? null;

        try {
            // Verificar si el certificado ya fue enviado
            $certificatesSentModel = new CertificatesSentModel();
            if ($certificatesSentModel->isCertificateSent($registrationId, $paymentId)) {
                log_message('info', "Certificado ya enviado para registration_id: {$registrationId}, payment_id: {$paymentId}");
                return true; // No es un error, solo evitamos duplicados
            }

            // Generar el PDF del certificado
            $pdfOutput = $this->generateCertificatePdf($certificateData);

            $pdfFilename = 'certificado_' . $certificateData['user_name'] . '_' . date('Y-m-d') . '.pdf';
            $tempPdfPath = WRITEPATH . 'uploads/' . $pdfFilename;

            // Asegurar que el directorio existe
            if (!is_dir(WRITEPATH . 'uploads/')) {
                mkdir(WRITEPATH . 'uploads/', 0755, true);
            }

            file_put_contents($tempPdfPath, $pdfOutput);

            // Configurar email con múltiples opciones de configuración
            $email = service('email', null, false);

            // Configuración alternativa si Gmail falla
            $this->configureEmailWithFallback($email);

            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->attach($tempPdfPath);

            $result = $email->send(false);

            // Limpiar archivo temporal
            // if (file_exists($tempPdfPath)) {
            //     unlink($tempPdfPath);
            // }

            if (!$result) {
                $debugInfo = $email->printDebugger(['headers']);
                log_message('error', 'Error al enviar certificado por email: ' . $debugInfo);
                throw new Exception('Error al enviar certificado por email: ' . $debugInfo);
            }

            // Registrar el certificado como enviado
            $certificatesSentModel->recordSentCertificate([
                'registration_id' => $registrationId,
                'payment_id' => $paymentId,
                'user_name' => $certificateData['user_name'],
                'user_email' => $to,
                'event_name' => $certificateData['event_name'],
                'event_date' => $certificateData['event_date'],
                'event_modality' => $certificateData['event_modality'],
                'certificate_path' => $pdfFilename,
                'sent_by' => $sentBy
            ]);

            log_message('info', "Certificado enviado exitosamente a: {$to}");
            return $result;

        } catch (Exception $e) {
            log_message('error', 'Error en Job CertificateEmail: ' . $e->getMessage());

            // Limpiar archivo temporal en caso de error
            if (isset($tempPdfPath) && file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }

            throw $e;
        }
    }

    /**
     * Configurar email con opciones de fallback
     */
    private function configureEmailWithFallback($email)
    {
        // Intentar primero con TLS puerto 587
        try {
            $config = [
                'protocol' => 'smtp',
                'SMTPHost' => 'smtp.gmail.com',
                'SMTPPort' => 587,
                'SMTPCrypto' => 'tls',
                'SMTPTimeout' => 60,
                'SMTPUser' => getenv('SMTP_USER'),
                'SMTPPass' => getenv('SMTP_PASSWORD'),
                'fromEmail' => getenv('SMTP_USER'),
                'fromName' => getenv('SMTP_NAME'),
                'mailType' => 'html',
                'charset' => 'UTF-8',
                'validate' => false,
            ];

            $email->initialize($config);

        } catch (Exception $e) {
            log_message('error', 'Fallback: Error configurando TLS 587: ' . $e->getMessage());

            // Fallback a SSL puerto 465
            try {
                $config = [
                    'protocol' => 'smtp',
                    'SMTPHost' => 'smtp.gmail.com',
                    'SMTPPort' => 465,
                    'SMTPCrypto' => 'ssl',
                    'SMTPTimeout' => 60,
                    'SMTPUser' => getenv('SMTP_USER'),
                    'SMTPPass' => getenv('SMTP_PASSWORD'),
                    'fromEmail' => getenv('SMTP_USER'),
                    'fromName' => getenv('SMTP_NAME'),
                    'mailType' => 'html',
                    'charset' => 'UTF-8',
                    'validate' => false,
                ];

                $email->initialize($config);

            } catch (Exception $e2) {
                log_message('error', 'Fallback: Error configurando SSL 465: ' . $e2->getMessage());
                throw $e2;
            }
        }
    }

    /**
     * Generar PDF del certificado
     */
    private function generateCertificatePdf($certificateData)
    {
        // Obtener configuración de la empresa
        $configModel = new ConfigModel();
        $companyConfig = $configModel->getCompanyConfig();

        // Configurar opciones de Dompdf para certificados
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('enable_font_subsetting', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Generar HTML del certificado usando la plantilla
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
    }
}