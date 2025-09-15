<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificado de Participación</title>
  <style>
    @page {
      margin: 0px;
    }

    body {
      font-family: 'Georgia', 'Times New Roman', serif;
      font-size: 14px;
      margin: 0;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      box-sizing: border-box;
    }

    .certificate-container {
      background: white;
      border: 8px solid
        <?= $config['primary_color'] ?>
      ;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      position: relative;
      overflow: hidden;
      margin: 20px;
    }

    .certificate-container::before {
      content: '';
      position: absolute;
      top: 15px;
      left: 15px;
      right: 15px;
      bottom: 15px;
      border: 2px solid
        <?= $config['secondary_color'] ?>
      ;
      border-radius: 8px;
      pointer-events: none;
    }

    .certificate-number {
      position: absolute;
      top: 25px;
      right: 25px;
      font-size: 10px;
      color: white;
      background:
        <?= $config['primary_color'] ?>
      ;
      padding: 5px 10px;
      border: 1px solid
        <?= $config['secondary_color'] ?>
      ;
      border-radius: 5px;
      z-index: 3;
      font-weight: bold;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      position: relative;
      z-index: 2;
    }

    .logo {

      position: absolute;
      max-height: 80px;
      max-width: 200px;
      top: 20px;
      left: 30px;
      /* margin-bottom: 15px; */
      /* position: relative; */
      /* z-index: 3; */
    }

    .company-name {
      font-size: 24px;
      font-weight: bold;
      color:
        <?= $config['primary_color'] ?>
      ;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .certificate-title {
      font-size: 32px;
      font-weight: bold;
      color:
        <?= $config['secondary_color'] ?>
      ;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 3px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .content {
      text-align: center;
      /* margin: 40px 0; */
      position: relative;
      z-index: 2;
    }

    .certifies-text {
      font-size: 16px;
      color:
        <?= $config['secondary_color'] ?>
      ;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    .participant-name {
      font-size: 30px;
      font-weight: bold;
      color:
        <?= $config['primary_color'] ?>
      ;
      margin: 20px 0;
      text-decoration: underline;
      text-decoration-color:
        <?= $config['secondary_color'] ?>
      ;
      text-underline-offset: 8px;
      text-decoration-thickness: 3px;
      text-transform: uppercase;
    }

    .event-name {
      font-size: 22px;
      font-weight: bold;
      color:
        <?= $config['secondary_color'] ?>
      ;
      margin: 15px 0;
      font-style: italic;
    }

    .info-box {
      background-color: #f8f9fa;
      border-left: 5px solid
        <?= $config['primary_color'] ?>
      ;
      padding: 20px;
      margin: 30px 0;
      border-radius: 0 10px 10px 0;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table.no-border,
    .table.no-border th,
    .table.no-border td {
      border: none;
    }

    .info-item {
      background-color: white;
      border: 1px solid rgba(<?= hexdec(substr($config['primary_color'], 1, 2)) ?>,
          <?= hexdec(substr($config['primary_color'], 3, 2)) ?>
          ,
          <?= hexdec(substr($config['primary_color'], 5, 2)) ?>
          , 0.3);
      padding: 10px 15px;
      margin: 8px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .info-item strong {
      color:
        <?= $config['secondary_color'] ?>
      ;
      font-size: 12px;
      display: block;
      margin-bottom: 5px;
    }

    .footer {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 60px;
      position: relative;
      z-index: 2;
    }


    .item-section {
      background-color: white;
      padding: 10px 15px;
      margin: 8px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .signature-line {
      border-bottom: 3px solid
        <?= $config['primary_color'] ?>
      ;
      width: 200px;
      margin: 15px auto 10px auto;
    }

    .signature-title {
      color:
        <?= $config['secondary_color'] ?>
      ;
      font-weight: bold;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="certificate-container">

    <?php if (isset($config['company_logo']) && file_exists($config['company_logo'])): ?>
      <img src="<?=base_url($config['company_logo'])?>" alt="Logo" class="logo">
    <?php endif; ?>
    <!-- Número de certificado -->
    <div class="certificate-number">
      Certificado N°: <?= $certificate_number ?? 'CERT-2025-001' ?><br>
      Fecha: <?= date('d/m/Y', strtotime($issue_date ?? date('Y-m-d'))) ?>
    </div>

    <div class="header">
      <div class="company-name"><?= $config['company_name'] ?? 'Academia del Futuro' ?></div>
      <div class="certificate-title">Certificado de Participación</div>
    </div>

    <div class="content">
      <p class="certifies-text">Se certifica que</p>
      <div class="participant-name"><?= $participant_name ?? 'Nombre del Participante' ?></div>
      <p class="certifies-text">ha participado exitosamente en el</p>
      <div class="event-name"><?= $event_name ?? 'Nombre del Evento' ?></div>

      <div class="info-box">
        <table class="table no-border">
          <tr>
            <td style="width: 25%;">
              <div class="info-item">
                <strong>Duración:</strong>
                <?= $event_duration ?? '0' ?> horas académicas
              </div>
            </td>
            <td style="width: 25%;">
              <div class="info-item">
                <strong>Modalidad:</strong>
                <?= $event_modality ?? 'Virtual' ?>
              </div>
            </td>
            <td style="width: 25%;">
              <div class="info-item">
                <strong>Fecha del Evento:</strong>
                <?= date('d/m/Y', strtotime($event_date ?? date('Y-m-d'))) ?>
              </div>
            </td>
            <td style="width: 25%;">
              <div class="info-item">
                <strong>Ciudad:</strong>
                <?= $city ?? 'Guayaquil' ?>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>


    <footer>

      <table class="table no-border">
        <tr>
          <td style="width: 25%;">
            <div class="item-section">

              <?php if (isset($config['signature_image']) && file_exists($config['signature_image'])): ?>
                <img src="<?=base_url( $config['signature_image']) ?>" alt="Firma"
                  style="max-height: 40px; margin-bottom: 5px;"><br>
              <?php endif; ?>
              <div class="signature-line"></div>
              <div class="signature-title">Director Académico</div>
            </div>
          </td>
          <td style="width: 25%;">
            <div class="item-section">
              <?php if (isset($config['sello_image']) && file_exists($config['sello_image'])): ?>
                <img src="<?= base_url($config['sello_image']) ?>" alt="Sello" style="max-height: 40px; margin-bottom: 5px;"><br>
              <?php endif; ?>
              <div class="signature-line"></div>
              <div class="signature-title">Sello de la Institución</div>
            </div>
          </td>
        </tr>
      </table>
      <div class="footer">
      </div>
    </footer>
  </div>
</body>

</html>