<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('title') ?>Subir Certificado<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1><i class="fa fa-upload"></i> Subir Nuevo Certificado</h1>
    </div>
    <div class="content">
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
        <form action="<?= base_url('admin/certificados/guardar') ?>" method="post" enctype="multipart/form-data" class="card p-4" style="max-width:480px;margin:auto;">
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label for="nombre_certificado">Nombre del Certificado</label>
                <input type="text" name="nombre_certificado" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="archivo_certificado">Archivo PDF / Imagen</label>
                <input type="file" name="archivo_certificado" class="form-control" accept="application/pdf,image/*" required>
            </div>
            <button class="btn btn-warning"><i class="fa fa-upload"></i> Subir</button>
            <a href="<?= base_url('admin/certificados') ?>" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
