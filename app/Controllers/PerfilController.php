<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PersonaModel;
use App\Models\DireccionModel;
use App\Models\VentaModel;
use App\Models\ResenaModel;
use App\Models\ConsultaModel;
use App\Models\DireccionEnvioModel;
use App\Models\PagoModel;
use App\Models\FacturaModel;
use App\Models\HistoricoVentaModel;

class PerfilController extends BaseController
{
    protected $usuarioModel;
    protected $personaModel;
    protected $direccionModel;
    protected $ventaModel;
    protected $resenaModel;
    protected $consultaModel;
    protected $direccionEnvioModel;
    protected $pagoModel;
    protected $facturaModel;
    protected $historicoVentaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->personaModel = new PersonaModel();
        $this->direccionModel = new DireccionModel();
        $this->ventaModel = new VentaModel();
        $this->resenaModel = new ResenaModel();
        $this->consultaModel = new ConsultaModel();
        $this->direccionEnvioModel = new DireccionEnvioModel();
        $this->pagoModel = new PagoModel();
        $this->facturaModel = new FacturaModel();
        $this->historicoVentaModel = new HistoricoVentaModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $usuario = $this->usuarioModel->getUsuarioCompleto($usuario_id);
        $direcciones = $this->direccionModel->getDireccionesByUsuario($usuario_id);
        $pedidos = $this->ventaModel->where('usuario_id', $usuario_id)->orderBy('fecha_venta', 'DESC')->findAll();
        $resenas = $this->resenaModel
            ->select('resenas.*, productos.nombre as nombre_producto, productos.imagen_url')
            ->join('productos', 'productos.id_producto = resenas.producto_id')
            ->where('resenas.usuario_id', $usuario_id)
            ->findAll();

