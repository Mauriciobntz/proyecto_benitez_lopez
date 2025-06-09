<?php
namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre_tienda', 'email_tienda', 'telefono_tienda', 'direccion_tienda',
        'costo_envio', 'envio_gratis_desde', 'tiempo_entrega', 'iva',
        'pago_tarjeta', 'pago_transferencia', 'cuenta_bancaria',
        'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_secure'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getConfiguracion()
    {
        return $this->first();
    }
}