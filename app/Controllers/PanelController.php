<?php

namespace App\Controllers;

use App\Controllers\BaseController; 
use App\Models\VentaModel;
use App\Models\ProductoModel;
use App\Models\UsuarioModel;
use App\Models\ResenaModel;

class PanelController extends BaseController
{
    private $ventaModel;
    private $productosModel;
    private $usuariosModel;
    private $resenaModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->productoModel = new ProductoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->resenaModel = new ResenaModel();
    }

    public function verPanel(): string
    {        
        // Obtener datos para las métricas
        $hoy = date('Y-m-d');
        
        // Ventas de hoy
        $ventasHoy = $this->ventaModel->where('DATE(fecha_venta)', $hoy)
                      ->get()
                      ->getResultArray();
        
        $totalVentasHoy = array_reduce($ventasHoy, function($carry, $venta) {
            return $carry + $venta['total'];
        }, 0);
        
        // Total de productos activos
        $totalProductos = $this->productoModel->where('activo', 1)
                           ->countAllResults();
        
        // Total de clientes (usuarios con rol 'cliente')
        $totalClientes = $this->usuarioModel->where('rol', 'cliente')
                          ->countAllResults();
        
        // Últimas ventas (5 más recientes)
        $ultimasVentas = $this->ventaModel->select('ventas.*, personas.nombre, personas.apellido')
                          ->join('usuarios', 'usuarios.id_usuario = ventas.usuario_id')
                          ->join('personas', 'personas.usuario_id = usuarios.id_usuario')
                          ->orderBy('fecha_venta', 'DESC')
                          ->limit(5)
                          ->get()
                          ->getResultArray();
        
        // Productos con bajo stock (<10 unidades)
        $productosBajoStock = $this->productoModel
                               ->where('stock <', 10)
                               ->where('stock >', 0)
                               ->where('activo', 1)
                               ->orderBy('stock', 'ASC')
                               ->limit(3)
                               ->get()
                               ->getResultArray();
        
        // Últimas reseñas (2 más recientes)
        $ultimasResenas = $this->resenaModel->select('resenas.*, productos.nombre as producto_nombre, personas.nombre, personas.apellido')
                           ->join('productos', 'productos.id_producto = resenas.producto_id')
                           ->join('usuarios', 'usuarios.id_usuario = resenas.usuario_id')
                           ->join('personas', 'personas.usuario_id = usuarios.id_usuario')
                           ->orderBy('resenas.fecha', 'DESC')
                           ->limit(2)
                           ->get()
                           ->getResultArray();
        
        $data = [
            'titulo' => 'Panel de Control',
            'totalVentasHoy' => $totalVentasHoy,
            'pedidosHoy' => count($ventasHoy),
            'totalProductos' => $totalProductos,
            'totalClientes' => $totalClientes,
            'ultimasVentas' => $ultimasVentas,
            'productosBajoStock' => $productosBajoStock,
            'ultimasResenas' => $ultimasResenas
        ];
        
        return view('header', $data) . view('navbar') . view('admin/panel', $data) . view('footer');
    }
}