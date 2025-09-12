<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAttendances extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'inscription_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => '1=Presente, 2=Ausente, 3=Tardanza, 4=Justificado, 5=Excusado',
            ],
            'check_in_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'check_out_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'late_minutes' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'comment'    => 'Minutos de tardanza',
            ],
            'attendance_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'recorded_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'ID del usuario que registró la asistencia',
            ],
            'is_manual' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '0=Automático, 1=Manual',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Definir clave primaria
        $this->forge->addPrimaryKey('id');

        // Agregar índices para mejorar rendimiento
        $this->forge->addKey(['event_id', 'user_id', 'attendance_date'], false, false, 'idx_attendance_unique');
        $this->forge->addKey('event_id', false, false, 'idx_event_id');
        $this->forge->addKey('user_id', false, false, 'idx_user_id');
        $this->forge->addKey('inscription_id', false, false, 'idx_inscription_id');
        $this->forge->addKey('attendance_date', false, false, 'idx_attendance_date');
        $this->forge->addKey('status', false, false, 'idx_status');
        $this->forge->addKey('recorded_by', false, false, 'idx_recorded_by');

        // Crear la tabla
        $this->forge->createTable('attendances', true);

        // Agregar claves foráneas (opcional, descomenta si quieres usar)
        /*
        $this->forge->addForeignKey('event_id', 'events', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('inscription_id', 'inscriptions', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('recorded_by', 'users', 'id', 'SET NULL', 'CASCADE');
        */
    }

    public function down()
    {
        $this->forge->dropTable('attendances', true);
    }
}