<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    
    public function index()
    {
        $data = [
            'productos' => $this->productoModel->where('activo', 1)->findAll(),
            'categorias' => $this->categoriaModel->findAll()
        ];
        
        return view('customer/productos/index', $data);
    }
    
    public function show($id)
    {
        $producto = $this->productoModel->find($id);
        
        if (!$producto || !$producto->activo) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
        
        return view('customer/productos/show', ['producto' => $producto]);
    }
    
    public function byCategory($categoria_id)
    {
        $data = [
            'productos' => $this->productoModel->where('categoria_id', $categoria_id)
                                              ->where('activo', 1)
                                              ->findAll(),
            'categoria' => $this->categoriaModel->find($categoria_id)
        ];
        
        return view('customer/productos/by_category', $data);
    }
}