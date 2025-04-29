<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['titulo']='Principal';
        return view('header', $data).view('navbar').view('carousel').view('principal').view('footer');
    }
    public function somos(): string
    {
        $data['titulo']='Quienes Somos';
        return view('header', $data).view('navbar').view('quienes_somos').view('footer');
    }
    public function productos(): string
    {
        $data['titulo']='Productos';
        return view('header', $data).view('navbar').view('productos').view('footer');
    }
    public function contacto(): string
    {
        $data['titulo']='Contacto';
        return view('header', $data).view('navbar').view('contacto').view('footer');
    }
    public function producto(): string
    {
        $data['titulo']='Producto';
        return view('header', $data).view('navbar').view('producto').view('footer');
    }
    public function celulares(): string
    {
        $data['titulo']='Celulares';
        return view('header', $data).view('navbar').view('celulares').view('footer');
    }
    public function auriculares(): string
    {
        $data['titulo']='Auriculares';
        return view('header', $data).view('navbar').view('auriculares').view('footer');
    }
    public function notebooks(): string
    {
        $data['titulo']='Notebooks';
        return view('header', $data).view('navbar').view('notebooks').view('footer');
    }
    public function perifericos(): string
    {
        $data['titulo']='Perifericos';
        return view('header', $data).view('navbar').view('perifericos').view('footer');
    }
    public function tablets(): string
    {
        $data['titulo']='Tablets';
        return view('header', $data).view('navbar').view('tablets').view('footer');
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
    public function login(): string
    {
        $data['titulo']='Login';
        return view('header', $data).view('navbar').view('login').view('footer');
    }
    public function sign(): string
    {
        $data['titulo']='Sign';
        return view('header', $data).view('navbar').view('sign').view('footer');
    }
    public function terminos(): string
    {
        $data['titulo']='Terminos de uso';
        return view('header', $data).view('navbar').view('terminos_usos').view('footer');
    }
}
