<?php namespace App\Controllers;

use App\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $data['categorias'] = $this->categoriaModel->findAll();
        return view('categorias/index', $data);
    }

    public function mostrar($id)
    {
        $data['categoria'] = $this->categoriaModel->find($id);
        return view('categorias/mostrar', $data);
    }
}