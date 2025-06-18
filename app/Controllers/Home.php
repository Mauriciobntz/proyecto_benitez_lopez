<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Home extends BaseController
{
        protected $categoriaModel;

    public function index(): string
    {
        $this->categoriaModel = new CategoriaModel();
        $categorias = $this->categoriaModel->getCategoriasParaMostrar();
        $data = [
            'titulo' => 'Principal',
            'categorias' => $categorias,
        ];
        return view('header', $data).view('navbar').view('principal/carousel').view('principal/destacados').view('principal/mas_vendidos').view('principal/nuevos_ingresos').view('principal/categorias', $data).view('footer');
    }
    public function somos(): string
    {
        $data['titulo']='Quienes Somos';
        return view('header', $data).view('navbar').view('quienes_somos').view('footer');
    }
    public function contacto(): string
    {
        $data['titulo']='Contacto';
        return view('header', $data).view('navbar').view('contacto').view('footer');
    }
    public function comercializacion(): string
    {
        $data['titulo']='Comercilizacion';
        return view('header', $data).view('navbar').view('comercializacion').view('footer');
    }
    public function consultas(): string
    {
        $data['titulo']='Consultas';
        return view('header', $data).view('navbar').view('consultas').view('footer');
    }
    public function terminos(): string
    {
        $data['titulo']='Terminos de uso';
        return view('header', $data).view('navbar').view('terminos_usos').view('footer');
    }
    public function denegado(): string
    {
        $data['titulo']='Panel';
        return view('header', $data).view('navbar').view('alertas/acceso_denegado').view('footer');
    }
}

