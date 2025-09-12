<?= $this->extend('admin/layout/main'); ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-check-circle"></i> Marcar Asistencia
            <small>Registro manual de asistencias</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?= base_url('admin/asistencias') ?>">Asistencias</a></li>
            <li class="active">Marcar</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- Formulario Principal -->
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-user-check"></i> Registrar Asistencia Manual
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <?= form_open('admin/asistencias/registrar', ['class' => 'form-horizontal', 'id' => 'attendanceForm']) ?>
                    <div class="box-body">
                        <!-- Selección de Evento -->
                        <div class="form-group">
                            <label for="event_id" class="col-sm-3 control-label">
                                <i class="fa fa-calendar"></i> Evento *
                            </label>
                            <div class="col-sm-9">
                                <select name="event_id" id="event_id" class="form-control select2" required style="width: 100%;">
                                    <option value="">Seleccionar evento</option>
                                    <?php foreach($eventos as $evento): ?>
                                        <option value="<?= $evento['id'] ?>" 
                                                data-start="<?= $evento['start_date'] ?>"
                                                data-end="<?= $evento['end_date'] ?>"
                                                data-modalidad="<?= $evento['modalidad'] ?>"
                                                <?= old('event_id') == $evento['id'] ? 'selected' : '' ?>>
                                            <?= $evento['title'] ?> 
                                            (<?= date('d/m/Y', strtotime($evento['start_date'])) ?> - 
                                             <?= date('d/m/Y', strtotime($evento['end_date'])) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($errors['event_id'])): ?>
                                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> <?= $errors['event_id'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Información del Evento Seleccionado -->
                        <div id="event-info" class="form-group" style="display: none;">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> <strong>Información del evento:</strong>
                                    <div id="event-details"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Selección de Participante -->
                        <div class="form-group">
                            <label for="inscription_id" class="col-sm-3 control-label">
                                <i class="fa fa-user"></i> Participante *
                            </label>
                            <div class="col-sm-9">
                                <select name="inscription_id" id="inscription_id" class="form-control select2" required disabled style="width: 100%;">
                                    <option value="">Primero selecciona un evento</option>
                                </select>
                                <?php if(isset($errors['inscription_id'])): ?>
                                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> <?= $errors['inscription_id'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Fecha de Asistencia -->
                        <div class="form-group">
                            <label for="attendance_date" class="col-sm-3 control-label">
                                <i class="fa fa-calendar-day"></i> Fecha *
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" name="attendance_date" id="attendance_date" class="form-control" 
                                           value="<?= old('attendance_date', date('Y-m-d')) ?>" required>
                                </div>
                                <?php if(isset($errors['attendance_date'])): ?>
                                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> <?= $errors['attendance_date'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Estado de Asistencia -->
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">
                                <i class="fa fa-check-square"></i> Estado *
                            </label>
                            <div class="col-sm-9">
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>
                                        <i class="fa fa-check text-green"></i> Presente
                                    </option>
                                    <option value="2" <?= old('status') == '2' ? 'selected' : '' ?>>
                                        <i class="fa fa-times text-red"></i> Ausente
                                    </option>
                                    <option value="3" <?= old('status') == '3' ? 'selected' : '' ?>>
                                        <i class="fa fa-clock text-yellow"></i> Tardanza
                                    </option>
                                    <option value="4" <?= old('status') == '4' ? 'selected' : '' ?>>
                                        <i class="fa fa-exclamation text-blue"></i> Justificado
                                    </option>
                                    <option value="5" <?= old('status') == '5' ? 'selected' : '' ?>>
                                        <i class="fa fa-question text-gray"></i> Excusado
                                    </option>
                                </select>
                                <?php if(isset($errors['status'])): ?>
                                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> <?= $errors['status'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Campos adicionales para diferentes estados -->
                        <div id="time-fields" style="display: none;">
                            <div class="form-group">
                                <label for="check_in_time" class="col-sm-3 control-label">
                                    <i class="fa fa-clock"></i> Hora de Entrada
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock"></i>
                                        </div>
                                        <input type="time" name="check_in_time" id="check_in_time" class="form-control" 
                                               value="<?= old('check_in_time', date('H:i')) ?>">
                                    </div>
                                </div>
                                <label for="check_out_time" class="col-sm-1 control-label">Salida</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock"></i>
                                        </div>
                                        <input type="time" name="check_out_time" id="check_out_time" class="form-control" 
                                               value="<?= old('check_out_time') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="late-minutes-group" style="display: none;">
                                <label for="late_minutes" class="col-sm-3 control-label">
                                    <i class="fa fa-hourglass-half"></i> Minutos de Tardanza
                                </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" name="late_minutes" id="late_minutes" class="form-control" 
                                               min="0" max="999" value="<?= old('late_minutes', 0) ?>">
                                        <div class="input-group-addon">minutos</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones/Notas -->
                        <div class="form-group">
                            <label for="notes" class="col-sm-3 control-label">
                                <i class="fa fa-sticky-note"></i> Observaciones
                            </label>
                            <div class="col-sm-9">
                                <textarea name="notes" id="notes" class="form-control" rows="3" 
                                          placeholder="Observaciones adicionales, justificaciones, etc..."><?= old('notes') ?></textarea>
                                <?php if(isset($errors['notes'])): ?>
                                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> <?= $errors['notes'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Información de ubicación (opcional) -->
                        <div class="form-group">
                            <label for="location" class="col-sm-3 control-label">
                                <i class="fa fa-map-marker"></i> Ubicación
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="location" id="location" class="form-control" 
                                       placeholder="Lugar donde se registra la asistencia" value="<?= old('location') ?>">
                                <small class="text-muted">Opcional: Especifica el lugar donde se registra la asistencia</small>
                            </div>
                        </div>

                        <!-- Campos ocultos -->
                        <input type="hidden" name="is_manual" value="1">
                        <input type="hidden" name="recorded_by" value="<?= session('user_id') ?>">
                    </div>

                    <div class="box-footer">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                                <i class="fa fa-save"></i> Registrar Asistencia
                            </button>
                            <button type="button" class="btn btn-success btn-lg" id="bulk-present-btn" style="display: none;">
                                <i class="fa fa-users"></i> Marcar Todos Presentes
                            </button>
                            <a href="<?= base_url('admin/asistencias') ?>" class="btn btn-default btn-lg">
                                <i class="fa fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="button" class="btn btn-info btn-lg pull-right" id="quick-entry-btn">
                                <i class="fa fa-bolt"></i> Entrada Rápida
                            </button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>

            <!-- Panel de Información -->
            <div class="col-md-4">
                <!-- Estadísticas del Evento -->
                <div class="box box-info" id="event-stats" style="display: none;">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-chart-pie"></i> Estadísticas del Evento
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="stats-content">
                            <!-- Se carga dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Asistencias Recientes -->
                <div class="box box-success" id="recent-attendance" style="display: none;">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-history"></i> Registros de Hoy
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="recent-list">
                            <!-- Se carga dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Ayuda Rápida -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-question-circle"></i> Guía Rápida
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-info"></i> Estados de Asistencia:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check text-green"></i> <strong>Presente:</strong> Asistió puntualmente</li>
                                <li><i class="fa fa-clock text-yellow"></i> <strong>Tardanza:</strong> Llegó tarde</li>
                                <li><i class="fa fa-times text-red"></i> <strong>Ausente:</strong> No asistió</li>
                                <li><i class="fa fa-exclamation text-blue"></i> <strong>Justificado:</strong> Ausencia justificada</li>
                                <li><i class="fa fa-question text-gray"></i> <strong>Excusado:</strong> Permiso previo</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>">
<script src="<?= base_url('assets/plugins/select2/select2.min.js') ?>"></script>

<script>
$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2();

    // Manejar cambio de evento
    $('#event_id').change(function() {
        let eventId = $(this).val();
        let participanteSelect = $('#inscription_id');
        
        if (eventId) {
            // Mostrar información del evento
            showEventInfo($(this).find('option:selected'));
            
            // Cargar participantes
            loadParticipants(eventId, participanteSelect);
            
            // Cargar estadísticas
            loadEventStats(eventId);
            
            // Cargar registros recientes
            loadRecentAttendance(eventId);
            
        } else {
            // Limpiar todo
            hideEventInfo();
            participanteSelect.html('<option value="">Primero selecciona un evento</option>')
                            .prop('disabled', true)
                            .trigger('change');
        }
    });

    // Manejar cambio de estado
    $('#status').change(function() {
        let status = $(this).val();
        
        if (status == '1' || status == '3') { // Presente o Tardanza
            $('#time-fields').show();
            $('#check_in_time').prop('required', true);
            
            if (status == '3') { // Tardanza
                $('#late-minutes-group').show();
                $('#late_minutes').prop('required', true);
            } else {
                $('#late-minutes-group').hide();
                $('#late_minutes').prop('required', false);
            }
        } else {
            $('#time-fields').hide();
            $('#check_in_time, #check_out_time, #late_minutes').prop('required', false);
        }
    });

    // Entrada rápida (marcar presente con hora actual)
    $('#quick-entry-btn').click(function() {
        if ($('#event_id').val() && $('#inscription_id').val()) {
            $('#status').val('1').trigger('change');
            $('#check_in_time').val(getCurrentTime());
            $('#attendance_date').val(getCurrentDate());
            showAlert('success', 'Configurado para entrada rápida');
        } else {
            showAlert('warning', 'Selecciona evento y participante primero');
        }
    });

    // Función para cargar participantes
    function loadParticipants(eventId, select) {
        select.html('<option value="">Cargando...</option>').prop('disabled', true);
        
        $.ajax({
            url: base_url + 'admin/asistencias/participantes',
            type: 'POST',
            data: {event_id: eventId},
            dataType: 'json',
            success: function(response) {
                let options = '<option value="">Seleccionar participante</option>';
                
                if (response.success && response.data.length > 0) {
                    response.data.forEach(function(participante) {
                        let status = participante.attendance_today ? 
                            ' <span class="text-success">(Ya registrado)</span>' : '';
                        
                        options += `<option value="${participante.inscription_id}" 
                                           data-user-id="${participante.user_id}"
                                           data-has-attendance="${participante.attendance_today ? 1 : 0}">
                            ${participante.first_name} ${participante.last_name} - ${participante.email}
                            ${status}
                        </option>`;
                    });
                    
                    $('#bulk-present-btn').show();
                } else {
                    options = '<option value="">No hay participantes registrados para este evento</option>';
                    $('#bulk-present-btn').hide();
                }
                
                select.html(options).prop('disabled', false);
                select.select2();
            },
            error: function() {
                select.html('<option value="">Error al cargar participantes</option>');
                showAlert('error', 'Error al cargar los participantes');
            }
        });
    }

    // Función para mostrar información del evento
    function showEventInfo(option) {
        let startDate = option.data('start');
        let endDate = option.data('end');
        let modalidad = option.data('modalidad');
        
        let info = `
            <strong>Fechas:</strong> ${formatDate(startDate)} - ${formatDate(endDate)}<br>
            <strong>Modalidad:</strong> ${modalidad}<br>
            <strong>Estado:</strong> <span class="label label-success">Activo</span>
        `;
        
        $('#event-details').html(info);
        $('#event-info').show();
        $('#event-stats').show();
        $('#recent-attendance').show();
    }

    // Función para ocultar información del evento
    function hideEventInfo() {
        $('#event-info').hide();
        $('#event-stats').hide();
        $('#recent-attendance').hide();
    }

    // Función para cargar estadísticas del evento
    function loadEventStats(eventId) {
        $.ajax({
            url: base_url + 'admin/asistencias/estadisticas',
            type: 'POST',
            data: {event_id: eventId},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let stats = response.data;
                    let html = `
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green">
                                        <i class="fa fa-check"></i> ${stats.presentes || 0}
                                    </span>
                                    <h5 class="description-header">Presentes</h5>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="description-block">
                                    <span class="description-percentage text-red">
                                        <i class="fa fa-times"></i> ${stats.ausentes || 0}
                                    </span>
                                    <h5 class="description-header">Ausentes</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-yellow">
                                        <i class="fa fa-clock"></i> ${stats.tardanzas || 0}
                                    </span>
                                    <h5 class="description-header">Tardanzas</h5>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="description-block">
                                    <span class="description-percentage text-blue">
                                        <i class="fa fa-users"></i> ${stats.total_registros || 0}
                                    </span>
                                    <h5 class="description-header">Total</h5>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#stats-content').html(html);
                }
            }
        });
    }

    // Función para cargar registros recientes
    function loadRecentAttendance(eventId) {
        $.ajax({
            url: base_url + 'admin/asistencias/recientes',
            type: 'POST',
            data: {event_id: eventId, date: getCurrentDate()},
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    let html = '';
                    response.data.slice(0, 5).forEach(function(record) {
                        let statusClass = getStatusClass(record.status);
                        let statusText = getStatusText(record.status);
                        let time = record.check_in_time ? formatTime(record.check_in_time) : '--:--';
                        
                        html += `
                            <div class="item">
                                <span class="label ${statusClass}">${statusText}</span>
                                <span class="text">${record.first_name} ${record.last_name}</span>
                                <small class="text-muted pull-right">${time}</small>
                            </div>
                        `;
                    });
                    $('#recent-list').html(html);
                } else {
                    $('#recent-list').html('<p class="text-muted">No hay registros para hoy</p>');
                }
            }
        });
    }

    // Funciones auxiliares
    function getCurrentTime() {
        let now = new Date();
        return now.getHours().toString().padStart(2, '0') + ':' + 
               now.getMinutes().toString().padStart(2, '0');
    }

    function getCurrentDate() {
        let now = new Date();
        return now.getFullYear() + '-' + 
               (now.getMonth() + 1).toString().padStart(2, '0') + '-' + 
               now.getDate().toString().padStart(2, '0');
    }

    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('es-ES');
    }

    function formatTime(timeString) {
        if (!timeString) return '--:--';
        return timeString.substring(11, 16);
    }

    function getStatusClass(status) {
        const classes = {
            '1': 'label-success',
            '2': 'label-danger', 
            '3': 'label-warning',
            '4': 'label-info',
            '5': 'label-default'
        };
        return classes[status] || 'label-default';
    }

    function getStatusText(status) {
        const texts = {
            '1': 'Presente',
            '2': 'Ausente',
            '3': 'Tardanza', 
            '4': 'Justificado',
            '5': 'Excusado'
        };
        return texts[status] || 'Desconocido';
    }

    // Validación del formulario
    $('#attendanceForm').on('submit', function(e) {
        let hasError = false;
        
        // Validar campos requeridos
        if (!$('#event_id').val()) {
            showAlert('error', 'Debe seleccionar un evento');
            hasError = true;
        }
        
        if (!$('#inscription_id').val()) {
            showAlert('error', 'Debe seleccionar un participante');
            hasError = true;
        }
        
        if (hasError) {
            e.preventDefault();
            return false;
        }
        
        // Mostrar loading
        $('#submit-btn').html('<i class="fa fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);
    });

    // Inicializar estado por defecto
    $('#status').trigger('change');
});

// Función global para mostrar alertas
function showAlert(type, message) {
    let alertClass = 'alert-info';
    let icon = 'fa-info';
    
    switch(type) {
        case 'success':
            alertClass = 'alert-success';
            icon = 'fa-check';
            break;
        case 'error':
            alertClass = 'alert-danger';
            icon = 'fa-exclamation-triangle';
            break;
        case 'warning':
            alertClass = 'alert-warning';
            icon = 'fa-warning';
            break;
    }
    
    let alert = `<div class="alert ${alertClass} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa ${icon}"></i> ${message}
    </div>`;
    
    $('.content').prepend(alert);
    
    // Auto-hide después de 5 segundos
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
<?= $this->endSection() ?>