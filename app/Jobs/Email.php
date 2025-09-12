<?php

namespace App\Jobs;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use CodeIgniter\Queue\BaseJob;
use CodeIgniter\Queue\Interfaces\JobInterface;

class Email extends BaseJob implements JobInterface
{
    protected int $retryAfter = 300; // Aumentar tiempo entre reintentos a 5 minutos
    protected int $tries = 3;

    public function process()
    {
        $to = $this->data['to'];
        $subject = $this->data['subject'];
        $message = $this->data['message'];
        $htmlContent = $this->data['htmlContent'];
        $pdfFilename = $this->data['pdfFilename'] ?? 'document.pdf';
        $paymentData = $this->data['paymentData'] ?? null;

        try {
            // Generar PDF según el tipo de correo
            if ($this->data['emailType'] === 'send_email_facture' && $paymentData) {
                $pdfData = $this->generate_pdf($paymentData);
                $pdfOutput = $pdfData['output'];
            } else {
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);
                $options->set('defaultFont', 'Arial');
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($htmlContent);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $pdfOutput = $dompdf->output();
            }

            $tempPdfPath = WRITEPATH . 'uploads/' . $pdfFilename;

            // Asegurar que el directorio existe
            if (!is_dir(WRITEPATH . 'uploads/')) {
                mkdir(WRITEPATH . 'uploads/', 0755, true);
            }

            file_put_contents($tempPdfPath, $pdfOutput);

            // Configurar email con múltiples opciones de configuración
            $email = service('email', null, false);

            // Configuración alternativa si Gmail falla
            // $this->configureEmailWithFallback($email);

            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message . '<br><br>' . $htmlContent);
            $email->attach($tempPdfPath);

            $result = $email->send(false);

            // Limpiar archivo temporal
            if (file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }

            if (!$result) {
                $debugInfo = $email->printDebugger(['headers']);
                log_message('error', 'Error al enviar email: ' . $debugInfo);
                throw new Exception('Error al enviar email: ' . $debugInfo);
            }

            log_message('info', 'Email enviado exitosamente a: ' . $to);
            return $result;

        } catch (Exception $e) {
            log_message('error', 'Error en Job Email: ' . $e->getMessage());

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

    public function generate_pdf($payment)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $pdf = new Dompdf($options);

        $html = view('email/facture', [
            'num_autorizacion' => $payment['num_autorizacion'],
            'user' => $payment['user'],
            'user_ic' => $payment['user_ic'],
            'fecha_emision' => $payment['fecha_emision'],
            'precio_unitario' => $payment['precio_unitario'],
            'valor_total' => $payment['valor_total'],
            'sub_total' => $payment['sub_total'],
            'sub_total_0' => $payment['sub_total_0'],
            'sub_total_15' => $payment['sub_total_15'],
            'iva' => $payment['iva'],
            'total' => $payment['total'],
            'email_user' => $payment['email_user'],
            'user_tel' => $payment['user_tel'],
            'operador' => $payment['operador'],
            'valor_final' => $payment['amount_pay'],
            'event_name' => $payment['event_name'],
            'metodo_pago' => $payment['metodo_pago'],
        ]);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $output = $pdf->output();

        return ['pdf' => $pdf, 'output' => $output];
    }
}