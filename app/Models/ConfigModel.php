<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = false;
    protected $allowedFields = ['key', 'value', 'description'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAdditionalCharge()
    {
        return $this->where('key', 'additional_charge')->first()['value'] ?? 0;
    }

    /**
     * Obtener valor de configuración por clave
     */
    public function getConfigValue($key, $default = null)
    {
        $config = $this->where('key', $key)->first();
        return $config ? $config['value'] : $default;
    }

    /**
     * Obtener configuración de empresa para certificados
     */
    public function getCompanyConfig()
    {
        $configs = $this->whereIn('key', [
            'company_name',
            'company_logo',
            'primary_color',
            'secondary_color',
            'signature_image', // agregado
            'sello_image'      // agregado
        ])->findAll();

        $result = [
            'company_name' => 'Tu Empresa',
            'company_logo' => '',
            'primary_color' => '#0C244B',
            'secondary_color' => '#ffc705',
            'signature_image' => '', // agregado
            'sello_image' => ''  // agregado
        ];

        foreach ($configs as $config) {
            $result[$config['key']] = $config['value'];
        }

        return $result;
    }

    /**
     * Actualizar o crear configuración
     */
    public function setConfigValue($key, $value, $description = null)
    {
        $existing = $this->where('key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'value' => $value,
                'description' => $description ?? $existing['description']
            ]);
        } else {
            return $this->insert([
                'key' => $key,
                'value' => $value,
                'description' => $description
            ]);
        }
    }
}
