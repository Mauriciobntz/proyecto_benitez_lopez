<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\ProductoController;
use App\Controllers\CategoriaController;
use App\Controllers\Home;
use App\Controllers\UsuarioController;
use App\Controllers\VentaController;
use App\Controllers\ConsultaController;
use App\Controllers\ResenaController;
use App\Controllers\PanelController;
use App\Controllers\ConfiguracionController;
use App\Controllers\CarruselController;
use App\Controllers\DestacadosController;
use App\Controllers\CarritoController;
use App\Controllers\PerfilController;
use App\Controllers\CheckoutController;

/**
 * @var RouteCollection $routes
 */


//######################## Rutas Publicas ########################

$routes->get('/', 'Home::index');
$routes->get('principal', 'Home::index');
$routes->get('somos', 'Home::somos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('terminos', 'Home::terminos');
$routes->get('denegado', 'Home::denegado');

//######################## Rutas Productos ########################

$routes->get('productos', [ProductoController::class, 'productos']);
$routes->get('productos/destacados', [ProductoController::class, 'listarDestacados']);
$routes->get('productos/categoria/(:num)', [ProductoController::class, 'productosPorCategoria']);
$routes->get('productos/buscar', [ProductoController::class, 'buscar']);
$routes->get('productos/(:num)', [ProductoController::class, 'detalle']);

//######################## Rutas Contacto ########################

$routes->get('contacto', 'ConsultaController::formularioContacto');
$routes->post('contacto/procesar', 'ConsultaController::procesarConsulta');


//######################## Rutas de autenticación ########################


$routes->get('login', 'UsuarioController::formularioLogin');
$routes->post('login', 'UsuarioController::procesarLogin');
$routes->get('logout', 'UsuarioController::cerrarSesion');

// Rutas de registro
$routes->get('sign', 'UsuarioController::formularioRegistro');
$routes->post('sign', 'UsuarioController::procesarRegistro');



// Rutas protegidas (requieren autenticación)
$routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena'], ['filter' => 'auth']);




//######################## Rutas de administrador (requieren rol admin) ########################


$routes->group('admin', ['filter' => 'admin'], function($routes) {

    // Ruta para el panel de administración
    $routes->get('panel', [PanelController::class, 'verPanel']);

    // Rutas para Productos
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




//######################## Rutas del usuario autenticado ########################


$routes->group('', ['filter' => 'auth'], function($routes) {

    // Rutas del carrito
    $routes->get('carrito', [CarritoController::class, 'verCarrito']);
    $routes->post('carrito/agregar/(:num)', [CarritoController::class, 'agregarProducto']);
    $routes->post('carrito/actualizar/(:num)', [CarritoController::class, 'actualizarCantidad']);
    $routes->get('carrito/eliminar/(:num)', [CarritoController::class, 'eliminarItem']);
    $routes->get('carrito/vaciar', [CarritoController::class, 'vaciarCarrito']);

    // Rutas de compra
    $routes->get('checkout/direccion', 'CheckoutController::direccionEnvio');
    $routes->post('checkout/guardar-direccion', 'CheckoutController::guardarDireccionEnvio');
    $routes->get('checkout/resumen', 'CheckoutController::resumenPedido');
    $routes->post('checkout/confirmar-resumen', 'CheckoutController::confirmarResumen');
    $routes->get('checkout/pago', 'CheckoutController::pago');
    $routes->post('checkout/procesar-pago', 'CheckoutController::procesarPago');
    $routes->get('checkout/confirmacion/(:num)', 'CheckoutController::confirmacion/$1');
});


// Perfil de usuario
$routes->group('perfil', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'PerfilController::index');
    
    // Edición de perfil
    $routes->get('editar', 'PerfilController::editarPerfil');
    $routes->post('actualizar', 'PerfilController::actualizarPerfil');
    
    // Cambio de contraseña
    $routes->get('cambiar-password', 'PerfilController::cambiarPassword');
    $routes->post('actualizar-password', 'PerfilController::actualizarPassword');
    
    // Pedidos
    $routes->get('pedidos', 'PerfilController::misPedidos');
    $routes->get('pedidos/(:num)', 'PerfilController::detallePedido/$1');
    $routes->get('factura/(:num)', 'PerfilController::factura/$1');
    
    // Direcciones
    $routes->get('direcciones', 'PerfilController::misDirecciones');
    $routes->get('direcciones/agregar', 'PerfilController::agregarDireccion');
    $routes->post('direcciones/guardar', 'PerfilController::guardarDireccion');
    $routes->get('direcciones/editar/(:num)', 'PerfilController::editarDireccion/$1');
    $routes->post('direcciones/actualizar/(:num)', 'PerfilController::actualizarDireccion/$1');
    $routes->get('direcciones/eliminar/(:num)', 'PerfilController::eliminarDireccion/$1');
    $routes->get('direcciones/principal/(:num)', 'PerfilController::setDireccionPrincipal/$1');
    
    // Reseñas
    $routes->get('resenas', 'PerfilController::misResenas');
    $routes->get('resenas/agregar/(:num)', 'PerfilController::agregarResena/$1');
    $routes->post('resenas/guardar/(:num)', 'PerfilController::guardarResena/$1');
    $routes->get('resenas/editar/(:num)', 'PerfilController::editarResena/$1');
    $routes->post('resenas/actualizar/(:num)', 'PerfilController::actualizarResena/$1');
    $routes->get('resenas/eliminar/(:num)', 'PerfilController::eliminarResena/$1');
    
    // Devoluciones
    $routes->get('devoluciones', 'PerfilController::devoluciones');
    $routes->get('devoluciones/nueva/(:num)', 'PerfilController::nuevaDevolucion/$1');
    $routes->post('devoluciones/guardar/(:num)', 'PerfilController::guardarDevolucion/$1');
    $routes->get('devoluciones/(:num)', 'PerfilController::detalleDevolucion/$1');
});