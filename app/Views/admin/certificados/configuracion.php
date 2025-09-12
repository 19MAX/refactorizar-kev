<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Configuración de Certificados
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">

    <div class="content-header sty-one">
        <h1 class="text-black">Configuración de Certificados</h1>
        <ol class="breadcrumb">
            <li><a href="#">Inicio</a></li>
            <li class="sub-bread"><i class="fa fa-angle-right"></i> Configuración de Certificados</li>
        </ol>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Configuración de Empresa para Certificados</h3>
                        <a href="<?= base_url('admin/certificados/gestionar') ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/certificados/guardar-configuracion') ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Nombre de la Empresa *</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="<?= old('company_name', $config['company_name']) ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_logo">Logo de la Empresa</label>
                                        <input type="file" class="form-control" id="company_logo" name="company_logo"
                                            accept="image/*">
                                        <?php if (!empty($config['company_logo'])): ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url($config['company_logo']) ?>" alt="Logo actual"
                                                    class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primary_color">Color Primario *</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control" id="primary_color"
                                                name="primary_color"
                                                value="<?= old('primary_color', $config['primary_color']) ?>" required>
                                            <div class="input-group-append">
                                                <span
                                                    class="input-group-text"><?= old('primary_color', $config['primary_color']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="secondary_color">Color Secundario *</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control" id="secondary_color"
                                                name="secondary_color"
                                                value="<?= old('secondary_color', $config['secondary_color']) ?>"
                                                required>
                                            <div class="input-group-append">
                                                <span
                                                    class="input-group-text"><?= old('secondary_color', $config['secondary_color']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Guardar Configuración
                                </button>
                                <a href="<?= base_url('admin/certificados/gestionar') ?>" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="certificate-preview" id="certificatePreview">
                            <div class="preview-certificate">
                                <div class="preview-header">
                                    <?php if (!empty($config['company_logo'])): ?>
                                        <img src="<?= base_url($config['company_logo']) ?>" alt="Logo" class="preview-logo">
                                    <?php endif; ?>
                                    <div class="preview-company-name"><?= esc($config['company_name']) ?>
                                    </div>
                                </div>
                                <div class="preview-title">CERTIFICADO</div>
                                <div class="preview-subtitle">de Participación</div>
                                <div class="preview-content">
                                    <div class="preview-recipient">
                                        <div class="preview-label">Se otorga el presente certificado a:
                                        </div>
                                        <div class="preview-name">NOMBRE DEL PARTICIPANTE</div>
                                    </div>
                                    <div class="preview-event">
                                        <div class="preview-text">Por haber participado exitosamente en el
                                            evento:</div>
                                        <div class="preview-event-name">NOMBRE DEL EVENTO</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>
    // Actualizar vista previa cuando cambian los colores o el nombre
    document.addEventListener('DOMContentLoaded', function () {
        const primaryColor = document.getElementById('primary_color');
        const secondaryColor = document.getElementById('secondary_color');
        const companyName = document.getElementById('company_name');

        function updatePreview() {
            const preview = document.getElementById('certificatePreview');
            const root = document.documentElement;
            root.style.setProperty('--preview-primary', primaryColor.value);
            root.style.setProperty('--preview-secondary', secondaryColor.value);

            const companyNameElement = preview.querySelector('.preview-company-name');
            if (companyNameElement) {
                companyNameElement.textContent = companyName.value || 'Nombre de la Empresa';
            }

            // Actualizar texto del input group
            document.querySelector('#primary_color + .input-group-append .input-group-text').textContent = primaryColor.value;
            document.querySelector('#secondary_color + .input-group-append .input-group-text').textContent = secondaryColor.value;
        }

        primaryColor.addEventListener('input', updatePreview);
        secondaryColor.addEventListener('input', updatePreview);
        companyName.addEventListener('input', updatePreview);

        // Inicializar colores
        updatePreview();
    });
</script>

<style>
    :root {
        --preview-primary:
            <?= $config['primary_color'] ?>
        ;
        --preview-secondary:
            <?= $config['secondary_color'] ?>
        ;
    }

    .certificate-preview {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        background: #f8f9fa;
        margin-bottom: 20px;
    }

    .preview-certificate {
        background: white;
        border: 4px solid var(--preview-primary);
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        position: relative;
        min-height: 300px;
        max-width: 500px;
        margin: 0 auto;
    }

    .preview-certificate::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid var(--preview-secondary);
        border-radius: 4px;
    }

    .preview-logo {
        max-width: 60px;
        max-height: 40px;
        margin-bottom: 10px;
    }

    .preview-company-name {
        font-size: 16px;
        font-weight: bold;
        color: var(--preview-primary);
        margin-bottom: 15px;
    }

    .preview-title {
        font-size: 24px;
        font-weight: bold;
        color: var(--preview-secondary);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 10px 0;
    }

    .preview-subtitle {
        font-size: 14px;
        color: #666;
        font-style: italic;
        margin-bottom: 20px;
    }

    .preview-content {
        margin: 20px 0;
    }

    .preview-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }

    .preview-name {
        font-size: 18px;
        font-weight: bold;
        color: var(--preview-primary);
        border-bottom: 2px solid var(--preview-secondary);
        display: inline-block;
        padding: 5px 10px;
        margin: 5px 0 15px 0;
    }

    .preview-text {
        font-size: 11px;
        color: #444;
        margin-bottom: 8px;
    }

    .preview-event-name {
        font-weight: bold;
        color: var(--preview-secondary);
        font-size: 14px;
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
    }

    .img-thumbnail {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 4px;
    }

    .input-group-text {
        min-width: 80px;
        font-family: monospace;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .preview-certificate {
            padding: 20px;
            min-height: 250px;
        }

        .preview-title {
            font-size: 20px;
        }

        .preview-name {
            font-size: 16px;
        }
    }
</style>
<?= $this->endSection() ?>