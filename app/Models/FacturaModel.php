<?php
namespace App\Models;

use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    protected $allowedFields = ['venta_id', 'fecha_emision', 'datos_fiscales', 'pdf_url'];
    protected $useTimestamps = false;

    public function getFacturaByVenta($venta_id)
    {
        return $this->where('venta_id', $venta_id)->first();
    }

    public function generarFactura($venta_id, $datos_fiscales, $pdf_url)
    {
        $data = [
            'venta_id' => $venta_id,
            'datos_fiscales' => $datos_fiscales,
            'pdf_url' => $pdf_url,
            'fecha_emision' => date('Y-m-d H:i:s')
        ];
        return $this->insert($data);
    }
}