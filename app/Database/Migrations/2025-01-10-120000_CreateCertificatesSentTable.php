<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificatesSentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'registration_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'payment_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'user_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'user_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'event_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'event_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'event_modality' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'certificate_path' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'sent_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'sent_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey(['registration_id', 'payment_id'], false, true); // Índice único
        $this->forge->createTable('certificates_sent');
        
        // Agregar foreign keys
        $this->forge->addForeignKey('registration_id', 'registrations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('payment_id', 'payments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sent_by', 'users', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('certificates_sent');
    }
}
