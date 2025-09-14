<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4 landscape; margin: 0; }
  html, body { margin:0; padding:0; font-family: Arial, sans-serif; color:#111; }
  * { box-sizing: border-box; }

  .page { width: 297mm; height: 210mm; padding: 6mm; }
  .card { width: 100%; height: 198mm; border-collapse: collapse; table-layout: fixed;
          border: 0.7mm solid <?= $config['primary_color'] ?? '#2563eb' ?>; border-radius:6mm; }
  .frame-cell { border-radius:6mm; overflow:hidden; }
  .layout { width:100%; height:198mm; border-collapse:collapse; table-layout:fixed; }

  .row-header { height: 30mm; border-bottom: 0.8mm solid <?= $config['primary_color'] ?? '#2563eb' ?>; }
  .row-body   { height: 142mm; }  /* ↓ dejamos 6mm extra para firmas */
  .row-footer { height: 26mm; }

  .cell { vertical-align: middle; }
  .logo-cell{ width:45mm; padding-left:10mm; }
  .brand-cell{ text-align:center; }
  .void-cell{ width:45mm; }
  .logo img{ max-height:16mm; max-width:35mm; }
  .company{ margin:0; font-weight:700; font-size:18pt; letter-spacing:2px;
            color:<?= $config['primary_color'] ?? '#2563eb' ?>; text-transform:uppercase; }
  .subtitle{ margin:2mm 0 0 0; font-size:9pt; color:#666; letter-spacing:1.6px; text-transform:uppercase; }

  .body-cell{ text-align:center; padding: 0 18mm; }
  .title{ font-size:30pt; font-weight:800; letter-spacing:6px; color:<?= $config['primary_color'] ?? '#2563eb' ?>; text-transform:uppercase; margin:8mm 0 4mm; }
  .line{ width:85mm; height:1.2mm; background:<?= $config['primary_color'] ?? '#2563eb' ?>; margin:0 auto 8mm; }
  .lead{ font-size:12pt; color:#666; margin:0 0 6mm; }
  .name-box{ display:inline-block; min-width:120mm; padding:6mm 10mm; border:0.9mm solid <?= $config['secondary_color'] ?? '#eab308' ?>;
             color:<?= $config['secondary_color'] ?? '#eab308' ?>; border-radius:4mm; font-size:20pt; font-weight:700;
             text-transform:uppercase; margin-bottom:8mm; background:rgba(234,179,8,.08); }
  .event-lead{ font-size:11pt; color:#666; margin:6mm 0 4mm; }
  .event-name{ display:inline-block; font-size:14pt; font-weight:700; color:<?= $config['primary_color'] ?? '#2563eb' ?>;
               border-bottom:0.8mm solid <?= $config['primary_color'] ?? '#2563eb' ?>; padding:0 2mm 2mm; }
  .details{ margin-top:10mm; }
  .pill{ display:inline-block; margin:0 4mm 4mm; padding:3mm 6mm; border-radius:3mm; border:0.5mm solid <?= $config['primary_color'] ?? '#2563eb' ?>;
         font-size:10pt; font-weight:700; }
  .pill.sec{ border-color:<?= $config['secondary_color'] ?? '#eab308' ?>; color:<?= $config['secondary_color'] ?? '#eab308' ?>; }

  /* ===== Mini grid 12 columnas (solo ancho porcentual, seguro para Dompdf) ===== */
  table.grid { width:100%; border-collapse:collapse; table-layout:fixed; }
  .col-1{width:8.333%}.col-2{width:16.666%}.col-3{width:25%}.col-4{width:33.333%}.col-5{width:41.666%}
  .col-6{width:50%}.col-7{width:58.333%}.col-8{width:66.666%}.col-9{width:75%}.col-10{width:83.333%}.col-11{width:91.666%}.col-12{width:100%}
  .gcell{ vertical-align:top; padding: 0 4mm; }

  /* Footer */
  .footer-cell{ padding: 0 18mm 6mm; }
  .issued{ border-top:0.3mm solid #ddd; padding-top:2mm; color:#999; font-size:8.5pt; text-align:center; }
  .seal{ display:inline-block; border:0.8mm solid <?= $config['primary_color'] ?? '#2563eb' ?>; color:<?= $config['primary_color'] ?? '#2563eb' ?>;
         font-size:9pt; font-weight:800; text-transform:uppercase; padding:3mm 6mm; border-radius:3mm; background:#fff; }
  .sig{ border-top:0.3mm solid #bbb; margin-top:6mm; padding-top:1.5mm; font-size:9pt; text-align:center; }
  .no-break{ page-break-inside:avoid; }
</style>
</head>
<body>
<div class="page">
  <table class="card no-break" role="presentation">
    <tr><td class="frame-cell">
      <table class="layout" role="presentation">
        <!-- HEADER -->
        <tr class="row-header">
          <td class="cell logo-cell">
            <div class="logo">
              <?php if(!empty($config['company_logo'])): ?>
                <img src="<?= base_url($config['company_logo']) ?>" alt="Logo">
              <?php endif; ?>
            </div>
          </td>
          <td class="cell brand-cell">
            <h1 class="company"><?= $config['company_name'] ?? 'Doctrina Tech' ?></h1>
            <div class="subtitle">Certificado de participación</div>
          </td>
          <td class="cell void-cell"></td>
        </tr>

        <!-- BODY -->
        <tr class="row-body">
          <td colspan="3" class="cell body-cell">
            <div class="title">CERTIFICADO</div>
            <div class="line"></div>
            <div class="lead">Se certifica que</div>
            <div class="name-box"><?= $user_name ?></div>
            <div class="event-lead">Ha participado exitosamente en el evento</div>
            <div class="event-name"><?= $event_name ?></div>

            <div class="details">
              <?php if(!empty($event_date)): ?>
                <span class="pill"><strong>FECHA:</strong> <?= date('d/m/Y', strtotime($event_date)) ?></span>
              <?php endif; ?>
              <?php if(!empty($event_modality)): ?>
                <span class="pill sec"><strong>MODALIDAD:</strong> <?= ucfirst($event_modality) ?></span>
              <?php endif; ?>
            </div>

            <!-- Ejemplo de fila con “grid” 12 cols: dos firmas + espacio -->
            <table class="grid" style="margin-top:12mm;" role="presentation">
              <tr>
                <td class="gcell col-5">
                  <div class="sig">_____________________________<br>Responsable Académico</div>
                </td>
                <td class="gcell col-2"></td>
                <td class="gcell col-5">
                  <div class="sig">_____________________________<br>Dirección</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- FOOTER -->
        <tr class="row-footer">
          <td colspan="3" class="cell footer-cell">
            <table class="grid" role="presentation">
              <tr>
                <td class="gcell col-4" style="text-align:left;">
                  <span class="seal">Certificado Oficial</span>
                </td>
                <td class="gcell col-4" style="text-align:center;">
                  <div class="issued">
                    <?php setlocale(LC_TIME,'es_ES.UTF-8','es_ES','es'); echo strftime('Emitido el %d de %B de %Y'); ?>
                  </div>
                </td>
                <td class="gcell col-4" style="text-align:right;"></td>
              </tr>
            </table>
          </td>
        </tr>

      </table>
    </td></tr>
  </table>
</div>
</body>
</html>
