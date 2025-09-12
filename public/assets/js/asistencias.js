class AsistenciasManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.initDatepickers();
    }

    bindEvents() {
        // Evento para cargar participantes por evento
        $(document).on('change', '#evento_id', (e) => {
            this.loadParticipantes($(e.target).val());
        });

        // Evento para marcar asistencia masiva
        $(document).on('click', '.btn-asistencia-masiva', (e) => {
            this.mostrarModalAsistenciaMasiva();
        });

        // Validación de formularios
        $(document).on('submit', '#form-asistencia', (e) => {
            return this.validateForm(e);
        });

        // Auto-completar participantes
        this.initParticipantesAutocomplete();
    }

    initDatepickers() {
        // Configurar datepickers con restricciones
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: 'es'
        });
    }

    loadParticipantes(eventoId) {
        const participanteSelect = $('#inscripcion_id');
        
        if (!eventoId) {
            participanteSelect.html('<option value="">Primero selecciona un evento</option>')
                             .prop('disabled', true);
            return;
        }

        // Mostrar loading
        participanteSelect.html('<option value="">Cargando participantes...</option>')
                         .prop('disabled', true);

        $.ajax({
            url: base_url + 'admin/asistencias/participantes',
            type: 'POST',
            data: { evento_id: eventoId },
            dataType: 'json',
            success: (response) => {
                let options = '<option value="">Seleccionar participante</option>';
                
                if (response && response.length > 0) {
                    response.forEach((participante) => {
                        const nombre = `${participante.nombres} ${participante.apellidos}`;
                        const cedula = participante.cedula;
                        const email = participante.email;
                        
                        options += `<option value="${participante.id}" 
                                   data-cedula="${cedula}" 
                                   data-email="${email}">
                                   ${nombre} - ${cedula}
                                   </option>`;
                    });
                    participanteSelect.prop('disabled', false);
                } else {
                    options = '<option value="">No hay participantes registrados</option>';
                }
                
                participanteSelect.html(options);
            },
            error: (xhr, status, error) => {
                console.error('Error loading participants:', error);
                participanteSelect.html('<option value="">Error al cargar participantes</option>');
                this.showAlert('error', 'Error al cargar los participantes del evento');
            }
        });
    }

    initParticipantesAutocomplete() {
        // Implementar autocompletado para búsqueda rápida de participantes
        $('#buscar-participante').autocomplete({
            source: (request, response) => {
                $.ajax({
                    url: base_url + 'admin/asistencias/buscar-participantes',
                    type: 'POST',
                    data: { 
                        term: request.term,
                        evento_id: $('#evento_id').val()
                    },
                    dataType: 'json',
                    success: (data) => {
                        response($.map(data, (item) => {
                            return {
                                label: `${item.nombres} ${item.apellidos} - ${item.cedula}`,
                                value: item.id,
                                participante: item
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: (event, ui) => {
                $('#inscripcion_id').val(ui.item.value);
                this.fillParticipantData(ui.item.participante);
                return false;
            }
        });
    }

    fillParticipantData(participante) {
        // Llenar datos adicionales del participante
        $('#participante-info').html(`
            <div class="alert alert-info">
                <strong>Participante:</strong> ${participante.nombres} ${participante.apellidos}<br>
                <strong>Cédula:</strong> ${participante.cedula}<br>
                <strong>Email:</strong> ${participante.email}
            </div>
        `);
    }

    mostrarModalAsistenciaMasiva() {
        // Modal para marcar asistencia masiva
        const modal = `
            <div class="modal fade" id="modal-asistencia-masiva" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Asistencia Masiva</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form-asistencia-masiva">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Evento</label>
                                            <select name="evento_id" class="form-control" required>
                                                <option value="">Seleccionar evento</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input type="date" name="fecha" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Estado por defecto</label>
                                    <select name="estado_default" class="form-control">
                                        <option value="presente">Presente</option>
                                        <option value="ausente">Ausente</option>
                                        <option value="tardanza">Tardanza</option>
                                    </select>
                                </div>
                                <div id="lista-participantes-masiva">
                                    <!-- Se carga dinámicamente -->
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="asistenciasManager.guardarAsistenciaMasiva()">
                                Guardar Asistencias
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        if ($('#modal-asistencia-masiva').length === 0) {
            $('body').append(modal);
        }
        
        $('#modal-asistencia-masiva').modal('show');
    }

    guardarAsistenciaMasiva() {
        const formData = new FormData(document.getElementById('form-asistencia-masiva'));
        const asistencias = [];

        // Recopilar datos de asistencia
        $('.participante-asistencia').each(function() {
            const participanteId = $(this).data('participante-id');
            const estado = $(this).find('.estado-participante').val();
            const observaciones = $(this).find('.observaciones-participante').val();

            asistencias.push({
                inscripcion_id: participanteId,
                estado: estado,
                observaciones: observaciones
            });
        });

        $.ajax({
            url: base_url + 'admin/asistencias/guardar-masiva',
            type: 'POST',
            data: {
                evento_id: formData.get('evento_id'),
                fecha: formData.get('fecha'),
                asistencias: asistencias
            },
            dataType: 'json',
            success: (response) => {
                if (response.success) {
                    this.showAlert('success', 'Asistencias guardadas correctamente');
                    $('#modal-asistencia-masiva').modal('hide');
                    location.reload();
                } else {
                    this.showAlert('error', response.message || 'Error al guardar asistencias');
                }
            },
            error: () => {
                this.showAlert('error', 'Error de conexión al guardar asistencias');
            }
        });
    }

    validateForm(event) {
        const form = event.target;
        let isValid = true;
        let errors = [];

        // Validar evento
        if (!form.evento_id.value) {
            errors.push('Debe seleccionar un evento');
            isValid = false;
        }

        // Validar participante
        if (!form.inscripcion_id.value) {
            errors.push('Debe seleccionar un participante');
            isValid = false;
        }

        // Validar fecha
        if (!form.fecha_asistencia.value) {
            errors.push('Debe ingresar una fecha');
            isValid = false;
        }

        // Validar que la fecha no sea futura
        const fechaSeleccionada = new Date(form.fecha_asistencia.value);
        const hoy = new Date();
        hoy.setHours(23, 59, 59, 999); // Final del día

        if (fechaSeleccionada > hoy) {
            errors.push('La fecha de asistencia no puede ser futura');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
            this.showAlert('warning', errors.join('<br>'));
        }

        return isValid;
    }

    showAlert(type, message) {
        // Usar SweetAlert2 si está disponible, sino usar función global
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type === 'warning' ? 'warning' : (type === 'error' ? 'error' : 'success'),
                title: type === 'success' ? '¡Éxito!' : (type === 'warning' ? 'Advertencia' : 'Error'),
                html: message,
                toast: type !== 'success',
                position: type !== 'success' ? 'top-end' : 'center',
                showConfirmButton: type === 'success',
                timer: type !== 'success' ? 4000 : undefined,
                timerProgressBar: type !== 'success'
            });
        } else if (typeof showAlert === 'function') {
            showAlert(type, message);
        } else {
            alert(message);
        }
    }

    // Función para exportar datos
    exportarAsistencias(formato = 'excel') {
        const filtros = this.getActiveFiltros();
        const url = base_url + `admin/asistencias/exportar?formato=${formato}&${$.param(filtros)}`;
        window.open(url, '_blank');
    }

    getActiveFiltros() {
        return {
            evento_id: $('#filtro-evento').val() || '',
            fecha_inicio: $('#fecha-inicio').val() || '',
            fecha_fin: $('#fecha-fin').val() || '',
            estado: $('#filtro-estado').val() || ''
        };
    }

    // Función para imprimir reporte
    imprimirReporte() {
        const contenido = $('#tabla-asistencias').clone();
        const ventana = window.open('', '_blank');
        
        ventana.document.write(`
            <html>
                <head>
                    <title>Reporte de Asistencias</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { border-collapse: collapse; width: 100%; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        .label { padding: 2px 6px; border-radius: 3px; color: white; }
                        .label-success { background-color: #5cb85c; }
                        .label-danger { background-color: #d9534f; }
                        .label-warning { background-color: #f0ad4e; }
                    </style>
                </head>
                <body>
                    <h1>Reporte de Asistencias</h1>
                    <p>Fecha de generación: ${new Date().toLocaleDateString()}</p>
                    ${contenido.prop('outerHTML')}
                </body>
            </html>
        `);
        
        ventana.document.close();
        ventana.print();
    }
}

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    window.asistenciasManager = new AsistenciasManager();
});

// Funciones globales para compatibilidad
function marcarAsistenciaMasiva() {
    asistenciasManager.mostrarModalAsistenciaMasiva();
}

function exportarExcel() {
    asistenciasManager.exportarAsistencias('excel');
}

function exportarPDF() {
    asistenciasManager.exportarAsistencias('pdf');
}

function imprimirReporte() {
    asistenciasManager.imprimirReporte();
}