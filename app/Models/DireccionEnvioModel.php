<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionEnvioModel extends Model
{
    protected $table            = 'direccion_envio'; // MUY IMPORTANTE
    protected $primaryKey       = 'id_direccion_envio';
    protected $allowedFields    = [
        'venta_id',
        'direccion',
        'ciudad',
        'provincia',
        'codigo_postal',
        'pais',
        'nombre_destinatario',
        'telefono_contacto',
        'instrucciones_entrega'
    ];
}

