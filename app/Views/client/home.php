<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Inicio</title>
    <link rel="icon" href="<?= base_url("assets/images/logo-ep.png"); ?>" type="image/jpeg">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.css") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url("assets/css/home.css") ?>">
    <!-- Payphone -->
    <link rel="stylesheet" href="<?= base_url("assets/css/payphone.css") ?>">
    <!-- Preloader -->
    <link rel="stylesheet" href="<?= base_url("assets/css/preloader.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/whatsapp.css") ?>">
    <script type="text/javascript">
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Preloader HTML -->
    <div id="preloader" style="display: none;">
        <div class="spinner"></div>
        <p class="loading-text">Cargando<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
        </p>
    </div>

    <style>
        .no-events {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            text-align: center;
            font-size: 1.5rem;
            color: #555;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .no-events h2 {
            color: #0C244B;
        }

        .no-events p {
            color: #888;
        }
    </style>
<main class="flex-grow-1" style="background-color: #f0f4fa;">
    <!-- Enhanced Navigation Bar -->
    <nav class="navbar navbar-expand-lg shadow-lg" style="background: linear-gradient(135deg, #0C244B 0%, #1a3b6d 100%);">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand ms-lg-4 d-flex align-items-center" href="">
                <h4 class="mb-0 fw-bold text-white" style="letter-spacing: 1px; text-shadow: 0px 2px 3px rgba(0,0,0,0.2);">
                    <span style="color: #FFD700;">DOCTRINA</span> TECH
                </h4>
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" 
                style="border: 2px solid #FFD700;">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Items -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Collection Points Button -->
                    <li class="nav-item mx-2">
                        <button title="Puntos de Recaudación" 
                            class="btn me-2 mb-2 mb-lg-0 rounded-pill px-4 py-2 fw-bold"
                            style="background: linear-gradient(to right, #FFD700, #FFC107); color: #0C244B; box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3); transform: translateY(0); transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 12px rgba(255, 215, 0, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(255, 215, 0, 0.3)';"
                            data-bs-toggle="modal" data-bs-target="#modalPuntosRecaudacion" type="button">
                            <i class="fa-solid fa-location-dot me-2"></i> PUNTOS DE RECAUDACIÓN
                        </button>
                    </li>
                    
                    <!-- Bank Information Button -->
                    <li class="nav-item mx-2">
                        <button title="Información Bancaria" 
                            class="btn me-2 mb-2 mb-lg-0 rounded-pill px-4 py-2 fw-bold"
                            style="background: linear-gradient(to right, #ffffff, #f0f0f0); color: #0C244B; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.3); transform: translateY(0); transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 12px rgba(255, 255, 255, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(255, 255, 255, 0.3)';"
                            data-bs-toggle="modal" data-bs-target="#modalCuentasBancarias" type="button">
                            <i class="fa-solid fa-circle-info me-2"></i> INFORMACIÓN BANCARIA
                        </button>
                    </li>
                    
                    <!-- Check Voucher Button -->
                    <!-- <li class="nav-item mx-2">
                        <button title="Consultar Voucher"
                            class="btn mb-2 mb-lg-0 rounded-pill px-4 py-2 fw-bold position-relative overflow-hidden"
                            style="background: linear-gradient(to right, #0C244B, #1a3b6d); color: white; border: 2px solid #FFD700; box-shadow: 0 4px 8px rgba(12, 36, 75, 0.4); transform: translateY(0); transition: all 0.3s ease;" 
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 12px rgba(12, 36, 75, 0.5)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(12, 36, 75, 0.4)';"
                            data-bs-toggle="modal" data-bs-target="#modalVoucher" type="button">
                            <i class="fa-solid fa-file-pdf me-2"></i> CONSULTAR VOUCHER
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate__animated animate__pulse animate__infinite">
                                <i class="fa-solid fa-bell"></i>
                            </span>
                        </button>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Logo Section -->
    <div class="mb-4 py-4" style="background: linear-gradient(to bottom, #ffffff, #f0f4fa);">
        <div class="text-center">
            <img src="<?= base_url("assets/images/logo-ep.png"); ?>" alt="" height="120px" class="img-fluid animate__animated animate__fadeIn" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
        </div>
    </div>

    <!-- Courses Section -->
    <section class="container flex-grow-1 d-flex pb-5">
        <div class="row flex-grow-1">
            <?php if (empty($events)): ?>
                <div class="no-events pt-5 text-center animate__animated animate__fadeIn">
                    <div class="bg-white p-5 rounded-4 shadow-lg">
                        <i class="fa-solid fa-calendar-xmark fa-4x mb-3" style="color: #0C244B;"></i>
                        <h2 class="fw-bold" style="color: #0C244B;">No hay cursos registrados</h2>
                        <p class="lead">Actualmente no hay cursos disponibles. Por favor, vuelve más tarde.</p>
                        <button class="btn btn-lg rounded-pill px-4 py-2 mt-3 fw-bold animate__animated animate__pulse animate__infinite"
                            style="background: linear-gradient(to right, #FFD700, #FFC107); color: #0C244B; box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);">
                            <i class="fa-solid fa-bell me-2"></i> Notificarme cuando haya nuevos cursos
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($events as $key => $event): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 p-3 animate__animated animate__fadeIn" style="animation-delay: calc(<?= $key ?> * 0.1s);">
                        <div class="bg-white shadow-lg rounded-4 h-100 overflow-hidden" style="transition: all 0.3s ease; transform: translateY(0);" 
                            onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.15)';" 
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">
                            
                            <!-- Course Image -->
                            <figure class="p-0 m-0 position-relative">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge rounded-pill px-3 py-2" 
                                        style="background-color: <?= $event['modality'] == 'Virtual' ? '#0C244B' : ($event['modality'] == 'Hibrida' ? '#FFD700' : '#28a745') ?>; 
                                        color: <?= $event['modality'] == 'Hibrida' ? '#0C244B' : 'white' ?>; 
                                        font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                        <?= $event['modality'] ?>
                                    </span>
                                </div>
                                <img src="<?= base_url("") . $event['image']; ?>" alt="Imagen del Curso"
                                    class="img-fluid w-100 rounded-4" style="height: 180px; object-fit: cover;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-3" 
                                    style="background: linear-gradient(0deg, rgba(12, 36, 75, 0.8) 0%, rgba(12, 36, 75, 0) 100%);">
                                    <div class="date__start__content text-white fw-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                        <i class="fa-regular fa-calendar-days me-2"></i><?= $event['formatted_event_date'] ?>
                                    </div>
                                </div>
                            </figure>
                            
                            <!-- Logo -->
                            
                            <!-- Course Info -->
                            <section class="px-3 pt-2 pb-3">
                                <div class="row g-2 mb-3">
                                    <?php if ($event['modality'] == 'Virtual' || $event['modality'] == 'Hibrida'): ?>
                                        <div class="col-6">
                                            <div class="bg-light rounded-3 p-2 h-100 text-center" style="border-left: 4px solid #FFD700;">
                                                <p class="mb-1 fw-bold" style="color: #0C244B; font-size: 0.8rem;"><i class="fa-regular fa-clock me-1"></i> DURACIÓN</p>
                                                <span class="fw-bold" style="color: #1a3b6d;"><?= $event['event_duration'] ?> Horas</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php
