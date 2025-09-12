<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Marcar Asistencia<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
  <h1>Marcar Asistencia</h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="<?= base_url('admin/asistencias') ?>">Asistencias</a></li>
    <li class="active">Marcar</li>
  </ol>
</div>

<div class="content">
  <div class="box box-primary">
    <?= form_open('admin/asistencias/registrar', ['class'=>'form-horizontal','id'=>'attendanceForm']) ?>
    <div class="box-body">
      <!-- Evento -->
      <div class="form-group">
        <label class="col-sm-3 control-label">Evento *</label>
        <div class="col-sm-9">
          <select name="event_id" id="event_id" class="form-control select2" required>
            <option value="">Seleccionar evento</option>
            <?php foreach($eventos as $e): ?>
            <option value="<?= $e['id'] ?>"><?= esc($e['title']) ?></option>
            <?php endforeach; ?>
          </select>
          <?= isset($errors['event_id']) ? '<span class="text-danger">'.$errors['event_id'].'</span>' : '' ?>
        </div>
      </div>

      <!-- Participante -->
      <div class="form-group">
        <label class="col-sm-3 control-label">Participante *</label>
        <div class="col-sm-9">
          <select name="inscription_id" id="inscription_id" class="form-control select2" required disabled>
            <option value="">Primero selecciona un evento</option>
          </select>
          <?= isset($errors['inscription_id']) ? '<span class="text-danger">'.$errors['inscription_id'].'</span>' : '' ?>
        </div>
      </div>

      <!-- Fecha -->
      <div class="form-group">
        <label class="col-sm-3 control-label">Fecha *</label>
        <div class="col-sm-9">
          <input type="date" name="attendance_date" id="attendance_date"
                 class="form-control" value="<?= old('attendance_date',date('Y-m-d')) ?>" required>
          <?= isset($errors['attendance_date']) ? '<span class="text-danger">'.$errors['attendance_date'].'</span>' : '' ?>
        </div>
      </div>

      <!-- Estado -->
      <div class="form-group">
        <label class="col-sm-3 control-label">Estado *</label>
        <div class="col-sm-9">
          <select name="status" id="status" class="form-control" required>
            <option value="1">Presente</option>
            <option value="2">Ausente</option>
            <option value="3">Tardanza</option>
            <option value="4">Justificado</option>
            <option value="5">Excusado</option>
          </select>
          <?= isset($errors['status']) ? '<span class="text-danger">'.$errors['status'].'</span>' : '' ?>
        </div>
      </div>

      <!-- Notas -->
      <div class="form-group">
        <label class="col-sm-3 control-label">Observaciones</label>
        <div class="col-sm-9">
          <textarea name="notes" id="notes" class="form-control" rows="3"><?= old('notes') ?></textarea>
        </div>
      </div>
    </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Registrar Asistencia</button>
    </div>
    <?= form_close() ?>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // Exponer base_url para AJAX
  const base_url = '<?= base_url() ?>';

  $(function(){
    // Inicializar Select2
    $('.select2').select2();

    // Al cambiar evento, cargar participantes
    $('#event_id').on('change', function(){
      const eid = $(this).val();
      const sel = $('#inscription_id')
                    .prop('disabled', true)
                    .html('<option>Cargando…</option>');

      if (!eid) {
        return sel.html('<option>Primero selecciona un evento</option>');
      }

      $.post(base_url + 'admin/asistencias/participantes', { event_id: eid })
       .done(function(res){
         let html = '<option value="">Seleccionar participante</option>';
         (res.data||[]).forEach(p=>{
           html += `<option value="${p.inscription_id}">
                      ${p.first_name} ${p.last_name}
                    </option>`;
         });
         sel.html(html).prop('disabled', false);
       })
       .fail(function(){
         sel.html('<option>Error al cargar participantes</option>');
       });
    });
  });
</script>
<?= $this->endSection() ?>
