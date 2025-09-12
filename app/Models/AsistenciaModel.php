<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciaModel extends Model
{
    protected $table         = 'attendances';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'event_id',
        'user_id',
        'inscription_id',
        'status',
        'check_in_time',
        'check_out_time',
        'late_minutes',
        'attendance_date',
        'notes',
        'ip_address',
        'user_agent',
        'location',
        'recorded_by',
        'is_manual',
    ];

    // Inserta o actualiza un registro de asistencia
    public function registrarAsistencia(array $data)
    {
        $existing = $this->where([
            'event_id'       => $data['event_id'],
            'user_id'        => $data['user_id'],
            'attendance_date'=> $data['attendance_date']
        ])->first();

        if ($existing) {
            return $this->update($existing['id'], $data);
        }

        return $this->insert($data);
    }

    // Obtiene estadísticas por evento
    public function getEstadisticasEvento(int $eventId): array
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            COUNT(*) as total_registros,
            SUM(status = 1) as presentes,
            SUM(status = 2) as ausentes,
            SUM(status = 3) as tardanzas,
            SUM(status = 4) as justificados,
            SUM(status = 5) as excusados
        ');
        $builder->where('event_id', $eventId);
        return (array)$builder->get()->getRow();
    }

    // Reporte de un día concreto
    public function getReportePorFecha(int $eventId, string $fecha): array
    {
        return $this->select('attendances.*, u.first_name, u.last_name')
                    ->join('users u','u.id=attendances.user_id')
                    ->where('event_id', $eventId)
                    ->where('attendance_date', $fecha)
                    ->orderBy('check_in_time','ASC')
                    ->findAll();
    }
}
