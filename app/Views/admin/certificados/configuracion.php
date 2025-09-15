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
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Configuración de Empresa para Certificados</h3>
                        <div>
                            <button type="button" class="btn btn-info mr-2" data-toggle="modal"
                                data-target="#previewModal">
                                <i class="fa fa-eye"></i> Vista Previa
                            </button>
                            <a href="<?= base_url('admin/certificados/gestionar') ?>" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/certificados/guardar-configuracion') ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="row">
                                <!-- Información de la Empresa -->
                                <div class="col-md-6">
                                    <h5 class="mb-3 text-primary">Información de la Empresa</h5>

                                    <div class="form-group">
                                        <label for="company_name">Nombre de la Empresa *</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="<?= old('company_name', $config['company_name'] ?? '') ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="company_logo">Logo de la Empresa</label>
                                        <input type="file" class="form-control" id="company_logo" name="company_logo"
                                            accept="image/*">
                                        <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Tamaño recomendado:
                                            150x100 px</small>
                                    </div>
                                </div>

                                <!-- Colores y Diseño -->
                                <div class="col-md-6">
                                    <h5 class="mb-3 text-primary">Colores y Diseño</h5>

                                    <div class="form-group">
                                        <label for="primary_color">Color Primario *</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color"
                                                id="primary_color_picker"
                                                value="<?= old('primary_color', $config['primary_color'] ?? '#007bff') ?>">
                                            <input type="text" class="form-control" id="primary_color"
                                                name="primary_color"
                                                value="<?= old('primary_color', $config['primary_color'] ?? '#007bff') ?>"
                                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-palette"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formato hexadecimal (ej: #161616)</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="secondary_color">Color Secundario *</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color"
                                                id="secondary_color_picker"
                                                value="<?= old('secondary_color', $config['secondary_color'] ?? '#6c757d') ?>">
                                            <input type="text" class="form-control" id="secondary_color"
                                                name="secondary_color"
                                                value="<?= old('secondary_color', $config['secondary_color'] ?? '#6c757d') ?>"
                                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-palette"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formato hexadecimal (ej: #161616)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Elementos del Certificado -->
                                <div class="col-md-6">
                                    <h5 class="mb-3 text-primary">Elementos del Certificado</h5>

                                    <div class="form-group">
                                        <label for="signature_image">Firma del Certificado</label>
                                        <input type="file" class="form-control" id="signature_image"
                                            name="signature_image" accept="image/*">
                                        <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Tamaño recomendado:
                                            300x100 px</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3 text-primary">Sello y Validación</h5>

                                    <div class="form-group">
                                        <label for="sello_image">Sello del Certificado</label>
                                        <input type="file" class="form-control" id="sello_image" name="sello_image"
                                            accept="image/*">
                                        <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Tamaño recomendado:
                                            200x200 px</small>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-save"></i> Guardar Configuración
                                    </button>
                                    <button type="button" class="btn btn-info ml-2" data-toggle="modal"
                                        data-target="#previewModal">
                                        <i class="fa fa-eye"></i> Vista Previa
                                    </button>
                                </div>
                                <a href="<?= base_url('admin/certificados/gestionar') ?>" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Vista Previa -->
