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
    protected int $retryAfter = 60;
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
            file_put_contents($tempPdfPath, $pdfOutput);

            // Enviar el email con el certificado
            $email = service('email', null, false);
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->attach($tempPdfPath);

            $result = $email->send(false);

            if (!$result) {
                throw new Exception($email->printDebugger(['headers']));
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

            // Limpiar archivo temporal
            unlink($tempPdfPath);

            log_message('info', "Certificado enviado exitosamente a: {$to}");
            return $result;

        } catch (Exception $e) {
            log_message('error', 'Error al enviar certificado por email: ' . $e->getMessage());

            // Limpiar archivo temporal si existe
            if (isset($tempPdfPath) && file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }

            throw $e;
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

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        // Generar HTML del certificado usando la plantilla
        $html = view('certificates/template', [
            'config' => $companyConfig,
            'user_name' => $certificateData['user_name'],
            'event_name' => $certificateData['event_name'],
            'event_date' => $certificateData['event_date'],
            'event_modality' => $certificateData['event_modality']
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->output();
    }
}
