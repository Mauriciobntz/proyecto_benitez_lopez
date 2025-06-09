<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si el usuario está logueado
        if (!session()->get('logged_in')) {
            return redirect()->to('login')
                ->with('error', 'Debes iniciar sesión primero');
        }

        // Verificar si el usuario tiene rol de administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')
                ->with('error', 'No tienes permisos de administrador');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos hacer nada después de la ejecución del controlador
    }
}