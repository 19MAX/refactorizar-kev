<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificadosProcedures extends Migration
{
    public function up()
    {
        // Elimina si ya existen
        $this->db->query("DROP PROCEDURE IF EXISTS insertar_certificado;");
        $this->db->query("DROP PROCEDURE IF EXISTS listar_certificados;");

        // Crea el procedimiento para insertar certificados
        $this->db->query("
            CREATE PROCEDURE insertar_certificado(
                IN p_nombre VARCHAR(255),
                IN p_archivo VARCHAR(255),
                IN p_usuario INT
            )
            BEGIN
                INSERT INTO certificados(nombre_certificado, archivo_certificado, usuario_id)
                VALUES (p_nombre, p_archivo, p_usuario);
            END
        ");

        // Crea el procedimiento para listar certificados
        $this->db->query("
            CREATE PROCEDURE listar_certificados()
            BEGIN
                SELECT * FROM certificados ORDER BY fecha_subida DESC;
            END
        ");
    }

    public function down()
    {
        $this->db->query("DROP PROCEDURE IF EXISTS insertar_certificado;");
        $this->db->query("DROP PROCEDURE IF EXISTS listar_certificados;");
    }
}