$ciudad = strtolower(trim($event['address'])); // Asegura que sea minúscula y sin espacios
?>

<?php if ($ciudad === 'Guaranda'): ?>
    <div class="col-12">
        <div class="bg-light rounded-3 p-2 h-100 text-center" style="border-left: 4px solid #0C244B;">
            <p class="mb-1 fw-bold" style="color: #0C244B; font-size: 0.8rem;">
                <i class="fa fa-map-marker me-1"></i> CIUDAD: GUARANDA
            </p>
            <span class="fw-bold" style="color: #1a3b6d;">
                <?= esc($event['address']) ?>
            </span>
        </div>
    </div>

<?php elseif ($ciudad === 'Quito'): ?>
    <div class="col-12">
        <div class="bg-light rounded-3 p-2 h-100 text-center" style="border-left: 4px solid #FFD700;">
            <p class="mb-1 fw-bold" style="color: #FFD700; font-size: 0.8rem;">
                <i class="fa fa-map-marker me-1"></i> CIUDAD: QUITO
            </p>
            <span class="fw-bold" style="color: #1a3b6d;">
                <?= esc($event['address']) ?>
            </span>
        </div>
    </div>

<?php else: ?>
    <div class="col-12">
        <div class="bg-light rounded-3 p-2 h-100 text-center" style="border-left: 4px solid #28a745;">
            <p class="mb-1 fw-bold" style="color: #28a745; font-size: 0.8rem;">
                <i class="fa fa-map-marker me-1"></i> CIUDAD
            </p>
            <span class="fw-bold" style="color: #1a3b6d;">
                <?= esc($event['address']) ?>
            </span>
        </div>
    </div>
