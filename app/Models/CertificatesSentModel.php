<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificatesSentModel extends Model
{
    protected $table = 'certificates_sent';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'registration_id', 'payment_id', 'user_name', 'user_email', 
        'event_name', 'event_date', 'event_modality', 'certificate_path', 
        'sent_at', 'sent_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Verificar si un certificado ya fue enviado
     */
    public function isCertificateSent($registrationId, $paymentId)
    {
        return $this->where('registration_id', $registrationId)
                   ->where('payment_id', $paymentId)
                   ->first() !== null;
    }

    /**
     * Obtener todos los certificados enviados con información adicional
     */
    public function getAllSentCertificates()
    {
        return $this->select('certificates_sent.*, 
                             users.first_name as sent_by_name,
                             users.last_name as sent_by_lastname')
                   ->join('users', 'users.id = certificates_sent.sent_by', 'left')
                   ->orderBy('certificates_sent.sent_at', 'DESC')
                   ->findAll();
    }

    /**
     * Registrar certificado enviado
     */
    public function recordSentCertificate($data)
    {
        $data['sent_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
}