        $data = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario,
            'direcciones' => $direcciones,
            'pedidos' => $pedidos,
            'resenas' => $resenas
        ];

        return view('header', $data) . view('navbar') . view('usuario/perfil/ver') . view('footer');
    }

    public function editarPerfil()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $usuario = $this->usuarioModel->getUsuarioCompleto($usuario_id);

        $data = [
            'titulo' => 'Editar Perfil',
            'usuario' => $usuario
        ];

        return view('header', $data) . view('navbar') . view('usuario/perfil/editar') . view('footer');
    }

    public function actualizarPerfil()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'username' => "required|min_length[3]|max_length[50]|is_unique[usuarios.username,id_usuario,{$usuario_id}]",
            'email' => "required|valid_email|max_length[100]|is_unique[usuarios.email,id_usuario,{$usuario_id}]"
        ], [
            'username' => [
                'required' => 'El nombre de usuario es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no debe exceder los 50 caracteres',
                'is_unique' => 'Este nombre de usuario ya está en uso'
            ],
            'email' => [
                'required' => 'El correo electrónico es obligatorio',
                'valid_email' => 'Debe ser un correo válido',
                'max_length' => 'No debe superar los 100 caracteres',
                'is_unique' => 'Este correo ya está registrado'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Actualizar datos del usuario
        $datosUsuario = [
            'username' => $request->getPost('username'),
            'email' => $request->getPost('email')
        ];

        $this->usuarioModel->update($usuario_id, $datosUsuario);

        // Actualizar datos personales
        $persona = $this->personaModel->where('usuario_id', $usuario_id)->first();
        
        $datosPersona = [
            'nombre' => $request->getPost('nombre'),
            'apellido' => $request->getPost('apellido'),
            'tipo_documento' => $request->getPost('tipo_documento'),
            'documento' => $request->getPost('documento'),
            'fecha_nacimiento' => $request->getPost('fecha_nacimiento'),
            'genero' => $request->getPost('genero'),
            'telefono' => $request->getPost('telefono')
        ];

        if ($persona) {
            $this->personaModel->update($persona['id_persona'], $datosPersona);
        } else {
            $datosPersona['usuario_id'] = $usuario_id;
            $this->personaModel->insert($datosPersona);
        }

        if (session()->getFlashdata('from_checkout')) {
            return redirect()->to('checkout/direccion')->with('message', 'Datos personales actualizados. Continúa con tu compra.');
        }
        return redirect()->to('perfil')->with('message', 'Perfil actualizado correctamente');
    }

    public function cambiarPassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $data = [
            'titulo' => 'Cambiar Contraseña'
        ];

        return view('header', $data) . view('navbar') . view('usuario/perfil/cambiar_password') . view('footer');
    }

    public function actualizarPassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ], [
            'current_password' => [
                'required' => 'La contraseña actual es obligatoria'
            ],
            'new_password' => [
                'required' => 'La nueva contraseña es obligatoria',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres'
            ],
            'confirm_password' => [
                'required' => 'Debe confirmar la nueva contraseña',
                'matches' => 'Las contraseñas no coinciden'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Verificar contraseña actual
        $usuario = $this->usuarioModel->find($usuario_id);
        if (!password_verify($request->getPost('current_password'), $usuario['password_hash'])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['current_password' => 'La contraseña actual es incorrecta']);
        }

        // Actualizar contraseña
        $nuevaPassword = password_hash($request->getPost('new_password'), PASSWORD_DEFAULT);
        $this->usuarioModel->update($usuario_id, ['password_hash' => $nuevaPassword]);

        return redirect()->to('perfil')->with('message', 'Contraseña actualizada correctamente');
    }

    public function misPedidos()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $pedidos = $this->ventaModel->where('usuario_id', $usuario_id)->orderBy('fecha_venta', 'DESC')->findAll();

        $data = [
            'titulo' => 'Mis Pedidos',
            'pedidos' => $pedidos
        ];

        return view('header', $data) . view('navbar') . view('usuario/compras/pedidos') . view('footer');
    }

    public function detallePedido($pedido_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $pedido = $this->ventaModel->find($pedido_id);

        // Verificar que el pedido pertenece al usuario
        if (!$pedido || $pedido['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/pedidos')->with('error', 'Pedido no encontrado');
        }

        $items = $this->ventaModel->getItemsVenta($pedido_id);
        $direccion = $this->direccionEnvioModel->where('venta_id', $pedido_id)->first();
        $pago = $this->pagoModel->where('venta_id', $pedido_id)->first();
        $historico = $this->historicoVentaModel->where('venta_id', $pedido_id)->orderBy('fecha', 'DESC')->findAll();

        $badgeClass = [
            'pendiente' => 'warning',
            'pagado' => 'primary',
            'enviado' => 'info',
            'entregado' => 'success',
            'cancelado' => 'danger'
        ];

        $data = [
            'titulo' => 'Detalle del Pedido #' . $pedido_id,
            'pedido' => $pedido,
            'items' => $items,
            'direccion' => $direccion,
            'pago' => $pago,
            'historico' => $historico,
            'badgeClass' => $badgeClass
        ];

        return view('header', $data) . view('navbar') . view('usuario/compras/detalle_pedido') . view('footer');
    }

    public function factura($pedido_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $pedido = $this->ventaModel->find($pedido_id);

        // Verificar que el pedido pertenece al usuario
        if (!$pedido || $pedido['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/pedidos')->with('error', 'Pedido no encontrado');
        }

        $items = $this->ventaModel->getItemsVenta($pedido_id);
        $factura = $this->facturaModel->where('venta_id', $pedido_id)->first();
        $configuracion = (new \App\Models\ConfiguracionModel())->find(1);
        $usuario = $this->usuarioModel->getUsuarioCompleto($usuario_id);
        $direccion = $this->direccionEnvioModel->where('venta_id', $pedido_id)->first();
        $pago = $this->pagoModel->where('venta_id', $pedido_id)->first();

        $data = [
            'titulo' => 'Factura #' . $pedido_id,
            'pedido' => $pedido,
            'items' => $items,
            'factura' => $factura,
            'configuracion' => $configuracion,
            'usuario' => $usuario,
            'direccion' => $direccion,
            'pago' => $pago
        ];

        return view('header', $data) . view('navbar') . view('usuario/compras/factura') . view('footer');
    }

    public function misDirecciones()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $direcciones = $this->direccionModel->getDireccionesByUsuario($usuario_id);

        $data = [
            'titulo' => 'Mis Direcciones',
            'direcciones' => $direcciones
        ];

        return view('header', $data) . view('navbar') . view('usuario/direcciones/listar') . view('footer');
    }

    public function agregarDireccion()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $data = [
            'titulo' => 'Agregar Dirección'
        ];

        return view('header', $data) . view('navbar') . view('usuario/direcciones/agregar') . view('footer');
    }

    public function guardarDireccion()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'alias' => 'required|max_length[50]',
            'tipo' => 'required|in_list[particular,fiscal,envio,trabajo]',
            'direccion' => 'required|max_length[255]',
            'codigo_postal' => 'required|max_length[10]',
            'ciudad' => 'required|max_length[100]',
            'provincia' => 'required|max_length[100]'
        ], [
            'alias' => [
                'required' => 'El alias es obligatorio',
                'max_length' => 'El alias no debe exceder los 50 caracteres'
            ],
            'tipo' => [
                'required' => 'El tipo es obligatorio',
                'in_list' => 'Tipo de dirección inválido'
            ],
            'direccion' => [
                'required' => 'La dirección es obligatoria',
                'max_length' => 'La dirección no debe exceder los 255 caracteres'
            ],
            'codigo_postal' => [
                'required' => 'El código postal es obligatorio',
                'max_length' => 'El código postal no debe exceder los 10 caracteres'
            ],
            'ciudad' => [
                'required' => 'La ciudad es obligatoria',
                'max_length' => 'La ciudad no debe exceder los 100 caracteres'
            ],
            'provincia' => [
                'required' => 'La provincia es obligatoria',
                'max_length' => 'La provincia no debe exceder los 100 caracteres'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $es_principal = $request->getPost('es_principal') ? 1 : 0;

        // Si se marca como principal, quitar principal de otras direcciones
        if ($es_principal) {
            $this->direccionModel->where('usuario_id', $usuario_id)->set(['es_principal' => 0])->update();
        }

        $data = [
            'usuario_id' => $usuario_id,
            'tipo' => $request->getPost('tipo'),
            'alias' => $request->getPost('alias'),
            'direccion' => $request->getPost('direccion'),
            'codigo_postal' => $request->getPost('codigo_postal'),
            'ciudad' => $request->getPost('ciudad'),
            'provincia' => $request->getPost('provincia'),
            'pais' => $request->getPost('pais') ?? 'Argentina',
            'es_principal' => $es_principal
        ];

        $this->direccionModel->insert($data);

        // Cambios: Si viene del checkout, guardar el id y redirigir
        if ($request->getPost('from_checkout')) {
            $nueva_id = $this->direccionModel->getInsertID();
            session()->set('checkout_data', ['direccion_id' => $nueva_id]);
            return redirect()->to('checkout/direccion')->with('message', 'Dirección guardada correctamente');
        }

        return redirect()->to('perfil/direcciones')->with('message', 'Dirección agregada correctamente');
    }

    public function editarDireccion($direccion_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $direccion = $this->direccionModel->find($direccion_id);

        // Verificar que la dirección pertenece al usuario
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/direcciones')->with('error', 'Dirección no encontrada');
        }

        $data = [
            'titulo' => 'Editar Dirección',
            'direccion' => $direccion
        ];

        return view('header', $data) . view('navbar') . view('usuario/direcciones/editar') . view('footer');
    }

    public function actualizarDireccion($direccion_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $direccion = $this->direccionModel->find($direccion_id);

        // Verificar que la dirección pertenece al usuario
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/direcciones')->with('error', 'Dirección no encontrada');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'alias' => 'required|max_length[50]',
            'tipo' => 'required|in_list[particular,fiscal,envio,trabajo]',
            'direccion' => 'required|max_length[255]',
            'codigo_postal' => 'required|max_length[10]',
            'ciudad' => 'required|max_length[100]',
            'provincia' => 'required|max_length[100]'
        ], [
            'alias' => [
                'required' => 'El alias es obligatorio',
                'max_length' => 'El alias no debe exceder los 50 caracteres'
            ],
            'tipo' => [
                'required' => 'El tipo es obligatorio',
                'in_list' => 'Tipo de dirección inválido'
            ],
            'direccion' => [
                'required' => 'La dirección es obligatoria',
                'max_length' => 'La dirección no debe exceder los 255 caracteres'
            ],
            'codigo_postal' => [
                'required' => 'El código postal es obligatorio',
                'max_length' => 'El código postal no debe exceder los 10 caracteres'
            ],
            'ciudad' => [
                'required' => 'La ciudad es obligatoria',
                'max_length' => 'La ciudad no debe exceder los 100 caracteres'
            ],
            'provincia' => [
                'required' => 'La provincia es obligatoria',
                'max_length' => 'La provincia no debe exceder los 100 caracteres'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $es_principal = $request->getPost('es_principal') ? 1 : 0;

        // Si se marca como principal, quitar principal de otras direcciones
        if ($es_principal) {
            $this->direccionModel->where('usuario_id', $usuario_id)->set(['es_principal' => 0])->update();
        }

        $data = [
            'tipo' => $request->getPost('tipo'),
            'alias' => $request->getPost('alias'),
            'direccion' => $request->getPost('direccion'),
            'codigo_postal' => $request->getPost('codigo_postal'),
            'ciudad' => $request->getPost('ciudad'),
            'provincia' => $request->getPost('provincia'),
            'pais' => $request->getPost('pais') ?? 'Argentina',
            'es_principal' => $es_principal
        ];

        $this->direccionModel->update($direccion_id, $data);

        return redirect()->to('perfil/direcciones')->with('message', 'Dirección actualizada correctamente');
    }

    public function eliminarDireccion($direccion_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $direccion = $this->direccionModel->find($direccion_id);

        // Verificar que la dirección pertenece al usuario
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/direcciones')->with('error', 'Dirección no encontrada');
        }

        $this->direccionModel->delete($direccion_id);

        return redirect()->to('perfil/direcciones')->with('message', 'Dirección eliminada correctamente');
    }

    public function setDireccionPrincipal($direccion_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $direccion = $this->direccionModel->find($direccion_id);

        // Verificar que la dirección pertenece al usuario
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/direcciones')->with('error', 'Dirección no encontrada');
        }

        $this->direccionModel->setDireccionPrincipal($direccion_id, $usuario_id);

        return redirect()->to('perfil/direcciones')->with('message', 'Dirección principal actualizada');
    }

    public function misResenas()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        
        // Reseñas existentes
        $resenas = $this->resenaModel
            ->select('resenas.*, productos.nombre as nombre_producto, productos.imagen_url')
            ->join('productos', 'productos.id_producto = resenas.producto_id')
            ->where('resenas.usuario_id', $usuario_id)
            ->orderBy('resenas.fecha', 'DESC')
            ->findAll();
        
        // Productos comprados pero no reseñados
        $productosSinResena = $this->resenaModel->getProductosCompradosNoResenados($usuario_id);

        $data = [
            'titulo' => 'Mis Reseñas',
            'resenas' => $resenas,
            'productosSinResena' => $productosSinResena
        ];

        return view('header', $data) . view('navbar') . view('usuario/resenas/listar') . view('footer');
    }

    public function agregarResena($producto_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        
        // Verificar que el usuario compró el producto
        if (!$this->resenaModel->usuarioComproProducto($usuario_id, $producto_id)) {
            return redirect()->to('perfil/resenas')->with('error', 'Debes haber comprado este producto para poder reseñarlo');
        }

        $productoModel = new \App\Models\ProductoModel();
        $producto = $productoModel->find($producto_id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }

        // Verificar si el usuario ya ha reseñado este producto
        if ($this->resenaModel->usuarioYaReseno($producto_id, $usuario_id)) {
            return redirect()->to('perfil/resenas')->with('error', 'Ya has reseñado este producto');
        }

        $data = [
            'titulo' => 'Agregar Reseña',
            'producto' => $producto
        ];

        return view('header', $data) . view('navbar') . view('usuario/resenas/agregar') . view('footer');
    }

    public function editarResena($resena_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $resena = $this->resenaModel->find($resena_id);

        // Verificar que la reseña pertenece al usuario
        if (!$resena || $resena['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/resenas')->with('error', 'Reseña no encontrada');
        }

        $productoModel = new \App\Models\ProductoModel();
        $producto = $productoModel->find($resena['producto_id']);

        $data = [
            'titulo' => 'Editar Reseña',
            'resena' => $resena,
            'producto' => $producto
        ];

        return view('header', $data) . view('navbar') . view('usuario/resenas/editar') . view('footer');
    }

    public function actualizarResena($resena_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $resena = $this->resenaModel->find($resena_id);

        // Verificar que la reseña pertenece al usuario
        if (!$resena || $resena['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/resenas')->with('error', 'Reseña no encontrada');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'calificacion' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'comentario' => 'required|min_length[10]|max_length[500]'
        ], [
            'calificacion' => [
                'required' => 'La calificación es obligatoria.',
                'integer' => 'La calificación debe ser un número entero.',
                'greater_than_equal_to' => 'La calificación mínima es 1.',
                'less_than_equal_to' => 'La calificación máxima es 5.'
            ],
            'comentario' => [
                'required' => 'El comentario es obligatorio.',
                'min_length' => 'El comentario debe tener al menos 10 caracteres.',
                'max_length' => 'El comentario no debe exceder los 500 caracteres.'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $data = [
            'calificacion' => $request->getPost('calificacion'),
            'comentario' => $request->getPost('comentario'),
            'fecha' => date('Y-m-d H:i:s') // Actualizar fecha de modificación
        ];

        $this->resenaModel->update($resena_id, $data);

        return redirect()->to('perfil/resenas')->with('message', 'Reseña actualizada correctamente');
    }

    public function guardarResena($producto_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $productoModel = new \App\Models\ProductoModel();
        $producto = $productoModel->find($producto_id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }

        // Verificar si el usuario ya ha reseñado este producto
        if ($this->resenaModel->usuarioYaReseno($producto_id, $usuario_id)) {
            return redirect()->to('perfil/resenas')->with('error', 'Ya has reseñado este producto');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'calificacion' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'comentario' => 'required|min_length[10]|max_length[500]'
        ], [
            'calificacion' => [
                'required' => 'La calificación es obligatoria.',
                'integer' => 'La calificación debe ser un número entero.',
                'greater_than_equal_to' => 'La calificación mínima es 1.',
                'less_than_equal_to' => 'La calificación máxima es 5.'
            ],
            'comentario' => [
                'required' => 'El comentario es obligatorio.',
                'min_length' => 'El comentario debe tener al menos 10 caracteres.',
                'max_length' => 'El comentario no debe exceder los 500 caracteres.'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $data = [
            'producto_id' => $producto_id,
            'usuario_id' => $usuario_id,
            'calificacion' => $request->getPost('calificacion'),
            'comentario' => $request->getPost('comentario')
        ];

        $this->resenaModel->insert($data);

        return redirect()->to('perfil/resenas')->with('message', 'Reseña agregada correctamente');
    }

    public function eliminarResena($resena_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $resena = $this->resenaModel->find($resena_id);

        // Verificar que la reseña pertenece al usuario
        if (!$resena || $resena['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/resenas')->with('error', 'Reseña no encontrada');
        }

        $this->resenaModel->delete($resena_id);

        return redirect()->to('perfil/resenas')->with('message', 'Reseña eliminada correctamente');
    }

    public function devoluciones()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $pedidos = $this->ventaModel->where('usuario_id', $usuario_id)->orderBy('fecha_venta', 'DESC')->findAll();

        $data = [
            'titulo' => 'Mis Devoluciones',
            'pedidos' => $pedidos
        ];

        return view('header', $data) . view('navbar') . view('usuario/devoluciones') . view('footer');
    }

    public function nuevaDevolucion($pedido_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $pedido = $this->ventaModel->find($pedido_id);

        // Verificar que el pedido pertenece al usuario
        if (!$pedido || $pedido['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/devoluciones')->with('error', 'Pedido no encontrado');
        }

        $items = $this->ventaModel->getItemsVenta($pedido_id);

        $data = [
            'titulo' => 'Nueva Devolución',
            'pedido' => $pedido,
            'items' => $items,
            'validation' => session()->get('validation')
        ];

        return view('header', $data) . view('navbar') . view('usuario/nueva_devolucion') . view('footer');
    }

    public function guardarDevolucion($pedido_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $pedido = $this->ventaModel->find($pedido_id);

        // Verificar que el pedido pertenece al usuario
        if (!$pedido || $pedido['usuario_id'] != $usuario_id) {
            return redirect()->to('perfil/devoluciones')->with('error', 'Pedido no encontrado');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'productos' => 'required',
            'motivo' => 'required|min_length[10]|max_length[500]'
        ], [
            'productos' => [
                'required' => 'Debes seleccionar al menos un producto.'
            ],
            'motivo' => [
                'required' => 'El motivo es obligatorio.',
                'min_length' => 'El motivo debe tener al menos 10 caracteres.',
                'max_length' => 'El motivo no debe exceder los 500 caracteres.'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Procesar la devolución
        $productos = $request->getPost('productos');
        $motivo = $request->getPost('motivo');

        // Aquí iría la lógica para guardar la devolución en la base de datos
        // Por ahora solo redirigimos con un mensaje de éxito
        return redirect()->to('perfil/devoluciones')->with('message', 'Devolución solicitada correctamente');
    }

    public function detalleDevolucion($devolucion_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        // En una aplicación real, aquí obtendrías los detalles de la devolución
        // y verificarías que pertenece al usuario

        $data = [
            'titulo' => 'Detalle de Devolución'
        ];

        return view('header', $data) . view('navbar') . view('usuario/detalle_devolucion') . view('footer');
    }
}