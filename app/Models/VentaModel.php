<?php
namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $allowedFields = ['usuario_id', 'direccion_id', 'estado', 'total'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_venta';
    protected $updatedField = '';

    public function getVentasByUsuario($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)
                   ->orderBy('fecha_venta', 'DESC')
                   ->findAll();
    }

    public function crearVenta($usuario_id, $direccion_id, $total)
    {
        $data = [
            'usuario_id' => $usuario_id,
            'direccion_id' => $direccion_id,
            'estado' => 'pendiente',
            'total' => $total
        ];
        return $this->insert($data);
    }

    public function actualizarEstado($venta_id, $estado)
    {
        return $this->update($venta_id, ['estado' => $estado]);
    }
}