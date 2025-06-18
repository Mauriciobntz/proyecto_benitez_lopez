<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionEnvioModel extends Model
{
    protected $table            = 'direccion_envio';
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
    
    protected $validationRules = [
        'venta_id' => 'required|numeric',
        'direccion' => 'required|max_length[255]',
        'ciudad' => 'required|max_length[100]',
        'provincia' => 'required|max_length[100]',
        'codigo_postal' => 'required|max_length[20]',
        'pais' => 'required|max_length[100]',
        'nombre_destinatario' => 'required|max_length[100]',
        'telefono_contacto' => 'required|max_length[20]',
        'instrucciones_entrega' => 'permit_empty|max_length[500]'
    ];
    
    protected $validationMessages = [
        'venta_id' => [
            'required' => 'El ID de venta es requerido',
            'numeric' => 'El ID de venta debe ser numérico'
        ],
        'direccion' => [
            'required' => 'La dirección es requerida',
            'max_length' => 'La dirección no puede exceder los 255 caracteres'
        ],
        'ciudad' => [
            'required' => 'La ciudad es requerida',
            'max_length' => 'La ciudad no puede exceder los 100 caracteres'
        ],
        'provincia' => [
            'required' => 'La provincia es requerida',
            'max_length' => 'La provincia no puede exceder los 100 caracteres'
        ],
        'codigo_postal' => [
            'required' => 'El código postal es requerido',
            'max_length' => 'El código postal no puede exceder los 20 caracteres'
        ],
        'pais' => [
            'required' => 'El país es requerido',
            'max_length' => 'El país no puede exceder los 100 caracteres'
        ],
        'nombre_destinatario' => [
            'required' => 'El nombre del destinatario es obligatorio',
            'max_length' => 'El nombre del destinatario no puede exceder los 100 caracteres'
        ],
        'telefono_contacto' => [
            'required' => 'El teléfono de contacto es requerido',
            'max_length' => 'El teléfono no puede exceder los 20 caracteres'
        ],
        'instrucciones_entrega' => [
            'max_length' => 'Las instrucciones no pueden exceder los 500 caracteres'
        ]
    ];
}