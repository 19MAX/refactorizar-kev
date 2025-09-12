<?= $this->extend('admin/layout/main'); ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Reportes de Asistencia</h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?= base_url('admin/asistencias') ?>">Asistencias</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>

    <section class="content">
        <!-- Filtros -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Filtros de Búsqueda</h3>
                    </div>
                    <div class="box-body">
                        <?= form_open('admin/asistencias/reportes', ['method' => 'GET', 'class' => 'form-horizontal']) ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Evento</label>
                                    <select name="evento_id" class="form-control">
                                        <option value="">Todos los eventos</option>
                                        <?php foreach($eventos as $evento): ?>
                                            <option value="<?= $evento['id'] ?>" <?= $filtros['evento_id'] == $evento['id'] ? 'selected' : '' ?>>
                                                <?= $evento['nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="fecha_inicio" class="form-control" value="<?= $filtros['fecha_inicio'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="fecha_fin" class="form-control" value="<?= $filtros['fecha_fin'] ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <?php if(isset($estadisticas) && $filtros['evento_id']): ?>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $estadisticas['presentes'] ?></h3>
                        <p>Presentes</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $estadisticas['ausentes'] ?></h3>
                        <p>Ausentes</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $estadisticas['tardanzas'] ?></h3>
                        <p>Tardanzas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3><?= $estadisticas['total_registros'] ?></h3>
                        <p>Total Registros</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Tabla de reportes -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Reporte de Asistencias</h3>
                        <div class="box-tools">
                            <?php if(!empty($asistencias)): ?>
                                <a href="<?= base_url('admin/asistencias/exportar?' . http_build_query($filtros)) ?>" 
                                   class="btn btn-success btn-sm">
                                    <i class="fa fa-download"></i> Exportar CSV
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <?php if(!empty($asistencias)): ?>
                            <div class="table-responsive">
                                <table id="tabla-reportes" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Evento</th>
                                            <th>Participante</th>
                                            <th>Cédula</th>
                                            <th>Email</th>
                                            <th>Estado</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($asistencias as $asistencia): ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($asistencia['fecha_asistencia'])) ?></td>
                                                <td><?= $asistencia['evento_nombre'] ?></td>
                                                <td><?= $asistencia['nombres'] . ' ' . $asistencia['apellidos'] ?></td>
                                                <td><?= $asistencia['cedula'] ?></td>
                                                <td><?= $asistencia['email'] ?></td>
                                                <td>
                                                    <span class="label label-<?= 
                                                        $asistencia['estado'] == 'presente' ? 'success' : 
                                                        ($asistencia['estado'] == 'ausente' ? 'danger' : 'warning') 
                                                    ?>">
                                                        <?= ucfirst($asistencia['estado']) ?>
                                                    </span>
                                                </td>
                                                <td><?= $asistencia['observaciones'] ?: '-' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No se encontraron registros de asistencia con los filtros aplicados.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#tabla-reportes').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "responsive": true,
        "order": [[0, "desc"]],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-danger btn-sm',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                className: 'btn btn-info btn-sm'
            }
        ]
    });
});
</script>
<?= $this->endSection() ?>