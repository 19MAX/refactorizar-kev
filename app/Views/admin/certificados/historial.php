<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Historial de Certificados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">

    <div class="content-header sty-one">
        <h1 class="text-black">Historial de certificados</h1>
        <ol class="breadcrumb">
            <li><a href="#">Inicio</a></li>
            <li class="sub-bread"><i class="fa fa-angle-right"></i> Historial de certificados</li>
        </ol>
    </div>

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Historial de Certificados Enviados</h3>
                        <a href="<?= base_url('admin/certificados/gestionar') ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($certificates)): ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                No se han enviado certificados aún.
                            </div>
                        <?php else: ?>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h4><?= count($certificates) ?></h4>
                                                    <p class="mb-0">Certificados Enviados</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fa fa-certificate fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h4><?= count(array_unique(array_column($certificates, 'event_name'))) ?>
                                                    </h4>
                                                    <p class="mb-0">Eventos Únicos</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fa fa-calendar fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h4><?= count(array_unique(array_filter(array_column($certificates, 'sent_by_name')))) ?>
                                                    </h4>
                                                    <p class="mb-0">Administradores</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fa fa-users fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="content">
        <div class="info-box">
            <div class="table-responsive">

                <table class="table datatable" id="historialTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha de Envío</th>
                            <th>Participante</th>
                            <th>Email</th>
                            <th>Evento</th>
                            <!-- <th>Modalidad</th> -->
                            <!-- <th>Enviado Por</th> -->
                            <th>Archivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificates as $cert): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-primary">
                                        <?= date('d/m/Y H:i', strtotime($cert['sent_at'])) ?>
                                    </span>
                                </td>
                                <td><?= esc($cert['user_name']) ?></td>
                                <td>
                                    <small><?= esc($cert['user_email']) ?></small>
                                </td>
                                <td><?= esc($cert['event_name']) ?></td>
                                <!-- <td>
                                    <?php if ($cert['event_modality']): ?>
                                        <span class="badge badge-info"><?= esc($cert['event_modality']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td> -->
                                <!-- <td>
                                    <?php if ($cert['sent_by_name']): ?>
                                        <?= esc($cert['sent_by_name']) ?>         <?= esc($cert['sent_by_lastname']) ?>
                                    <?php else: ?>
                                        <span class="text">Sistema</span>
                                    <?php endif; ?>
                                </td> -->
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="enviarCertificado(<?= $cert['registration_id'] ?>)"
                                        id="btn-<?= $cert['registration_id'] ?>">
                                        <i class="fa fa-envelope"></i> Reenviar Certificado
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>
    function enviarCertificado(registrationId) {
        const btn = document.getElementById('btn-' + registrationId);
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';

        fetch(`<?= base_url('admin/certificados/reenviar-certificado') ?>/${registrationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Actualizar la fila
                    const row = document.getElementById('row-' + registrationId);
                    const statusCell = row.cells[6];
                    const actionCell = row.cells[7];

                    statusCell.innerHTML = '<span class="badge badge-success"><i class="fa fa-check-circle"></i> Enviado</span>';
                    actionCell.innerHTML = '<button class="btn btn-secondary btn-sm" disabled><i class="fa fa-check"></i> Ya Enviado</button>';
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa fa-envelope"></i> Enviar Certificado';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error inesperado',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });

                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-envelope"></i> Enviar Certificado';
            });
    }
</script>

<?= $this->endSection() ?>