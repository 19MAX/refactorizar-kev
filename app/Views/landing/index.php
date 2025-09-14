<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Cursos Doctrina Tech</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="<?=base_url("")?>landing/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url("")?>landing/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?=base_url("")?>landing/assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="<?=base_url("")?>landing/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="<?=base_url("")?>landing/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="<?=base_url("")?>landing/assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: Bootslander
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="<?=base_url("")?>landing/assets/img/logoDoctrina.png" alt="" />
                <h1 class="sitename">
                    <span class="secondary-custom-text-color">Doctrina</span> Tech
                </h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Inicio</a></li>
                    <li><a href="#about">Nosotros</a></li>
                    <li><a href="#features">Características</a></li>
                    <li><a href="#faq">Preguntas Frecuentes</a></li>
                    <!-- <li><a href="#team">Team</a></li>
          <li><a href="#pricing">Pricing</a></li> -->
                    <!-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li> -->
                    <li><a href="#contact">Contactanos</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <img src="<?=base_url("")?>landing/assets/img/hero-bg-2.jpg" alt="" class="hero-bg" />

            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <img src="<?=base_url("")?>landing/assets/img/raw.png" class="img-fluid animated" alt="" />
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-in">
                        <h1>
                            Cursos por parte de
                            <span><span class="secondary-custom-text-color">Doctrina</span>
                                Tech</span>
                        </h1>
                        <p>Regístrate en los cursos disponibles y comienza a aprender</p>
                        <div class="d-flex">
                            <a href="<?=base_url("inicio")?>" class="btn-get-started text-dark">Registrarse</a>
                            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                                class="glightbox btn-watch-video d-flex align-items-center"><i
                                    class="bi bi-play-circle"></i><span>Mirar video</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                    </path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>
        </section>
        <!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-xl-center gy-5">
                    <div class="col-xl-5 content">
                        <h3>Acerca de la Plataforma</h3>
                        <h2>Tu acceso a cursos y certificación en un solo lugar</h2>
                        <p>
                            Esta plataforma está pensada para facilitar la gestión de cursos
                            en línea. Permite a los usuarios inscribirse de manera sencilla,
                            realizar sus pagos de forma segura y obtener un certificado
                            digital como constancia de su participación.
                        </p>
                        <p>
                            Está diseñada tanto para estudiantes como para profesionales que
                            buscan capacitarse, y para instituciones que necesitan
                            administrar inscripciones, pagos y certificados de manera
                            eficiente.
                        </p>
                        <a href="<?=base_url("inicio")?>" class="read-more">
                            <span>Registrarse</span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="col-xl-7">
                        <div class="row gy-4 icon-boxes">
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box">
                                    <i class="bi bi-person-vcard"></i>
                                    <h3>Inscripción Rápida</h3>
                                    <p>
                                        Regístrate usando tu número de cédula o completa un breve
                                        formulario con tus datos personales.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box">
                                    <i class="bi bi-tags"></i>
                                    <h3>Categorías de Participación</h3>
                                    <p>
                                        Selecciona la categoría que se ajuste a ti, con precios
                                        diferenciados (ejemplo: estudiante, profesional).
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                    <i class="bi bi-wallet2"></i>
                                    <h3>Pagos Seguros</h3>
                                    <p>
                                        Paga con tarjeta a través de <strong>PayPhone</strong> o
                                        realiza un depósito bancario cargando tu comprobante.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                    <i class="bi bi-award-fill"></i>
                                    <h3>Certificados Digitales</h3>
                                    <p>
                                        Una vez validado tu pago, recibe tu certificado digital en
                                        formato HTML como constancia de haber completado el curso.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /About Section -->

        <!-- Features Section -->
        <section id="features" class="features section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="features-item">
                            <i class="bi bi-person-plus" style="color: #ffbb2c"></i>
                            <h3><a href="#" class="stretched-link">Registro Fácil</a></h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="features-item">
                            <i class="bi bi-credit-card" style="color: #5578ff"></i>
                            <h3><a href="#" class="stretched-link">Pagos Seguros</a></h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="features-item">
                            <i class="bi bi-award" style="color: #e80368"></i>
                            <h3>
                                <a href="#" class="stretched-link">Certificados Digitales</a>
                            </h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="features-item">
                            <i class="bi bi-journal-text" style="color: #e361ff"></i>
                            <h3>
                                <a href="#" class="stretched-link">Gestión de Cursos</a>
                            </h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="features-item">
                            <i class="bi bi-bar-chart-line" style="color: #47aeff"></i>
                            <h3>
                                <a href="#" class="stretched-link">Reportes y Estadísticas</a>
                            </h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
                        <div class="features-item">
                            <i class="bi bi-phone" style="color: #ffa76e"></i>
                            <h3><a href="#" class="stretched-link">Acceso Móvil</a></h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
                        <div class="features-item">
                            <i class="bi bi-bell" style="color: #11dbcf"></i>
                            <h3><a href="#" class="stretched-link">Notificaciones</a></h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->

                    <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
                        <div class="features-item">
                            <i class="bi bi-shield-lock" style="color: #4233ff"></i>
                            <h3><a href="#" class="stretched-link">Seguridad</a></h3>
                        </div>
                    </div>
                    <!-- End Feature Item -->
                </div>
            </div>
        </section>
        <!-- /Features Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-person-check"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Estudiantes Inscritos</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-journal-bookmark"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="35" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Cursos Disponibles</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-credit-card-2-front"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="850" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Pagos Procesados</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-award"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="780" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Certificados Emitidos</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->
                </div>
            </div>
        </section>
        <!-- /Stats Section -->

        <!-- Faq Section -->
        <section id="faq" class="faq section light-background">
            <div class="container-fluid">
                <div class="row gy-4">
                    <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">
                        <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                            <h3><span>Preguntas </span><strong>Frecuentes</strong></h3>
                            <p>
                                Aquí encontrarás respuestas a las dudas más comunes sobre cómo
                                inscribirte en un curso, realizar el pago y obtener tu
                                certificado.
                            </p>
                        </div>

                        <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">
                            <div class="faq-item faq-active">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>¿Cómo me inscribo en un curso?</h3>
                                <div class="faq-content">
                                    <p>
                                        Debes seleccionar el curso que te interesa, ingresar tu
                                        número de cédula y completar los datos solicitados. Si ya
                                        estás registrado, pasarás directamente a la selección de
                                        categoría. Si no, deberás llenar el formulario con tus
                                        datos personales antes de continuar.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                            <!-- End Faq item-->

                            <div class="faq-item">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>¿Qué son las categorías de inscripción?</h3>
                                <div class="faq-content">
                                    <p>
                                        Cada curso tiene categorías con precios diferentes (por
                                        ejemplo, Estudiante: $10, Profesional: $20). Debes
                                        seleccionar la que corresponda antes de continuar con el
                                        pago.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                            <!-- End Faq item-->

                            <div class="faq-item">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>¿Cómo puedo realizar el pago?</h3>
                                <div class="faq-content">
                                    <p>
                                        Una vez confirmada tu inscripción, recibirás un código
                                        único. Con ese código puedes pagar mediante tarjeta de
                                        crédito/débito usando la pasarela
                                        <strong>PayPhone</strong>, o seleccionar la opción de
                                        depósito bancario, subiendo tu comprobante (número, fecha
                                        e imagen del comprobante).
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                            <!-- End Faq item-->

                            <div class="faq-item">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>¿Qué pasa si no realizo el pago?</h3>
                                <div class="faq-content">
                                    <p>
                                        Si no completas el pago, tu inscripción no será válida y
                                        no se generará tu certificado ni tendrás acceso al curso.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                            <!-- End Faq item-->

                            <div class="faq-item">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>¿Cómo y cuándo recibo mi certificado?</h3>
                                <div class="faq-content">
                                    <p>
                                        Una vez validado tu pago, el administrador aprobará tu
                                        inscripción y se generará tu certificado en formato
                                        digital (HTML). Recibirás el enlace para descargarlo.
                                        <strong>Nota:</strong> los certificados son de diseño y no
                                        cuentan con verificación oficial en línea.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                            <!-- End Faq item-->
                        </div>
                    </div>

                    <div class="col-lg-5 order-1 order-lg-2">
                        <img src="<?=base_url("")?>landing/assets/img/faq.jpg" class="img-fluid" alt="Preguntas Frecuentes" data-aos="zoom-in"
                            data-aos-delay="100" />
                    </div>
                </div>
            </div>
        </section>
        <!-- /Faq Section -->
        <!-- Contact Section -->
        <section id="contact" class="contact section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="section-header text-center mb-5">
                    <h3>Contáctanos por WhatsApp</h3>
                    <p>
                        Si tienes dudas sobre inscripción, pago o certificados, escríbenos
                        y te responderemos rápidamente.
                    </p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="200">
                        <a href="https://wa.me/+593989026071?text=Hola,%20tengo%20una%20consulta%20sobre%20el%20curso"
                            target="_blank"
                            class="btn btn-success btn-lg d-flex align-items-center justify-content-center">
                            <i class="bi bi-whatsapp fs-3 me-2"></i> Enviar mensaje por
                            WhatsApp
                        </a>
                        <p class="mt-3">
                            Haz clic en el botón para iniciar un chat directo con nuestro
                            equipo de soporte.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Contact Section -->
    </main>
    <!-- Footer Section -->
    <footer id="footer" class="footer dark-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <!-- About / Logo -->
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename"> <span class="secondary-custom-text-color">Doctrina</span> Tech</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Av. 7 de mayo y olmedo</p>
                        <p>Guaranda, Ecuador</p>
                        <p class="mt-3">
                            <strong>Teléfono:</strong> <span>+593 98 902 6071</span>
                        </p>
                        <p><strong>Email:</strong> <span>doctrinatech@gmail.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <!-- End About -->

                <!-- Useful Links -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Enlaces Útiles</h4>
                    <ul>
                        <li><a href="#hero">Inicio</a></li>
                        <li><a href="#about">Acerca de</a></li>
                        <li><a href="#features">Características</a></li>
                        <li><a href="#faq">Preguntas</a></li>
                        <li><a href="#contact">Contáctanos</a></li>
                    </ul>
                </div>
                <!-- End Useful Links -->

                <!-- Our Services -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Servicios</h4>
                    <ul>
                        <li><a href="#">Inscripción a Cursos</a></li>
                        <li><a href="#">Pagos Seguros</a></li>
                        <li><a href="#">Certificados Digitales</a></li>
                        <li><a href="#">Soporte al Estudiante</a></li>
                    </ul>
                </div>
                <!-- End Services -->

                <!-- Newsletter / WhatsApp -->
                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Contáctanos</h4>
                    <p>
                        Si tienes dudas sobre inscripción, pagos o certificados, envíanos
                        un mensaje por WhatsApp y te responderemos rápidamente.
                    </p>
                    <a href="https://wa.me/+593989026071?text=Hola,%20tengo%20una%20consulta%20sobre%20los%20cursos"
                        target="_blank" class="btn btn-success d-flex align-items-center justify-content-center">
                        <i class="bi bi-whatsapp fs-3 me-2"></i> Enviar mensaje por
                        WhatsApp
                    </a>
                </div>
                <!-- End Newsletter / WhatsApp -->
            </div>
        </div>

        <!-- Copyright -->
        <div class="container text-center mt-4">
            <p>
                © <span>Copyright</span>
                <strong class="px-1 sitename">Doctrina Tech</strong>
                <span>Todos los derechos reservados</span>
            </p>
            <div class="credits">
                Diseñado por
                <a href="https://github.com/kevin24-remache">Kevin Remache</a> Y
                <a href="https://themewagon.com">Antonny Cruz</a>
            </div>
        </div>
    </footer>
    <!-- /Footer Section -->

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="<?=base_url("")?>landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url("")?>landing/assets/vendor/php-email-form/validate.js"></script>
    <script src="<?=base_url("")?>landing/assets/vendor/aos/aos.js"></script>
    <script src="<?=base_url("")?>landing/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?=base_url("")?>landing/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?=base_url("")?>landing/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="<?=base_url("")?>landing/assets/js/main.js"></script>
</body>

</html>