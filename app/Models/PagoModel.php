<?php namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    protected $allowedFields = ['pedido_id', 'monto', 'metodo_pago', 'estado'];
    protected $useTimestamps = true;
    
    protected $validationRules = [
        'pedido_id' => 'required|integer',
        'monto' => 'required|decimal',
        'estado' => 'required|in_list[exitoso,fallido]'
    ];
}