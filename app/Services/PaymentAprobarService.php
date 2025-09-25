<?php

namespace App\Services;

use App\Models\ConfigModel;
use App\Models\PaymentsModel;
use App\Models\PaymentMethodsModel;
use App\Services\EmailApi;
use CodeIgniter\I18n\Time;
use PaymentStatus;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class PaymentAprobarService
{
    protected $paymentsModel;
    protected $paymentMethodModel;
    protected $configModel;
    protected $emailApi;

    public function __construct()
    {
        $this->paymentsModel = new PaymentsModel();
        $this->paymentMethodModel = new PaymentMethodsModel();
        $this->configModel = new ConfigModel();
        $this->emailApi = new EmailApi();
    }

    public function approvePayment($paymentId, $userId, $metodoPago)
    {
        helper('ramdom');
        $uniqueCode = generateUniqueNumericCode(50);

        $payment = $this->paymentsModel->pagoData($paymentId);
        // Obtener el valor de additional_charge
        $additional_charge = $this->configModel->getAdditionalCharge();

        if (!$payment) {
            return ['success' => false, 'message' => 'Pago no encontrado'];
        }

        // Validación para evitar el reenvío de email si ya se envió
        if ($payment['send_email'] == 1) {
            return ['success' => false, 'message' => 'El email ya ha sido enviado previamente'];
        }

        $local = $this->paymentMethodModel->paymentLocal(2);
        if (!$local) {
            return ['success' => false, 'message' => 'Método de pago físico desactivado'];
        }

        $local = $this->paymentMethodModel->paymentLocal(3);
        if (!$local) {
            return ['success' => false, 'message' => 'Método de pago en linea desactivado'];
        }

        $datosPago = $this->calculatePaymentDetails($payment['precio'], $uniqueCode, $additional_charge, $metodoPago);

        try {
            $this->paymentsModel->updatePaymentAndInsertInscripcionPago($paymentId, $datosPago, $userId);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error en la actualización del pago: ' . $e->getMessage()];
        }

        $emailResult = $this->generateAndSendPDF($uniqueCode);
        if (!$emailResult['success']) {
            return ['success' => false, 'message' => 'Error al generar o enviar el PDF: ' . $emailResult['message']];
        }

        return ['success' => true, 'message' => 'Pago aprobado y email enviado correctamente', 'uniqueCode' => $uniqueCode];
    }

    protected function calculatePaymentDetails($precio, $uniqueCode, $adicional, $metodoPago)
    {
        $cantidad = 1;
        $fecha_emision = Time::now();
        $precio_unitario = $adicional / 1.15;
        $sub_total_0 = $precio - $adicional;
        $subtotal = $sub_total_0 + $precio_unitario;
        $subtotal_15 = $precio_unitario;
        $iva_15 = $precio_unitario * 0.15;
        $total = $precio_unitario + $iva_15;

        return [
            "num_autorizacion" => $uniqueCode,
            "date_time_payment" => $fecha_emision,
            "payment_status" => PaymentStatus::Completado,
            "amount_pay" => $precio,
            "precio_unitario" => $precio_unitario,
            "sub_total" => $subtotal,
            "sub_total_0" => $sub_total_0,
            "sub_total_15" => $subtotal_15,
            "iva" => $iva_15,
            "valor_total" => $precio_unitario,
            "total" => $total,
            "payment_method_id" => $metodoPago,
        ];
    }

    protected function generateAndSendPDF($num_autorizacion)
    {
        $payment = $this->paymentsModel->numeroAutorizacion($num_autorizacion);
        if (!$payment) {
            return ['success' => false, 'message' => 'Pago no encontrado'];
        }

        try {
            // Generar el PDF
            $pdfResult = $this->generate_pdf($payment);
            if (!$pdfResult['success']) {
                return ['success' => false, 'message' => 'Error al generar PDF: ' . $pdfResult['message']];
            }

            // Guardar el PDF directamente en el directorio público
            $pdfInfo = $this->savePdfToSystem($pdfResult['output'], $num_autorizacion);
            if (!$pdfInfo) {
                return ['success' => false, 'message' => 'Error al guardar PDF en el sistema'];
            }

            // Preparar datos para el envío por API
            $subject = 'Comprobante de Pago - ' . $payment['event_name'];
            $message = $this->buildEmailMessage($payment);
            $userEmail = $payment['email_user'];

            // Enviar el archivo físico para que el API lo procese con FormData
            $attachments = [$pdfInfo['path']]; // Solo enviar la ruta física

            log_message('debug', 'Preparando envío de email', [
                'archivo_fisico' => $pdfInfo['path'],
                'archivo_url' => $pdfInfo['url'],
                'destinatario' => $userEmail,
                'archivo_existe' => file_exists($pdfInfo['path'])
            ]);

            // Enviar email usando la API directamente al usuario
            $emailResult = $this->emailApi->sendEmail($subject, $message, $attachments, $userEmail);

            if ($emailResult['status']) {
                // Marcar como email enviado en la base de datos
                $this->paymentsModel->update($payment['id'], ['send_email' => 1]);
                log_message('info', 'Comprobante de pago enviado exitosamente a: ' . $userEmail);
                return ['success' => true, 'message' => 'Email enviado correctamente'];
            } else {
                log_message('error', 'Error al enviar comprobante de pago: ' . $emailResult['message']);
                return ['success' => false, 'message' => 'Error al enviar email: ' . $emailResult['message']];
            }

        } catch (Exception $e) {
            log_message('error', 'Error en generateAndSendPDF: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error interno: ' . $e->getMessage()];
        }
    }

    /**
     * Prepara el archivo para el API según el entorno
     */
    protected function prepareAttachmentForApi($filePath, $num_autorizacion)
    {
        // Verificar que el archivo existe
        if (!file_exists($filePath)) {
            log_message('error', 'Archivo no existe: ' . $filePath);
            return false;
        }

        // En desarrollo, usar ruta física
        if (ENVIRONMENT === 'development') {
            log_message('debug', 'Desarrollo: usando ruta física - ' . $filePath);
            return $filePath;
        }

        // En producción, crear copia en directorio público y usar URL
        try {
            $publicDir = FCPATH . 'uploads/comprobantes/';
            if (!is_dir($publicDir)) {
                mkdir($publicDir, 0755, true);
            }

            $filename = 'comprobante_' . $num_autorizacion . '_' . date('YmdHis') . '.pdf';
            $publicPath = $publicDir . $filename;

            // Copiar archivo a directorio público
            if (copy($filePath, $publicPath)) {
                $publicUrl = base_url('uploads/comprobantes/' . $filename);
                log_message('info', 'Producción: archivo copiado a URL pública - ' . $publicUrl);
                return $publicUrl;
            } else {
                log_message('error', 'No se pudo copiar archivo a directorio público');
                return false;
            }

        } catch (Exception $e) {
            log_message('error', 'Error preparando attachment para API: ' . $e->getMessage());
            return false;
        }
    }

    protected function generate_pdf($payment)
    {
        try {
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
                'operador' => $payment['operador'] ?? 'Payphone',
                'valor_final' => $payment['amount_pay'],
                'event_name' => $payment['event_name'],
                'metodo_pago' => $payment['metodo_pago'],
            ]);

            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();

            $output = $pdf->output();

            return ['success' => true, 'output' => $output];

        } catch (Exception $e) {
            log_message('error', 'Error generando PDF: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Guarda el PDF directamente en el directorio público y retorna la ruta
     */
    protected function savePdfToSystem($pdfOutput, $num_autorizacion)
    {
        try {
            // Crear directorio público si no existe
            $uploadsDir = FCPATH . 'uploads/comprobantes/';
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }

            // Generar nombre único para el archivo
            $filename = 'comprobante_' . $num_autorizacion . '_' . date('YmdHis') . '.pdf';

            // Ruta completa del archivo
            $filePath = $uploadsDir . $filename;

            // Guardar archivo
            if (file_put_contents($filePath, $pdfOutput) !== false) {
                log_message('info', 'PDF guardado exitosamente: ' . $filePath);

                // Verificar que el archivo se creó correctamente
                if (file_exists($filePath)) {
                    $fileSize = filesize($filePath);
                    log_message('info', 'Archivo verificado - tamaño: ' . $fileSize . ' bytes');

                    // Retornar la URL accesible del archivo
                    $fileUrl = base_url('uploads/comprobantes/' . $filename);
                    log_message('info', 'URL del archivo: ' . $fileUrl);

                    return [
                        'path' => $filePath,      // Ruta física del archivo
                        'url' => $fileUrl,       // URL accesible del archivo
                        'filename' => $filename   // Solo el nombre del archivo
                    ];
                } else {
                    log_message('error', 'Archivo no existe después de guardarlo: ' . $filePath);
                    return false;
                }
            }

            log_message('error', 'No se pudo escribir el archivo: ' . $filePath);
            return false;

        } catch (Exception $e) {
            log_message('error', 'Error guardando PDF: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Construye el mensaje HTML del email
     */
    protected function buildEmailMessage($payment)
    {
        $message = "
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Comprobante de Pago</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background-color: #f4f4f4; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .details { background-color: #f9f9f9; padding: 15px; border-left: 4px solid #007cba; margin: 20px 0; }
                .details ul { list-style: none; padding: 0; }
                .details li { padding: 5px 0; }
                .details strong { color: #007cba; }
                .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>Comprobante de Pago</h2>
            </div>
            <div class='content'>
                <p>Estimado/a <strong>{$payment['user']}</strong>,</p>
                <p>Le confirmamos que hemos procesado su pago exitosamente para el evento <strong>{$payment['event_name']}</strong>.</p>

                <div class='details'>
                    <h3>Detalles del Pago:</h3>
                    <ul>
                        <li><strong>Número de Autorización:</strong> {$payment['num_autorizacion']}</li>
                        <li><strong>Evento:</strong> {$payment['event_name']}</li>
                        <li><strong>Fecha de Emisión:</strong> {$payment['fecha_emision']}</li>
                        <li><strong>Monto Pagado:</strong> $" . number_format($payment['amount_pay'], 2) . "</li>
                        <li><strong>Método de Pago:</strong> {$payment['metodo_pago']}</li>
                        <li><strong>Cédula/ID:</strong> {$payment['user_ic']}</li>
                        <li><strong>Operador:</strong> " . ($payment['operador'] ?? 'Sistema') . "</li>
                    </ul>
                </div>

                <p>Adjunto encontrará su comprobante de pago en formato PDF con todos los detalles fiscales correspondientes.</p>
                <p><strong>Importante:</strong> Conserve este comprobante como respaldo de su transacción.</p>

                <p>Gracias por su confianza y participación.</p>
            </div>
            <div class='footer'>
                <p>Este es un mensaje automático, por favor no responda a este correo.</p>
                <p>Si tiene alguna consulta, póngase en contacto con nuestro equipo de soporte.</p>
            </div>
        </body>
        </html>";

        return $message;
    }

    /**
     * Método opcional para limpiar archivos antiguos
     * Se puede llamar desde un cron job o tarea programada
     */
    public function cleanOldPdfFiles($daysOld = 30)
    {
        $uploadsDir = WRITEPATH . 'uploads/comprobantes/';
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
                    log_message('info', 'Archivo PDF antiguo eliminado: ' . $file);
                }
            }
        }

        log_message('info', "Limpieza de archivos PDF completada. {$deletedCount} archivos eliminados.");
        return $deletedCount;
    }
}