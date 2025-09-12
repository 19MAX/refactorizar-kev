<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Gestionar Certificados
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-wrapper">

    <div class="content-header sty-one">
        <h1 class="text-black">Certificados</h1>
        <ol class="breadcrumb">
            <li><a href="#">Inicio</a></li>
            <li class="sub-bread"><i class="fa fa-angle-right"></i>Gestionar Certificados</li>
        </ol>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-success" onclick="enviarCertificadosMasivo()" id="btnEnviarMasivo">
                                <i class="fa fa-envelope"></i> Enviar Todos los Certificados
                            </button>
                            <a href="<?= base_url('admin/certificados/configuracion') ?>" class="btn btn-secondary">
                                <i class="fa fa-cog"></i> Configuración
                            </a>
                            <a href="<?= base_url('admin/certificados/historial') ?>" class="btn btn-info">
                                <i class="fa fa-history"></i> Historial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="info-box">

            <?php if (empty($users)): ?>
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i>
                    No hay usuarios con pagos completados disponibles para envío de certificados.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table datatable" id="certificatesTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombres</th>
                                <th class="exclude-view">Email</th>
                                <th>Evento</th>
                                <th>Categoría</th>
                                <th class="exclude-view">Método de Pago</th>
                                <th>Estado de envio</th>
                                <th class="exclude-column">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr id="row-<?= $user['id'] ?>">
                                    <td><?= esc($user['ic']) ?></td>
                                    <td><?= esc($user['full_name_user']) ?></td>
                                    <td>
                                        <small><?= esc($user['email']) ?></small>
                                    </td>
                                    <td><?= esc($user['evento']) ?></td>
                                    <td>
                                        <span class="badge badge-info"><?= esc($user['categoria']) ?></span>
                                    </td>
                                    <td><?= esc($user['metodo_pago']) ?></td>
                                    <td>
                                        <?php if ($user['certificate_sent']): ?>
                                            <span class="badge badge-success">
                                                <i class="fa fa-check-circle"></i> Enviado
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">
                                                <i class="fa fa-clock"></i> Pendiente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!$user['certificate_sent']): ?>
                                            <button class="btn btn-primary btn-sm" onclick="enviarCertificado(<?= $user['id'] ?>)"
                                                id="btn-<?= $user['id'] ?>">
                                                <i class="fa fa-envelope"></i> Enviar Certificado
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fa fa-check"></i> Ya Enviado
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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

        fetch(`<?= base_url('admin/certificados/enviar') ?>/${registrationId}`, {
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

    function enviarCertificadosMasivo() {
        Swal.fire({
            title: '¿Enviar todos los certificados?',
            text: 'Se enviarán certificados a todos los usuarios con pagos completados que no hayan recibido su certificado aún.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, enviar todos',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                const btn = document.getElementById('btnEnviarMasivo');
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';

                fetch(`<?= base_url('admin/certificados/enviar-masivo') ?>`, {
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
                            }).then(() => {
                                // Recargar la página para actualizar el estado
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }

                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-envelope-bulk"></i> Enviar Todos los Certificados';
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
                        btn.innerHTML = '<i class="fa fa-envelope-bulk"></i> Enviar Todos los Certificados';
                    });
            }
        });
    }
</script>

<!-- Estilos adicionales -->
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .table th {
        background-color: #343a40;
        color: white;
        border-color: #454d55;
    }

    .badge {
        font-size: 0.875em;
    }

    .btn-sm {
        font-size: 0.8rem;
    }

    .alert {
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: stretch;
        }

        .card-header>div {
            margin-top: 1rem;
        }

        .btn {
            margin-bottom: 0.5rem;
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>