<div class="modal fade bd-example-modal-lg" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Vista Previa del Certificado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="certificate-preview" id="certificatePreview">
                    <div class="preview-certificate">
                        <!-- Header con Logo y Número de Certificado -->
                        <div class="preview-header">
                            <div class="preview-header-left">
                                <?php if (!empty($config['company_logo'])): ?>
                                    <img src="<?= base_url($config['company_logo']) ?>" alt="Logo" class="preview-logo"
                                        id="preview-logo">
                                <?php else: ?>
                                    <div class="preview-logo-placeholder" id="preview-logo-placeholder">LOGO</div>
                                <?php endif; ?>
                            </div>
                            <div class="preview-header-right">
                                <div class="certificate-number">
                                    <span class="cert-number-label">Certificado N°</span>
                                    <span class="cert-number">2024-001</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nombre de la empresa -->
                        <div class="preview-company-name" id="preview-company-name">
                            <?= esc($config['company_name'] ?? 'NOMBRE DE LA EMPRESA') ?>
                        </div>

                        <!-- Título del certificado -->
                        <div class="preview-title">CERTIFICADO</div>
                        <div class="preview-subtitle">de Participación</div>

                        <!-- Contenido del certificado -->
                        <div class="preview-content">
                            <div class="preview-recipient">
                                <div class="preview-label">Se otorga el presente certificado a:</div>
                                <div class="preview-name">JUAN CARLOS PÉREZ GARCÍA</div>
                            </div>
                            <div class="preview-event">
                                <div class="preview-text">Por haber participado exitosamente en el evento:</div>
                                <div class="preview-event-name">CURSO DE DESARROLLO WEB AVANZADO</div>
                                <!-- <div class="preview-date">Realizado del 15 al 20 de Octubre de 2024</div>
                                <div class="preview-hours">Con una duración de 40 horas académicas</div> -->
                            </div>
                        </div>

                        <!-- Footer con Firma y Sello -->
                        <div class="preview-footer">
                            <div class="preview-signature-section">
                                <?php if (!empty($config['signature_image'])): ?>
                                    <img src="<?= base_url($config['signature_image']) ?>" alt="Firma"
                                        class="preview-signature" id="preview-signature">
                                <?php else: ?>
                                    <div class="preview-signature-placeholder" id="preview-signature-placeholder">
                                        <div class="signature-line"></div>
                                        <small>Firma del Director</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="preview-seal-section">
                                <?php if (!empty($config['sello_image'])): ?>
                                    <img src="<?= base_url($config['sello_image']) ?>" alt="Sello" class="preview-seal"
                                        id="preview-seal">
                                <?php else: ?>
                                    <div class="preview-seal-placeholder" id="preview-seal-placeholder">SELLO</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="printCertificate()">
                    <i class="fa fa-print"></i> Imprimir Vista Previa
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Elementos del formulario
        const primaryColorPicker = document.getElementById('primary_color_picker');
        const primaryColorInput = document.getElementById('primary_color');
        const secondaryColorPicker = document.getElementById('secondary_color_picker');
        const secondaryColorInput = document.getElementById('secondary_color');
        const companyNameInput = document.getElementById('company_name');
        const companyLogoInput = document.getElementById('company_logo');
        const signatureInput = document.getElementById('signature_image');
        const selloInput = document.getElementById('sello_image');

        // Sincronizar color picker con input de texto
        function syncColorInputs() {
            // Primary color
            primaryColorPicker.addEventListener('input', function () {
                primaryColorInput.value = this.value;
                updatePreview();
            });

            primaryColorInput.addEventListener('input', function () {
                if (isValidHex(this.value)) {
                    primaryColorPicker.value = this.value;
                    updatePreview();
                }
            });

            // Secondary color
            secondaryColorPicker.addEventListener('input', function () {
                secondaryColorInput.value = this.value;
                updatePreview();
            });

            secondaryColorInput.addEventListener('input', function () {
                if (isValidHex(this.value)) {
                    secondaryColorPicker.value = this.value;
                    updatePreview();
                }
            });
        }

        // Validar formato hexadecimal
        function isValidHex(hex) {
            return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(hex);
        }

        // Actualizar vista previa
        function updatePreview() {
            const root = document.documentElement;

            // Actualizar colores CSS
            root.style.setProperty('--preview-primary', primaryColorInput.value);
            root.style.setProperty('--preview-secondary', secondaryColorInput.value);

            // Actualizar nombre de la empresa
            const companyNameElement = document.getElementById('preview-company-name');
            if (companyNameElement) {
                companyNameElement.textContent = companyNameInput.value || 'NOMBRE DE LA EMPRESA';
            }
        }

        // Manejar carga de imágenes
        function handleImagePreview(input, previewId, placeholderId) {
            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (preview) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        if (placeholder) {
                            placeholder.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Inicializar event listeners
        syncColorInputs();

        // Event listeners para actualización en tiempo real
        companyNameInput.addEventListener('input', updatePreview);

        // Manejar preview de imágenes
        if (companyLogoInput) {
            handleImagePreview(companyLogoInput, 'preview-logo', 'preview-logo-placeholder');
        }
        if (signatureInput) {
            handleImagePreview(signatureInput, 'preview-signature', 'preview-signature-placeholder');
        }
        if (selloInput) {
            handleImagePreview(selloInput, 'preview-seal', 'preview-seal-placeholder');
        }

        // Inicializar colores
        updatePreview();
    });

    // Función para imprimir certificado
    function printCertificate() {
        const printContent = document.getElementById('certificatePreview').innerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
        <html>
            <head>
                <title>Vista Previa - Certificado</title>
                <style>
                    :root {
                        --preview-primary: ${document.getElementById('primary_color').value};
                        --preview-secondary: ${document.getElementById('secondary_color').value};
                    }
                    ${document.querySelector('style').innerHTML}
                    body { margin: 20px; }
                    .certificate-preview { border: none; background: white; }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
        </html>
    `);
        printWindow.document.close();
        printWindow.print();
    }
</script>

<style>
    :root {
        --preview-primary:
            <?= $config['primary_color'] ?? '#007bff' ?>
        ;
        --preview-secondary:
            <?= $config['secondary_color'] ?? '#6c757d' ?>
        ;
    }

    /* Estilos del formulario */
    .form-control-color {
        width: 50px !important;
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    .input-group .form-control-color+.form-control {
        border-left: none;
        border-radius: 0;
    }

    /* Estilos de la vista previa del certificado */
    .certificate-preview {
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .preview-certificate {
        background: white;
        border: 6px solid var(--preview-primary);
        border-radius: 12px;
        padding: 40px;
        position: relative;
        min-height: 600px;
        max-width: 800px;
        margin: 0 auto;
        box-shadow: inset 0 0 0 3px var(--preview-secondary);
    }

    .preview-certificate::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border: 2px solid var(--preview-secondary);
        border-radius: 6px;
        opacity: 0.3;
    }

    /* Header */
    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        position: relative;
        z-index: 2;
    }

    .preview-header-left {
        flex: 1;
    }

    .preview-header-right {
        text-align: right;
    }

    .preview-logo {
        max-width: 120px;
        max-height: 80px;
        object-fit: contain;
    }

    .preview-logo-placeholder {
        width: 120px;
        height: 80px;
        background: var(--preview-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
    }

    .certificate-number {
        background: var(--preview-secondary);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .cert-number-label {
        display: block;
        font-size: 10px;
        opacity: 0.8;
    }

    .cert-number {
        display: block;
        font-size: 14px;
        margin-top: 2px;
    }

    /* Contenido */
    .preview-company-name {
        font-size: 24px;
        font-weight: bold;
        color: var(--preview-primary);
        text-align: center;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .preview-title {
        font-size: 36px;
        font-weight: bold;
        color: var(--preview-secondary);
        text-transform: uppercase;
        letter-spacing: 3px;
        text-align: center;
        margin: 20px 0 10px 0;
    }

    .preview-subtitle {
        font-size: 18px;
        color: #666;
        font-style: italic;
        text-align: center;
        margin-bottom: 30px;
    }

    .preview-content {
        margin: 40px 0;
        text-align: center;
    }

    .preview-label {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
    }

    .preview-name {
        font-size: 28px;
        font-weight: bold;
        color: var(--preview-primary);
        border-bottom: 3px solid var(--preview-secondary);
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0 25px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .preview-text {
        font-size: 14px;
        color: #444;
        margin-bottom: 10px;
    }

    .preview-event-name {
        font-weight: bold;
        color: var(--preview-secondary);
        font-size: 20px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .preview-date,
    .preview-hours {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }

    /* Footer */
    .preview-footer {
        display: flex;
        justify-content: space-between;
        align-items: end;
        margin-top: 40px;
        position: relative;
        z-index: 2;
    }

    .preview-signature-section,
    .preview-seal-section {
        flex: 1;
        text-align: center;
    }

    .preview-signature {
        max-width: 200px;
        max-height: 60px;
        object-fit: contain;
    }

    .preview-signature-placeholder {
        width: 150px;
        margin: 0 auto;
    }

    .signature-line {
        width: 100%;
        height: 2px;
        background: var(--preview-secondary);
        margin-bottom: 5px;
    }

    .preview-seal {
        max-width: 100px;
        max-height: 100px;
        object-fit: contain;
        opacity: 0.8;
    }

    .preview-seal-placeholder {
        width: 80px;
        height: 80px;
        border: 3px solid var(--preview-secondary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-weight: bold;
        color: var(--preview-secondary);
        font-size: 12px;
        opacity: 0.7;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .preview-certificate {
            padding: 25px;
            min-height: 500px;
        }

        .preview-header {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .preview-title {
            font-size: 28px;
        }

        .preview-name {
            font-size: 20px;
        }

        .preview-footer {
            flex-direction: column;
            gap: 20px;
        }
    }

    @media print {
        .certificate-preview {
            border: none !important;
            background: white !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
    }
</style>
<?= $this->endSection() ?>