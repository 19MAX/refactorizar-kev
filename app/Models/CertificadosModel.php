<?php

namespace App\Models;
use CodeIgniter\Model;

class CertificadosModel extends Model
{
    protected $table = 'certificados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre_certificado', 'archivo_certificado', 'usuario_id', 'fecha_subida'];

    // Llama al procedimiento almacenado para listar
    public function listarCertificados()
    {
        $query = $this->db->query("CALL listar_certificados()");
        return $query->getResultArray();
    }

    // Llama al procedimiento almacenado para insertar
    public function insertarCertificado($nombre, $archivo, $usuarioId)
    {
        $this->db->query("CALL insertar_certificado(?, ?, ?)", [
            $nombre,
            $archivo,
            $usuarioId
        ]);
    }
}
