<!DOCTYPE html>
<html lang="es">

<head>
<style>
    body {
    background-image: url('<?= base_url("assets/images/logo-ep.png") ?>');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: contain; /* Muestra toda la imagen sin recortar */
    background-attachment: fixed;
    background-color: #ffffff; /* Opcional: color de fondo por si la imagen no cubre todo */
}

</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url("app-assets/vendors/css/vendors.min.css")?>">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url("app-assets/css/bootstrap.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("app-assets/css/bootstrap-extended.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("app-assets/css/colors.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("app-assets/css/components.css")?>">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url("app-assets/css/plugins/forms/form-validation.css")?>">

    <link rel="stylesheet" type="text/css" href="<?= base_url("app-assets/css/pages/page-auth.css") ?>">

    <!-- Notificaciones CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <?= $this->renderSection('styles'); ?>
</head>
<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>
    <!-- BEGIN: Vendor JS-->
    <script src="<?=base_url("app-assets/vendors/js/vendors.min.js")?>"></script>
    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="<?=base_url()?>app-assets/vendors/js/ui/jquery.sticky.js"></script> -->
    <script src="<?=base_url("app-assets/vendors/js/forms/validation/jquery.validate.min.js")?>"></script>
    <!-- BEGIN: Theme JS-->
    <script src="<?=base_url("app-assets/js/core/app-menu.js")?>"></script>
    <script src="<?=base_url("app-assets/js/core/app.js")?>"></script>

    <!-- Notificaciones JS-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="<?= base_url('assets/js/flashMessages.js') ?>"></script>
    <script>
        var flashMessages = <?= getFlashMessages(isset($flashMessages) ? $flashMessages : null, true) ?>;
        for (let element in flashMessages) {
            showFlashMessage(flashMessages[element][0], flashMessages[element][1]);
        }
    </script>
    <?= $this->renderSection('scripts'); ?>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>

</html>