<?php endif; ?>

                                
                                <!-- Buttons -->
                                <div class="pt-2 pb-1 d-flex flex-column gap-2">
                                    <button class="btn btn-danger fw-bold py-2 rounded-pill position-relative overflow-hidden"
                                        style="background: linear-gradient(45deg, #ff3547, #ff5252); box-shadow: 0 4px 8px rgba(255, 53, 71, 0.3); transform: translateY(0); transition: all 0.3s ease;"
                                        onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 12px rgba(255, 53, 71, 0.4)';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(255, 53, 71, 0.3)';"
                                        data-bs-toggle="modal" data-bs-target="#modalInscripcion" 
                                        data-evento="<?= $event['event_name'] ?>" data-event-id="<?= $event['id'] ?>" type="button">
                                        <i class="fa-solid fa-user-plus me-2"></i> INSCRIBIRSE
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning" style="color: #0C244B;">
                                            <i class="fa-solid fa-star"></i>
                                        </span>
                                    </button>
                                    
                                    <button class="btn fw-bold py-2 rounded-pill"
                                        style="background: linear-gradient(45deg, #FFD700, #FFC107); color: #0C244B; box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3); transform: translateY(0); transition: all 0.3s ease;"
                                        onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 12px rgba(255, 215, 0, 0.4)';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(255, 215, 0, 0.3)';"
                                        type="button" data-bs-toggle="modal" data-bs-target="#modalMetodo">
                                        <i class="fa-solid fa-credit-card me-2"></i> PAGAR AHORA
                                    </button>
                                </div>
                            </section>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
        
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Responsive adjustments */
        @media (min-width: 550px) and (max-width: 767.98px) {
            .col-12.col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        /* Modal styles */
        .modal-lg {
            max-width: 900px;
        }
        
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #0C244B 0%, #1a3b6d 100%);
            color: white;
            border-bottom: 3px solid #FFD700;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* List styles */
        .list-unstyled li {
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        
        .list-unstyled li:hover {
            background-color: rgba(12, 36, 75, 0.05);
        }
        
        .list-unstyled li:last-child {
            border-bottom: none;
        }
        
        /* Custom colors */
        .text-primary-dt {
            color: #0C244B !important;
        }
        
        .text-secondary-dt {
            color: #FFD700 !important;
        }
        
        .bg-primary-dt {
            background-color: #0C244B !important;
        }
        
        .bg-secondary-dt {
            background-color: #FFD700 !important;
        }
        
        /* Animation for buttons */
        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 215, 0, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0);
            }
        }
        
        .pulse-button {
            animation: pulse-border 2s infinite;
        }
    </style>
