<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificadosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_certificado' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'archivo_certificado' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            // NO agregar fecha_subida aquí
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('certificados');

        // Agrega la columna fecha_subida con CURRENT_TIMESTAMP como default usando SQL RAW
        $this->db->query('ALTER TABLE certificados ADD fecha_subida TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->forge->dropTable('certificados');
    }
}

