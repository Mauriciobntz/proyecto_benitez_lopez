<?php
namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
    'nombre_tienda', 
    'razon_social',
    'email_tienda', 
    'telefono_tienda',
    'whatsapp_tienda',
    'direccion_tienda',
    'cuit',
    'cbu',
    'alias_cbu',
    'banco',
    'titular_cuenta',
    'tipo_cuenta',
    'area_cobertura',
    'facebook_url',
    'instagram_url',
    'twitter_url',
    'whatsapp_url',
    'horario_atencion',
    'logo_url',
    'mensaje_bienvenida'
];
    protected $useTimestamps = false;

    public function getConfiguracion()
    {
        return $this->first();
    }

    public function actualizarConfiguracion($data)
    {
        // Como solo hay un registro, actualizamos siempre el registro con ID 1
        return $this->update(1, $data);
    }
}