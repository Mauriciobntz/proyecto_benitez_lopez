<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas públicas
$routes->get('principal', 'Home::index');
$routes->get('somos', 'Home::somos');
$routes->get('productos', 'Home::productos');
$routes->get('celulares', 'Home::celulares');
$routes->get('notebooks', 'Home::notebooks');
$routes->get('auriculares', 'Home::auriculares');
$routes->get('perifericos', 'Home::perifericos');
$routes->get('tablets', 'Home::tablets');
$routes->get('contacto', 'Home::contacto');
$routes->get('producto', 'Home::producto');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('consultas', 'Home::consultas');
$routes->get('terminos', 'Home::terminos');
//borrar
$routes->get('panel', 'Home::panel');
$routes->get('denegado', 'Home::denegado');



// Rutas de autenticación
$routes->get('login', 'UsuarioController::formularioLogin');
$routes->post('login', 'UsuarioController::procesarLogin');
$routes->get('logout', 'UsuarioController::cerrarSesion');

// Rutas de registro
$routes->get('sign', 'UsuarioController::formularioRegistro');
$routes->post('sign', 'UsuarioController::procesarRegistro');

//######################## Rutas Productos ########################

// Rutas públicas (accesibles sin autenticación)
$routes->get('productos', [ProductoController::class, 'listar']);
//$routes->get('productos', [ProductoController::class, 'listarDestacados']);
$routes->get('productos/categoria/(:num)', [ProductoController::class, 'listarPorCategoria']);
$routes->get('productos/buscar', [ProductoController::class, 'buscar']);
$routes->get('productos/(:num)', [ProductoController::class, 'detalle']);

// Rutas protegidas (requieren autenticación)
$routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena'], ['filter' => 'auth']);



// Rutas de administrador (requieren rol admin)
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('productos/crear', [ProductoController::class, 'agregarProducto']);
    $routes->post('productos/guardar', [ProductoController::class, 'guardarProducto']);
    $routes->get('productos/editar/(:num)', [ProductoController::class, 'editarProducto']);
    $routes->post('productos/actualizar/(:num)', [ProductoController::class, 'actualizarProducto']);
});

