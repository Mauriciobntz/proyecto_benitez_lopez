<?php
namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProductoModel;

class CategoriaController extends BaseController
{
    protected $categoriaModel;
    protected $productoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->productoModel = new ProductoModel();
    }

    public function listarCategorias()
    {
        $categorias = $this->categoriaModel->getCategoriasConProductos();
        
        $data = [
            'titulo' => 'Categorías',
            'categorias' => $categorias
        ];

        return view('header', $data) . view('navbar') . view('categorias') . view('footer');
    }

    public function productosPorCategoria($categoria_id)
    {
        $categoria = $this->categoriaModel->find($categoria_id);
        $productos = $this->productoModel->getProductosByCategoria($categoria_id);
        
        $data = [
            'titulo' => $categoria['nombre'],
            'productos' => $productos,
            'categoria' => $categoria
        ];

        return view('header', $data) . view('navbar') . view('productos_categoria') . view('footer');
    }
}