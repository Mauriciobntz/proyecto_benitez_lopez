<?php namespace App\Controllers;

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
        $data['productos'] = $this->productoModel->findAll();
        return view('productos/index', $data);
    }

    public function porCategoria($categoria_id)
    {
        $data['productos'] = $this->productoModel->conCategoria($categoria_id);
        $data['categoria'] = $this->categoriaModel->find($categoria_id);
        return view('productos/por_categoria', $data);
    }

    public function mostrar($id)
    {
        $data['producto'] = $this->productoModel->find($id);
        return view('productos/mostrar', $data);
    }
}