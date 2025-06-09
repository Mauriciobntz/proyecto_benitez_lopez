<?php
namespace App\Controllers;

use App\Models\FacturaModel;
use App\Models\VentaModel;

class FacturaController extends BaseController
{
    protected $facturaModel;
    protected $ventaModel;

    public function __construct()
    {
        $this->facturaModel = new FacturaModel();
        $this->ventaModel = new VentaModel();
    }

    public function verFactura($venta_id)
    {
        $usuario_id = session()->get('id_usuario');
        $venta = $this->ventaModel->find($venta_id);
        
        if (!$venta || $venta['usuario_id'] != $usuario_id) {
            return redirect()->to('mis-compras')->with('error', 'No tienes permiso para ver esta factura');
        }

        $factura = $this->facturaModel->getFacturaByVenta($venta_id);
        
        if (!$factura) {
            return redirect()->to('mis-compras')->with('error', 'Factura no encontrada');
        }

        $data = [
            'titulo' => 'Factura #' . $factura['id_factura'],
            'factura' => $factura,
            'venta' => $venta
        ];

        return view('header', $data) . view('navbar') . view('factura') . view('footer');
    }

    public function descargarFactura($venta_id)
    {
        // Lógica para generar y descargar el PDF de la factura
        // Esta es una implementación básica, deberías usar una librería como Dompdf
        $factura = $this->facturaModel->getFacturaByVenta($venta_id);
        
        if ($factura && $factura['pdf_url']) {
            return redirect()->to($factura['pdf_url']);
        }
        
        return redirect()->back()->with('error', 'No se pudo descargar la factura');
    }
}