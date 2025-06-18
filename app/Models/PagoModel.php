<?php
namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    protected $allowedFields = ['venta_id', 'monto', 'metodo_pago', 'estado', 'fecha_pago', 'comprobante', 'referencia_pago'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_pago';
    protected $updatedField = '';

    public function registrarPago($venta_id, $monto, $metodo_pago, $estado = 'exitoso')
    {
        $data = [
            'venta_id' => $venta_id,
            'monto' => $monto,
            'metodo_pago' => $metodo_pago,
            'estado' => $estado
        ];
        return $this->insert($data);
    }

    public function getPagoByVenta($venta_id)
    {
        return $this->where('venta_id', $venta_id)->findAll();
    }
}