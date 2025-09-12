<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Panel de Administración - Doctrina Tech
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
    
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f0f4fa;
    }
    
    .content-wrapper {
        background-color: #f0f4fa;
        min-height: 100vh;
    }
    
    .content-header {
        background: linear-gradient(135deg, #0C244B 0%, #1a3b6d 100%);
        color: white;
        padding: 25px 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(12, 36, 75, 0.15);
    }
    
    .content-header h1 {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
        letter-spacing: 0.5px;
    }
    
    .breadcrumb {
        background: transparent;
        margin: 10px 0 0;
        padding: 0;
    }
    
    .breadcrumb li, .breadcrumb li a {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }
    
    .breadcrumb li a:hover {
        color: #FFD700;
        text-decoration: none;
    }
    
    .info-box {
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
        background-color: white;
    }
    
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    .stat-card {
        border-radius: 15px;
        overflow: hidden;
        background: white;
        transition: all 0.3s ease;
        height: 100%;
        display: block;
        text-decoration: none !important;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
    }
    
    .stat-card .icon-container {
        height: 80px;
        width: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-right: 20px;
    }
    
    .stat-card .icon-container i {
        font-size: 28px;
    }
    
    .stat-card .stat-content {
        flex: 1;
    }
    
    .stat-card .stat-title {
        font-size: 18px;
        font-weight: 600;
        color: #444;
        margin-bottom: 5px;
    }
    
    .stat-card .stat-value {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }
    
    .info-box h5 {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 12px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        border-top: none;
        border-bottom: 2px solid #0C244B;
        font-weight: 600;
        color: #0C244B;
    }
    
    .table td {
        padding: 12px 8px;
        vertical-align: middle;
    }
    
    /* Status badges */
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 30px;
    }
    
    /* Custom navbar styling */
    .main-header {
        background: linear-gradient(135deg, #0C244B 0%, #1a3b6d 100%);
        border-bottom: 3px solid #FFD700;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .main-header .navbar-brand {
        color: white !important;
        font-weight: 700;
    }
    
    .main-header .navbar-brand span {
        color: #FFD700;
    }
    
    .main-header .nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 500;
        transition: all 0.3s ease;
        margin: 0 5px;
        padding: 8px 15px;
        border-radius: 5px;
    }
    
    .main-header .nav-link:hover, 
    .main-header .nav-link:focus {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .main-header .nav-link.active {
        color: #0C244B !important;
        background-color: #FFD700;
        font-weight: 600;
    }
    
    .sidebar {
        background-color: #0C244B;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .sidebar .sidebar-menu li a {
        color: rgba(255, 255, 255, 0.8);
        border-left: 3px solid transparent;
    }
    
    .sidebar .sidebar-menu li a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .sidebar .sidebar-menu li.active > a {
        background-color: rgba(255, 215, 0, 0.15);
        color: #FFD700;
        border-left: 3px solid #FFD700;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header sty-one animate__animated animate__fadeIn">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fa fa-dashboard me-2"></i> Panel de Control</h1>
                <ol class="breadcrumb">
                    
                </ol>
            </div>
            
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Stats Cards -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Total Registrations -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="<?= base_url("admin/inscritos") ?>" class="stat-card shadow d-flex align-items-center p-3">
                    <div class="icon-container" style="background-color: rgba(12, 36, 75, 0.9); color: white;">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Total de Inscritos</div>
                        <div class="stat-value"><?= number_format($totalRegistrations ?? 0) ?></div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 75%; background-color: #0C244B;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Daily Revenue -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="" class="stat-card shadow d-flex align-items-center p-3">
                    <div class="icon-container" style="background-color: rgba(40, 167, 69, 0.9); color: white;">
                        <i class="fa fa-usd" aria-hidden="true"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Ingresos del Día</div>
                        <div class="stat-value">$<?= number_format($dailyRevenue ?? 0, 2) ?></div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 65%; background-color: #28a745;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Total Revenue -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="" class="stat-card shadow d-flex align-items-center p-3">
                    <div class="icon-container" style="background-color: rgba(255, 215, 0, 0.9); color: #0C244B;">
                        <i class="fa fa-money" aria-hidden="true"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Ingresos Totales</div>
                        <div class="stat-value">$<?= number_format($totalRevenue ?? 0, 2) ?></div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 85%; background-color: #FFD700;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- My Total Collection -->
            <div class="col-lg-6 col-md-6 mb-4">
                <a href="" class="stat-card shadow d-flex align-items-center p-3">
                    <div class="icon-container" style="background-color: rgba(73, 80, 87, 0.9); color: white;">
                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Mi Recaudación Total por Cobros</div>
                        <div class="stat-value">$<?= number_format($mis_ingresos_totales ?? 0, 2) ?></div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 70%; background-color: #495057;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- My Daily Collection -->
            <div class="col-lg-6 col-md-6 mb-4">
                <a href="" class="stat-card shadow d-flex align-items-center p-3">
                    <div class="icon-container" style="background-color: rgba(73, 80, 87, 0.9); color: white;">
                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Mi Recaudación del Día por Cobros</div>
                        <div class="stat-value">$<?= number_format($mis_ingresos ?? 0, 2) ?></div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 60%; background-color: #495057;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Charts and Tables -->
        <div class="row animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <!-- Payment Methods Chart -->
            <div class="col-lg-4 mb-4">
                <div class="info-box p-4 shadow">
                    <h5 class="text-center" style="color: #0C244B; font-weight: 700;">
                        <i class="fa fa-credit-card me-2"></i> Métodos de Pago Más Usados
                    </h5>
                    <div class="chart-container" style="position: relative; height:260px; margin-top: 20px;">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue by User -->
            <div class="col-lg-4 mb-4">
                <div class="info-box p-4 shadow">
                    <h5 class="text-center" style="color: #0C244B; font-weight: 700;">
                        <i class="fa fa-users me-2"></i> Ingresos por Administrador
                    </h5>
                    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Administrador</th>
                                    <th class="text-end">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($revenueByUser as $user): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-icon me-2" style="width: 30px; height: 30px; border-radius: 50%; background-color: #0C244B; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                                    <?= substr($user['first_name'], 0, 1) ?>
                                                </div>
                                                <?= $user['first_name'] ?>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold"><?= '$' . number_format($user['user_revenue'] ?? 0, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Registration Status -->
            <div class="col-lg-4 mb-4">
                <div class="info-box p-4 shadow">
                    <h5 class="text-center" style="color: #0C244B; font-weight: 700;">
                        <i class="fa fa-list-alt me-2"></i> Registros por Estado de Pago
                    </h5>
                    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th class="text-end">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrationsByStatus as $status): ?>
                                    <tr>
                                        <td>
                                            <span class="badge <?= style_estado($status["payment_status"]) ?>" style="font-size: 12px;">
                                                <?= getPaymentStatusText($status['payment_status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold"><?= $status['count'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Morris JavaScript -->
<script src="<?= base_url("dist/plugins/raphael/raphael-min.js") ?>"></script>
<script src="<?= base_url("dist/plugins/morris/morris.js") ?>"></script>
<script src="<?= base_url("dist/plugins/functions/dashboard1.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Payment method chart
        var ctx = document.getElementById('paymentMethodChart').getContext('2d');
        var paymentMethodStats = <?= json_encode(isset($paymentMethodStats) ? $paymentMethodStats : '') ?>;

        var labels = paymentMethodStats.map(function (item) { return item.method_name; });
        var data = paymentMethodStats.map(function (item) { return item.count; });

        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(12, 36, 75, 0.8)',
                        'rgba(255, 215, 0, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(108, 117, 125, 0.8)',
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12,
                                family: "'Montserrat', sans-serif"
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(12, 36, 75, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            family: "'Montserrat', sans-serif",
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13,
                            family: "'Montserrat', sans-serif"
                        },
                        displayColors: false
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000
                }
            }
        });

        // Add animations to elements when scrolling
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.animate__animated');
            
            elements.forEach(element => {
                const position = element.getBoundingClientRect();
                
                // Check if element is in viewport
                if(position.top < window.innerHeight && position.bottom >= 0) {
                    element.style.visibility = 'visible';
                }
            });
        };
        
        // Run on page load
        animateOnScroll();
        
        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
    });
</script>
<?= $this->endSection() ?>