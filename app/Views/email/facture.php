<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Recaudación - DOCTRINA TECH</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 18px;
            color: #1e293b;
            background: #fff;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .factura-container {
            width: 100%;
            margin: 0;
            padding: 30px 20px;
            background: #fff;
            box-sizing: border-box;
        }
        .header-box {
            border-bottom: 4px solid #1e40af;
            margin-bottom: 25px;
            padding-bottom: 12px;
        }
        .empresa-nombre {
            font-size: 42px;
            color: #1e40af;
            font-weight: bold;
        }
        .empresa-datos {
            font-size: 18px;
            margin-top: 10px;
        }
        .autorizacion-box {
            margin-top: 12px;
            font-size: 15px;
        }
        .sri-title {
            font-size: 28px;
            color: #fff;
            background: #fbbf24;
            padding: 18px 0;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0 30px 0;
        }
        .datos-cliente, .curso-info {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 30px 35px;
            margin-bottom: 30px;
            font-size: 18px;
        }
        .datos-cliente-table td {
            padding: 8px 20px 8px 0;
        }
        .tabla-detalle {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 18px;
        }
        .tabla-detalle th {
            background: #1e40af;
            color: #fff;
            padding: 18px 12px;
            font-size: 20px;
        }
        .tabla-detalle td {
            border: 1px solid #ccc;
            padding: 15px 12px;
            text-align: left;
        }
        .totales {
            width: 400px;
            float: right;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .totales td {
            padding: 10px 18px;
            font-size: 16px;
        }
        .totales .label {
            background: #f3f4f6;
            font-weight: bold;
            color: #374151;
            text-align: right;
            width: 60%;
        }
        .totales .valor {
            background: #fff;
            text-align: right;
            color: #1e293b;
            width: 40%;
        }
        .total-row .label {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            font-weight: bold;
            font-size: 18px;
        }
        .total-row .valor {
            background: #fbbf24;
            color: #1e40af;
            font-weight: bold;
            font-size: 18px;
        }
        .pago-contacto-section {
            display: flex;
            gap: 35px;
            margin-top: 50px;
            margin-bottom: 30px;
        }
        .pago-box, .contacto-box {
            padding: 18px 25px;
            border-radius: 10px;
            font-size: 16px;
            flex: 1;
        }
        .pago-box {
            background: linear-gradient(135deg, #e0e7ff 60%, #bae6fd 100%);
            border: 1.5px solid #3b82f6;
        }
        .contacto-box {
            background: #fef9c3;
            border: 1.5px solid #fbbf24;
        }
        .pago-titulo, .contacto-titulo {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 12px;
            font-size: 17px;
        }
        .pago-metodo {
            color: #1e40af;
            font-weight: 600;
        }
        .aviso {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #fbbf24;
            color: #92400e;
            padding: 18px;
            border-radius: 10px;
            text-align: center;
            font-size: 16px;
            margin-top: 35px;
            font-weight: 500;
        }
        .clearfix { clear: both; }
    </style>
</head>
<body>
<div class="factura-container">
    <!-- Header -->
    <div class="header-box">
        <div class="empresa-nombre">DOCTRINA TECH</div>
        <div class="empresa-datos">
            RUC: 0201975844001<br>
            Fecha autorización: <?= esc($fecha_emision) ?><br>
            N° AUTORIZACIÓN: <span style="font-family:monospace;"><?= esc($num_autorizacion) ?></span>
        </div>
    </div>
    <div class="sri-title">COMPROBANTE DE RECAUDACIÓN</div>

    <!-- Datos del cliente -->
    <div class="datos-cliente">
        <table class="datos-cliente-table">
            <tr>
                <td><b>Cliente:</b></td>
                <td><?= esc($user) ?></td>
            </tr>
            <tr>
                <td><b>C.I./RUC:</b></td>
                <td><?= esc($user_ic) ?></td>
            </tr>
            <tr>
                <td><b>Fecha Emisión:</b></td>
                <td><?= date('d/m/Y', strtotime($fecha_emision)) ?></td>
            </tr>
        </table>
    </div>

    <!-- Tabla detalle -->
    <table class="tabla-detalle">
        <thead>
        <tr>
            <th>Cant.</th>
            <th>Descripción</th>
            <th>P. Unit</th>
            <th>V. Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Uso de plataforma</td>
            <td>$<?= number_format($precio_unitario, 2) ?></td>
            <td>$<?= number_format($valor_total, 2) ?></td>
        </tr>
        <tr>
            <td>1</td>
            <td>Inscripción</td>
            <td>$<?= number_format($sub_total_0, 2) ?></td>
            <td>$<?= number_format($sub_total_0, 2) ?></td>
        </tr>
        </tbody>
    </table>

    <!-- Curso -->
    <div class="curso-info">
        <b>Inscripción en el curso:</b> <?= esc($event_name) ?>
    </div>

    <!-- Totales -->
    <table class="totales">
        <tr>
            <td class="label">Sub Total:</td>
            <td class="valor">$<?= number_format($sub_total, 2) ?></td>
        </tr>
        <tr>
            <td class="label">Sub Total 0%:</td>
            <td class="valor">$<?= number_format($sub_total_0, 2) ?></td>
        </tr>
        <tr>
            <td class="label">Sub Total 15%:</td>
            <td class="valor">$<?= number_format($sub_total_15, 2) ?></td>
        </tr>
        <tr>
            <td class="label">IVA 15%:</td>
            <td class="valor">$<?= number_format($iva, 2) ?></td>
        </tr>
        <tr class="total-row">
            <td class="label">TOTAL:</td>
            <td class="valor">$<?= number_format($valor_final, 2) ?></td>
        </tr>
    </table>
    <div class="clearfix"></div>

    <!-- Forma de pago y contacto -->
    <div class="pago-contacto-section">
        <div class="pago-box">
            <div class="pago-titulo">FORMA DE PAGO</div>
            <div class="pago-metodo">
                <?php
                if ($metodo_pago == 1) echo 'PAGO CON DEPÓSITO';
                elseif ($metodo_pago == 2) echo 'SIN UTILIZACIÓN DEL SISTEMA FINANCIERO';
                elseif ($metodo_pago == 3) echo 'PAGO EN LÍNEA CON TARJETA';
                ?>
            </div>
        </div>
        <div class="contacto-box">
            <div class="contacto-titulo">DATOS DE CONTACTO</div>
            <div><b>Email:</b> <?= esc($email_user) ?></div>
            <div><b>Contacto:</b> <?= esc($user_tel) ?></div>
            <div><b>Operador:</b> <?= esc(isset($operador) ? $operador : 'Payphone') ?></div>
        </div>
    </div>

    <!-- Aviso -->
    <div class="aviso">
        <b>Documento sin valor tributario</b>, en breve será emitido su comprobante electrónico.<br>
        Revise la carpeta de spam si no lo encuentra en su bandeja principal.
    </div>
</div>
</body>
</html>