</main>
    <!-- Modal de Puntos de Recaudación -->
    <div class="modal fade" id="modalPuntosRecaudacion" tabindex="-1" aria-labelledby="modalPuntosRecaudacionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalPuntosRecaudacionLabel">
                        <i class="fa-solid fa-location-dot"></i> Puntos de Recaudación
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Sucursal Principal -->
                        <div class="col-md-12">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-img-wrapper">
                                    <img src="<?= base_url('assets/images/oficina_principal.jpeg') ?>"
                                        alt="Oficina principal" class="card-img-top sucursal-img">
                                    <div class="img-overlay">
                                        <h6 class="text-white mb-0">Softec</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-home rounded-circle p-3 me-3">
                                            <i class="fa-solid fa-building text-white fs-4"></i>
                                        </div>
                                        <h5 class="card-title mb-0">Oficina Principal (Softec)</h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fa-solid fa-location-arrow text-home me-2"></i>
                                            C. 7 de mayo y C. olmedo, Guaranda
                                        </li>
                                        <li class="mb-2">
                                            <i class="fa-solid fa-clock text-home me-2"></i>
                                            Lunes a Viernes 8:00 - 18:00
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-phone text-home me-2"></i>
                                            (+593) 989026071
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Sucursal Secundaria -->
                        <!-- <div class="col-md-6">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-img-wrapper">
                                    <img src="/api/placeholder/800/400" alt="Sucursal Secundaria"
                                        class="card-img-top sucursal-img">
                                    <div class="img-overlay">
                                        <h6 class="text-white mb-0">Sucursal Campus</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle p-3 me-3">
                                            <i class="fa-solid fa-building-columns text-white fs-4"></i>
                                        </div>
                                        <h5 class="card-title mb-0">Campus UEB</h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fa-solid fa-location-arrow text-success me-2"></i>
                                            Av. Universitaria y Aurelio Espinoza Pólit
                                        </li>
                                        <li class="mb-2">
                                            <i class="fa-solid fa-clock text-success me-2"></i>
                                            Lunes a Viernes: 9:00 AM - 4:00 PM
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-phone text-success me-2"></i>
                                            (593) 3-228-0948
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Cuentas Bancarias -->
    <div class="modal fade" id="modalCuentasBancarias" tabindex="-1" aria-labelledby="modalCuentasBancariasLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <!-- style="background: linear-gradient(to right, #BC157C, #FFD700); color: white;" -->
                    <h5 class="modal-title" id="modalCuentasBancariasLabel"><i class="fa-solid fa-circle-info"></i> Información de Cuentas Bancarias</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col">
                            <h5 class="text-center mb-3">Cuenta Bancaria</h5>
                            <div class="table-responsive text-start">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr style="background:#BC157C;">
                                            <th class="text-white" scope="row">Banco</th>
                                            <td class="text-white">Banco de Guayaquil</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tipo de Cuenta</th>
                                            <td>Corriente</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nombre</th>
                                            <td>SOFTEC WEBSTORE S.A.S</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Cuenta Bancaria</th>
                                            <td>0029421609</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">RUC</th>
                                            <td>0291525784001</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- <div class="col">
                            <h5 class="text-center mb-3">Cuenta Bancaria 2</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Banco</th>
                                            <td>[Nombre del segundo banco]</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tipo de Cuenta</th>
                                            <td>[Tipo de cuenta]</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nombre</th>
                                            <td>[Nombre del titular]</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Cuenta Bancaria</th>
                                            <td>[Número de cuenta]</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">RUC</th>
                                            <td>[Número de RUC]</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de inscripción -->
    <div class="modal fade" id="modalInscripcion" tabindex="-1" aria-labelledby="modalInscripcionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInscripcionLabel">Inscripción al Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formInscripcion">
                        <input type="hidden" id="eventoId" name="eventoId">
                        <div class="mb-3">
                            <label for="nombreEvento" class="form-label">Nombre del Curso</label>
                            <input type="text" class="form-control" id="nombreEvento" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="numeroCedula" class="form-label">Número de Cédula/Ruc</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fas fa-id-card"></i></div>

                                <input type="text" class="form-control numTex" id="numeroCedula" name="numeroCedula"
                                    required>
                            </div>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Inscribirse</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de registro de usuario -->
    <div class="modal fade" id="modalRegistroUsuario" tabindex="-1" aria-labelledby="modalRegistroUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegistroUsuarioLabel">Registro de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formRegistroUsuario">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="numeroCedulaRegistro" class="form-label">Número de Cédula</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                    <input type="text" class="form-control" id="numeroCedulaRegistro"
                                        name="numeroCedula" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label for="nombres" class="form-label">Nombres</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="telefono" class="form-label">Número de teléfono o celular</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="direccion" class="form-label">Dirección</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="email" class="form-label">Genero</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fa-solid fa-venus-mars"></i></div>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option value="0">Masculino</option>
                                        <option value="1">Femenino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="formRegistroUsuario" type="submit" class="btn btn-primary">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de detalles del evento -->
    <div class="modal fade" id="modalDetallesEvento" tabindex="-1" aria-labelledby="modalDetallesEventoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetallesEventoLabel" style="color: #0C244B;">
                        <span id="titleEvent"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDetallesEvento">
                        <div class="mb-3">
                            <label for="descripcionEvento" class="form-label">Descripción del Curso</label>
                            <textarea rows="3" class="form-control" id="descripcionEvento" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Seleccione la categoría</label>
                            <div id="categoria"></div>
                        </div>
                        <div class="alert alert-success" role="alert">
                            <p>Participante: <span id="nombresPersona" class="text-primary"></span> <span
                                    id="apellidosPersona" class="text-primary"></span></p>
                            Cuando finalices se te enviara un
                            código a tu correo electrónico: <span id="emailPersona" class="text-primary"></span> que
                            deberás usarlo para realizar el pago.
                        </div>
                        <div class="mb-3 row">
                            <input type="hidden" id="id_user">
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Finalizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de depósito -->
    <div class="modal fade" id="modalDeposito" tabindex="-1" aria-labelledby="modalDepositoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDepositoLabel">Registrar Depósito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="formDeposito" method="post" action="<?= base_url("deposito") ?>"
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="codigoPagoDep" class="form-label">Código de pago <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fas fa-receipt"></i></div>
                                            <input type="text" class="form-control numTex" id="codigoPagoDep"
                                                name="codigoPago"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'codigoPago') : '' ?>"
                                                required readonly>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'codigoPago') : '' ?>
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="depositoCedulaDep" class="form-label">Número de cédula <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                            <input type="text" class="form-control numTex" id="depositoCedulaDep"
                                                name="depositoCedula"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'depositoCedula') : '' ?>"
                                                required readonly>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'depositoCedula') : '' ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="comprobante" class="form-label">Número de comprobante <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa-solid fa-hashtag"></i></div>
                                            <input type="text" class="form-control numTex" id="comprobante"
                                                name="comprobante"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'comprobante') : '' ?>"
                                                required>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'comprobante') : '' ?>
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="dateDeposito" class="form-label">Fecha del deposito <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            <input type="date" class="form-control" id="dateDeposito"
                                                name="dateDeposito"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'dateDeposito') : '' ?>"
                                                required>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'dateDeposito') : '' ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="montoDeposito" class="form-label"><strong style="color: #ff416c;">Monto
                                            a depositar <span class="text-danger">*</span></strong></label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                        <input type="text" class="form-control" id="montoDeposito" name="montoDeposito"
                                            value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'montoDeposito') : '' ?>"
                                            readonly>
                                    </div>
                                    <p class="text-danger mt-2"><strong>Por favor, asegúrate de depositar exactamente
                                            esta cantidad para evitar problemas con tu inscripción.</strong></p>
                                    <p id="mensaje_estado" style="display: none;">Estado: <span
                                            class="text-danger"></span></p>
                                    <p id="mensaje_original" style="display: none;">Monto original: <span
                                            class="text-danger"></span></p>
                                    <p id="mensaje_pagado" style="display: none;">Monto pagado: <span
                                            class="text-danger"></span></p>
                                    <p id="mensaje_nuevo" style="display: none;">Nuevo monto a pagar: <span
                                            class="text-danger"></span></p>
                                </div>
                                <div class="mb-3">
                                    <label for="comprobantePago" class="form-label">Subir Comprobante de Pago <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-upload"></i></div>
                                        <input type="file" class="form-control" id="comprobantePago"
                                            name="comprobantePago" accept="image/*,application/pdf" required>
                                    </div>
                                    <span class="text-danger">
                                        <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'comprobantePago') : '' ?>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 modal-dialog-scrollable">
                            <h6>Historial de Depósitos</h6>
                            <div id="tabla_depositos" style="max-height: 300px; overflow-y: auto;"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" form="formDeposito" class="btn btn-success me-1">Registrar Depósito</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Autorización-->
   <!--  <div class="modal fade" id="modalVoucher" tabindex="-1" aria-labelledby="modalVoucherLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalVoucherLabel"><i class="fa-solid fa-file-pdf"></i> Consultar
                        Voucher</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formVoucher" method="GET">
                        <div class="mb-3">
                            <label for="numero_auto" class="form-label">Número de autorización</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-hashtag"></i></div>
                                <input type="text" class="form-control" id="numero_auto" name="numero_auto">
                            </div>
                        </div>
                        <div class="float-end">
                            <button type="button" class="btn btn-success me-1"
                                onclick="submitVoucherForm()">Buscar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->



    <div class="modal fade" id="modalMetodo" tabindex="-1" aria-labelledby="modalMetodoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalMetodoLabel">Método de pago</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMetodo">
                        <div class="row mb-3">
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="codigoPagoMetodo" class="form-label">Código de pago <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-receipt"></i></div>
                                    <input type="text" class="form-control numTex" id="codigoPagoMetodo"
                                        name="codigoPago" value="" required>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="depositoCedulaMetodo" class="form-label">Número de cédula <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                    <input type="text" class="form-control numTex" id="depositoCedulaMetodo"
                                        name="depositoCedula" value="" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="container col">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="metodoPago" value="deposito" checked>
                                                <span>Pago por deposito</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="metodoPago" value="tarjeta">
                                                <span>Pago con tarjeta <img
                                                        src="<?= base_url('assets/images/iconoPayphone.webp') ?>"
                                                        alt="PayPhone Icon"
                                                        style="width: 20px; height: 20px; vertical-align: middle; margin-left: 1px;"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Continuar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payphone -->
    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="payModalLabel">Realizar el Pago</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div>
                        <div id="pp-button"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="imagen-ampliada" class="imagen-grande" style="display: none;">
        <img src="" alt="Imagen ampliada">
    </div>

    <a href="https://wa.me/+593989026071" class="Btn text-decoration-none" target="_blank" title="¿Necesitas ayuda?">
        <div class="sign">
            <i class="fa-brands fa-whatsapp"></i>
        </div>
        <div class="text">Soporte</div>
    </a>

    <!-- Footer-->
    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container-fluid text-center">
        </div>
    </footer>
    <!-- Payphone -->
    <script type='module' src='https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url("assets/js/home/main.js") ?>"></script>
    <script>
        // Función para mostrar la alerta SweetAlert2
        function showAlert(type, message, uniqueCode = null) {
            if (type === 'success') {
                Swal.fire({
                    title: "<strong>¡Éxito!</strong>",
                    icon: "success",
                    html: `<div>${message}</div>`,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> Entendido`,
                    confirmButtonAriaLabel: "Thumbs up, great!",
                });
            }
            else if (type === 'error') {
                Swal.fire({
                    title: "<strong>Error</strong>",
                    icon: "error",
                    html: `<div>${message}</div>`,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> Entendido`,
                });
            }
            else if (type === 'pdf') {
                Swal.fire({
                    title: "<strong>Completado</strong>",
                    icon: "success",
                    html: `
                    <div>${message}</div>
                    ${uniqueCode ? `<div class="mt-3"><a class="btn btn-outline-danger" href="<?= base_url("") ?>pdf/${uniqueCode}" target="_blank"><i class="fa-solid fa-receipt"></i> Voucher </a></div>` : ''}
                `,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> Entendido`,
                });
            }
            else {
                Swal.fire({
                    icon: type,
                    title: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        }

        // Verificar si hay mensajes de éxito, advertencia o error
        <?php if (session()->has('flashMessages')): ?>
            <?php foreach (session('flashMessages') as $message): ?>
                <?php
                $type = $message[1];
                $msg = $message[0];
                $uniqueCode = isset($message[2]) ? $message[2] : null;
                ?>
                showAlert('<?= $type ?>', '<?= $msg ?>', '<?= $uniqueCode ?>');
            <?php endforeach; ?>
        <?php endif; ?>

        // Mostrar el modal de depósito si es necesario
        <?php if ('insert' == ($last_action ?? '')): ?>
            var myModal = new bootstrap.Modal(document.getElementById('modalDeposito'));
            myModal.show();
        <?php endif; ?>

        function submitVoucherForm() {
    var numeroAuto = document.getElementById('numero_auto').value;

    var url = '<?= base_url("pdf/") ?>' + numeroAuto;
    window.location.href = url;
}

    </script>

    <script src="<?= base_url("assets/js/home/home.js") ?>"></script>

    <!-- template -->
    <script src="<?= base_url("dist/js/niche.js") ?>"></script>
    <script src="<?= base_url("assets/js/sweetalert/sweetalert.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/preloader.js") ?>"></script>
</body>

</html>