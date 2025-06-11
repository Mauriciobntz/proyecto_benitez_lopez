<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoricoVentaModel extends Model
{
    protected $table = 'historico_ventas';
    protected $primaryKey = 'id_historico';
    protected $allowedFields = ['venta_id', 'estado_anterior', 'estado_nuevo', 'accion', 'usuario_id', 'fecha'];
}
