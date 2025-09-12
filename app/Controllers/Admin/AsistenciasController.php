<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AsistenciaModel;
use App\Models\RegistrationsModel;
use App\Models\EventsModel;
use Config\Services;

class AsistenciasController extends BaseController
{
    protected $asistenciaModel;
    protected $inscModel;
    protected $eventModel;
    protected $session;

    public function __construct()
    {
        $this->asistenciaModel = new AsistenciaModel();
        $this->inscModel = new RegistrationsModel();
        $this->eventModel = new EventsModel();
        $this->session = Services::session();
    }

    /**
     * GET /admin/asistencias
     * Muestra el formulario de marcación de asistencia
     */
    public function marcar(): string
    {
        return view('admin/asistencias/marcar', [
            'title' => 'Marcar Asistencia',
            'eventos' => $this->eventModel->findAll(),
            'errors' => session()->getFlashdata('errors') ?? []
        ]);
    }

    /**
     * POST /admin/asistencias/registrar
     * Valida y guarda (insert/update) la asistencia
     */
    public function registrar()
    {
        $rules = [
            'event_id' => 'required|integer',
            'inscription_id' => 'required|integer',
            'attendance_date' => 'required|valid_date[Y-m-d]',
            'status' => 'required|in_list[1,2,3,4,5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $post = $this->request->getPost();
        $insc = $this->inscModel->find($post['inscription_id']);

        if (!$insc) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['inscription_id' => 'Inscripción inválida']);
        }

        $data = [
            'event_id' => $post['event_id'],
            'inscription_id' => $post['inscription_id'],
            'user_id' => $insc['user_id'],
            'attendance_date' => $post['attendance_date'],
            'status' => $post['status'],
            'check_in_time' => $post['check_in_time'] ?: null,
            'check_out_time' => $post['check_out_time'] ?: null,
            'late_minutes' => $post['late_minutes'] ?: 0,
            'notes' => $post['notes'] ?: null,
            'location' => $post['location'] ?: null,
            'is_manual' => 1,
            'recorded_by' => session('user_id'),
        ];

        $this->asistenciaModel->registrarAsistencia($data);

        return redirect()->back()
            ->with('success', 'Asistencia registrada correctamente');
    }

    /**
     * POST AJAX /admin/asistencias/participantes
     * Devuelve JSON con las inscripciones para poblar el select
     */
    public function participantes()
    {
        $eventId = $this->request->getPost('event_id');
        $list = $this->inscModel
            ->where('event_cod', $eventId)
            ->findAll();

        $today = date('Y-m-d');
        foreach ($list as &$p) {
            $p['attendance_today'] = (bool) $this->asistenciaModel
                ->where('event_id', $eventId)
                ->where('user_id', $p['user_id'])
                ->where('attendance_date', $today)
                ->first();
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $list
        ]);
    }

    /**
     * POST AJAX /admin/asistencias/estadisticas
     * Devuelve JSON con estadísticas del evento
     */
    public function estadisticas()
    {
        $eventId = $this->request->getPost('event_id');
        $stats = $this->asistenciaModel->getEstadisticasEvento($eventId);

        return $this->response->setJSON([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * POST AJAX /admin/asistencias/recientes
     * Devuelve JSON con los registros de hoy para mostrar en el panel
     */
    public function recientes()
    {
        $eventId = $this->request->getPost('event_id');
        $fecha = $this->request->getPost('date') ?: date('Y-m-d');
        $records = $this->asistenciaModel->getReportePorFecha($eventId, $fecha);

        return $this->response->setJSON([
            'success' => true,
            'data' => $records
        ]);
    }
}
