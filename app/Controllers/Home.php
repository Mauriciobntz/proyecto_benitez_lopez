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

