<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Certificados Subidos<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header sty-one d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fa fa-certificate"></i> Certificados Subidos</h1>
        <a href="<?= base_url('admin/certificados/nuevo') ?>" class="btn btn-warning shadow-sm">
            <i class="fa fa-upload"></i> Subir nuevo certificado
        </a>
    </div>
    <div class="content">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <!-- Barra de búsqueda personalizada -->
                    <input type="text" id="buscadorCertificados" class="form-control" style="max-width: 300px;" placeholder="Buscar certificado...">
                </div>
                <div class="table-responsive rounded">
                    <table id="certificadosTable" class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="align-middle text-center">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Archivo</th>
                                <th>Subido por</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($certificados as $i => $c): ?>
                            <tr>
                                <td class="text-center"><?= $i+1 ?></td>
                                <td><?= esc($c['nombre_certificado']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('uploads/certificados/' . $c['archivo_certificado']) ?>" 
                                       target="_blank" 
                                       class="btn btn-link text-danger" 
                                       data-bs-toggle="tooltip" title="Ver archivo">
                                        <i class="fa fa-file-pdf-o fa-lg"></i> Ver
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?= esc($c['usuario_id']) ?></span>
                                </td>
                                <td class="text-center"><?= esc($c['fecha_subida']) ?></td>
                                <td class="text-center">
                                    <a class="btn btn-outline-primary btn-sm" 
                                       href="<?= base_url('uploads/certificados/' . $c['archivo_certificado']) ?>" 
                                       download data-bs-toggle="tooltip" title="Descargar">
                                        <i class="fa fa-download"></i> Descargar
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#certificadosTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/2.0.7/i18n/es-ES.json"
        },
        "dom": "t<'row align-items-center'<'col-md-6'i><'col-md-6'p>>", // Quitamos search por defecto
        "pageLength": 10
    });

    // Buscador personalizado
    $('#buscadorCertificados').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Tooltips Bootstrap 5
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
<?= $this->endSection() ?>


