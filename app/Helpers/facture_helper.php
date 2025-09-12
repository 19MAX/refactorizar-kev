<?php

use Dompdf\Dompdf;
use Dompdf\Options;

if (!function_exists('generate_pdf')) {
    function generate_pdf($payment)
    {
        // Configurar las opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');
        $options->set('defaultFontSize', 12); // Tamaño de fuente más grande para facturas normales

        // Crear una nueva instancia de Dompdf con las opciones configuradas
        $pdf = new Dompdf($options);

        // Contenido HTML de la factura
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

        // Configurar tamaño de papel A4 (210 x 297 mm) - Factura normal
        $pdf->setPaper('A4', 'portrait');
        
        // Alternativas de tamaños si prefieres otros formatos:
        // $pdf->setPaper('LETTER', 'portrait'); // Carta US (216 x 279 mm)
        // $pdf->setPaper('LEGAL', 'portrait');  // Legal US (216 x 356 mm)

        // Renderizar el PDF
        $pdf->render();

        // Obtener la salida del PDF como una cadena
        $output = $pdf->output();

        // Devolver tanto el objeto Dompdf como el contenido del PDF
        return ['pdf' => $pdf, 'output' => $output];
    }
}
