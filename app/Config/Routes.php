<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\ProductoController;
use App\Controllers\Home;
use App\Controllers\UsuarioController;
use App\Controllers\CategoriaController;
use App\Controllers\VentaController;
use App\Controllers\ConsultaController;
use App\Controllers\ResenaController;
use App\Controllers\PanelController;
use App\Controllers\ConfiguracionController;
use App\Controllers\CarruselController;
use App\Controllers\DestacadosController;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// Rutas públicas
$routes->get('principal', 'Home::index');
$routes->get('somos', 'Home::somos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('terminos', 'Home::terminos');
//borrar
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
$routes->get('productos', [ProductoController::class, 'productos']);
$routes->get('productos/destacados', [ProductoController::class, 'listarDestacados']);
$routes->get('productos/categoria/(:num)', [ProductoController::class, 'productosPorCategoria']);
$routes->get('productos/buscar', [ProductoController::class, 'buscar']);
$routes->get('productos/(:num)', [ProductoController::class, 'detalle']);
$routes->get('contacto', 'ConsultaController::formularioContacto');
$routes->post('contacto/procesar', 'ConsultaController::procesarConsulta');

// Rutas protegidas (requieren autenticación)
$routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena'], ['filter' => 'auth']);



// Rutas de administrador (requieren rol admin)
$routes->group('admin', ['filter' => 'admin'], function($routes) {

    // Rutas para el panel de administración
    $routes->get('panel', [PanelController::class, 'verPanel']);

    $routes->get('productos/listar', [ProductoController::class, 'listar']);
    $routes->get('productos/crear', [ProductoController::class, 'agregarProducto']);
    $routes->post('productos/guardar', [ProductoController::class, 'guardarProducto']);
    $routes->get('productos/editar/(:num)', [ProductoController::class, 'editarProducto']);
    $routes->post('productos/actualizar/(:num)', [ProductoController::class, 'actualizarProducto']);
    $routes->post('productos/verificar-ventas/(:num)', [ProductoController::class, 'verificarVentas']);
    $routes->post('productos/desactivar/(:num)', [ProductoController::class, 'desactivar']);
    $routes->post('productos/eliminar/(:num)', [ProductoController::class, 'eliminar']);

    // Rutas para categorías
    $routes->get('categorias/listar', [CategoriaController::class, 'listar']);
    $routes->get('categorias/crear', [CategoriaController::class, 'crear']);
    $routes->post('categorias/guardar', [CategoriaController::class, 'guardar']);
    $routes->get('categorias/editar/(:num)', [CategoriaController::class, 'editar']);
    $routes->post('categorias/actualizar', [CategoriaController::class, 'actualizar']);
    $routes->get('categorias/eliminar/(:num)', [CategoriaController::class, 'eliminar']);

    // Rutas para ventas
    $routes->get('ventas/listar', [VentaController::class, 'listar']);
    $routes->get('ventas/detalle/(:num)', [VentaController::class, 'detalle']);
    $routes->post('ventas/actualizar-estado/(:num)', [VentaController::class, 'actualizarEstado']);
    $routes->get('ventas/factura/(:num)', [VentaController::class, 'generarFactura']);

    // Usuarios
    $routes->get('usuarios/listar', [UsuarioController::class, 'listarUsuarios']);
    $routes->get('usuarios/editar/(:num)', [UsuarioController::class, 'editarUsuario']);
    $routes->post('usuarios/actualizar/(:num)', [UsuarioController::class, 'actualizarUsuario']);
    $routes->get('usuarios/perfil/(:num)', [UsuarioController::class, 'perfilUsuario']);
    


    // Consultas
    $routes->get('consultas/listar', [ConsultaController::class, 'listarConsultas']);
    $routes->get('consultas/detalle/(:num)', [ConsultaController::class, 'detalleConsulta']);
    $routes->post('consultas/actualizar-estado/(:num)', [ConsultaController::class, 'actualizarEstado']);

    // Reseñas
    $routes->get('resenas/listar', [ResenaController::class, 'listar']);
    $routes->get('resenas/editar/(:num)', [ResenaController::class, 'editar']);
    $routes->post('resenas/actualizar/(:num)', [ResenaController::class, 'actualizar']);
    $routes->get('resenas/eliminar/(:num)', [ResenaController::class, 'eliminar']);

    // Configuración de la tienda
    $routes->get('configuracion/tienda/ver', [ConfiguracionController::class, 'ver']);
    $routes->get('configuracion/tienda/editar', [ConfiguracionController::class, 'editar']);
    $routes->post('configuracion/tienda/actualizar', [ConfiguracionController::class, 'actualizar']);

    // Configuracion para el carrusel
    $routes->get('configuracion/carrusel/listar', [CarruselController::class, 'listar']);
    $routes->get('configuracion/carrusel/crear', [CarruselController::class, 'crear']);
    $routes->post('configuracion/carrusel/guardar', [CarruselController::class, 'guardar']);
    $routes->get('configuracion/carrusel/editar/(:num)', [CarruselController::class, 'editar']);
    $routes->post('configuracion/carrusel/actualizar/(:num)', [CarruselController::class, 'actualizar']);
    $routes->get('configuracion/carrusel/eliminar/(:num)', [CarruselController::class, 'eliminar']);

    // Configuracion para los destacados
    $routes->get('configuracion/destacados/listar', [DestacadosController::class, 'listar']);
    $routes->get('configuracion/destacados/crear', [DestacadosController::class, 'crear']);
    $routes->post('configuracion/destacados/guardar', [DestacadosController::class, 'guardar']);
    $routes->get('configuracion/destacados/editar/(:num)', [DestacadosController::class, 'editar']);
    $routes->post('configuracion/destacados/actualizar/(:num)', [DestacadosController::class, 'actualizar']);
    $routes->get('configuracion/destacados/eliminar/(:num)', [DestacadosController::class, 'eliminar']);
});




$routes->group('usuario', ['filter' => 'auth'], function($routes) {
    $routes->get('mi-perfil', [UsuarioController::class, 'miPerfil']);
    $routes->post('actualizar-perfil', [UsuarioController::class, 'actualizarPerfil']);
    $routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena']);
    $routes->get('mis-resenas', [ProductoController::class, 'misResenas']);
});

