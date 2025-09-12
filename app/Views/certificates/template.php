<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Participación</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: linear-gradient(135deg, <?= $config['primary_color'] ?>15 0%, <?= $config['secondary_color'] ?>15 100%);
            padding: 40px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .certificate-container {
            width: 100%;
            max-width: 800px;
            background: white;
            border: 8px solid <?= $config['primary_color'] ?>;
            border-radius: 15px;
            padding: 60px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
            text-align: center;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .certificate-container::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid <?= $config['secondary_color'] ?>;
            border-radius: 8px;
            pointer-events: none;
        }

        .header {
            margin-bottom: 30px;
        }

        .logo {
            max-width: 120px;
            max-height: 80px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: <?= $config['primary_color'] ?>;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .certificate-title {
            font-size: 48px;
            font-weight: bold;
            color: <?= $config['secondary_color'] ?>;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .certificate-subtitle {
            font-size: 24px;
            color: #666;
            margin-bottom: 30px;
            font-style: italic;
        }

        .recipient-section {
            margin: 40px 0;
        }

        .recipient-label {
            font-size: 20px;
            color: #666;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-size: 36px;
            font-weight: bold;
            color: <?= $config['primary_color'] ?>;
            border-bottom: 3px solid <?= $config['secondary_color'] ?>;
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .event-details {
            margin: 30px 0;
            line-height: 1.8;
        }

        .event-text {
            font-size: 18px;
            color: #444;
            margin-bottom: 15px;
        }

        .event-name {
            font-weight: bold;
            color: <?= $config['secondary_color'] ?>;
            font-size: 22px;
        }

        .event-info {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .info-item {
            text-align: center;
            margin: 10px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: <?= $config['primary_color'] ?>;
            margin-top: 5px;
        }

        .footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 40px;
        }

        .signature-line {
            border-top: 2px solid #333;
            width: 200px;
            text-align: center;
            padding-top: 10px;
        }

        .signature-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .date-section {
            text-align: right;
        }

        .date-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .date-value {
            font-size: 16px;
            font-weight: bold;
            color: <?= $config['primary_color'] ?>;
            margin-top: 5px;
        }

        .decorative-element {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, <?= $config['primary_color'] ?>, <?= $config['secondary_color'] ?>);
            opacity: 0.1;
        }

        .decorative-element.top-left {
            top: -30px;
            left: -30px;
        }

        .decorative-element.top-right {
            top: -30px;
            right: -30px;
        }

        .decorative-element.bottom-left {
            bottom: -30px;
            left: -30px;
        }

        .decorative-element.bottom-right {
            bottom: -30px;
            right: -30px;
        }

        @media print {
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Elementos decorativos -->
        <div class="decorative-element top-left"></div>
        <div class="decorative-element top-right"></div>
        <div class="decorative-element bottom-left"></div>
        <div class="decorative-element bottom-right"></div>

        <!-- Header -->
        <div class="header">
            <?php if (!empty($config['company_logo'])): ?>
                <img src="<?= base_url($config['company_logo']) ?>" alt="Logo" class="logo">
            <?php endif; ?>
            <div class="company-name"><?= $config['company_name'] ?></div>
        </div>

        <!-- Título del certificado -->
        <div class="certificate-title">Certificado</div>
        <div class="certificate-subtitle">de Participación</div>

        <!-- Sección del destinatario -->
        <div class="recipient-section">
            <div class="recipient-label">Se otorga el presente certificado a:</div>
            <div class="recipient-name"><?= $user_name ?></div>
        </div>

        <!-- Detalles del evento -->
        <div class="event-details">
            <div class="event-text">
                Por haber participado exitosamente en el evento:
            </div>
            <div class="event-name"><?= $event_name ?></div>
        </div>

        <!-- Información adicional del evento -->
        <div class="event-info">
            <?php if (!empty($event_date)): ?>
            <div class="info-item">
                <div class="info-label">Fecha</div>
                <div class="info-value"><?= date('d/m/Y', strtotime($event_date)) ?></div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($event_modality)): ?>
            <div class="info-item">
                <div class="info-label">Modalidad</div>
                <div class="info-value"><?= $event_modality ?></div>
            </div>
            <?php endif; ?>
            
            <div class="info-item">
                <div class="info-label">Fecha de Emisión</div>
                <div class="info-value"><?= date('d/m/Y') ?></div>
            </div>
        </div>

        <!-- Footer con firma y fecha -->
        <div class="footer">
            <div class="signature-line">
                <div class="signature-label">Dirección</div>
            </div>
            
            <div class="date-section">
                <div class="date-label">Emitido el</div>
                <div class="date-value"><?= date('d \d\e F \d\e Y') ?></div>
            </div>
        </div>
    </div>
</body>
</html>
