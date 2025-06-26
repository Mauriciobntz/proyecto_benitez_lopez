<?php
namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\CarritoItemModel;
use App\Models\ProductoModel;
use App\Models\VentaModel;
use App\Models\VentaItemModel;
use App\Models\PagoModel;
use App\Models\DireccionEnvioModel;
use App\Models\DireccionModel;
use App\Models\PersonaModel;
use App\Models\HistoricoVentaModel;

class CheckoutController extends BaseController
{
    protected $carritoModel;
    protected $carritoItemModel;
    protected $productoModel;
    protected $ventaModel;
    protected $ventaItemModel;
    protected $pagoModel;
    protected $direccionEnvioModel;
    protected $direccionModel;
    protected $personaModel;
    protected $historicoVentaModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->carritoItemModel = new CarritoItemModel();
        $this->productoModel = new ProductoModel();
        $this->ventaModel = new VentaModel();
        $this->ventaItemModel = new VentaItemModel();
        $this->pagoModel = new PagoModel();
        $this->direccionEnvioModel = new DireccionEnvioModel();
        $this->direccionModel = new DireccionModel();
        $this->personaModel = new PersonaModel();
        $this->historicoVentaModel = new HistoricoVentaModel();
    }

    // Paso 0: Iniciar checkout desde el carrito
    public function iniciarCheckout()
    {
        $usuario_id = session()->get('id_usuario');
        if (!$usuario_id) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión para comprar.');
        }
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        if (!$carrito) {
            return redirect()->to('carrito')->with('error', 'No tienes productos en el carrito.');
        }
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'No tienes productos en el carrito.');
        }
        // Verificar datos personales completos
        $persona = $this->personaModel->getPersonaByUsuario($usuario_id);
        $faltanDatos = false;
        $camposRequeridos = ['nombre', 'apellido', 'tipo_documento', 'documento', 'telefono'];
        foreach ($camposRequeridos as $campo) {
            if (empty($persona[$campo])) {
                $faltanDatos = true;
                break;
            }
        }
        if ($faltanDatos) {
            // Marcar que viene del checkout
            return redirect()->to('perfil/editar')->with('from_checkout', true);
        }
        // Limpiar datos de checkout previos
        session()->remove('checkout_data');
        return redirect()->to('checkout/direccion');
    }

    // Paso 1: Selección de dirección de envío
    public function direccionEnvio()
    {
        $usuario_id = session()->get('id_usuario');
        if (!$usuario_id) {
            return redirect()->to('login');
        }
        $direcciones = $this->direccionModel->getDireccionesByUsuario($usuario_id);
        
        // Obtener datos del carrito para el resumen
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        
        // Calcular total
        $total = 0;
        foreach ($items as &$item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if (!$producto) {
                return redirect()->to('carrito')->with('error', 'Uno de los productos ya no existe');
            }
            
            // Verificar que el producto esté activo
            if ($producto['activo'] != 1) {
                return redirect()->to('carrito')->with('error', 'El producto "' . $producto['nombre'] . '" ya no está disponible');
            }
            
            $item['producto'] = $producto;
            $item['subtotal'] = $producto['precio'] * $item['cantidad'];
            $total += $item['subtotal'];
        }
        
        $data = [
            'titulo' => 'Dirección de Envío',
            'direcciones' => $direcciones,
            'items' => $items,
            'total' => $total
        ];
        return view('header', $data)
            . view('navbar')
            . view('checkout/direccion_envio', $data)
            . view('footer');
    }

    // Guardar dirección seleccionada o nueva
    public function guardarDireccionEnvio()
    {
        $usuario_id = session()->get('id_usuario');
        if (!$usuario_id) {
            return redirect()->to('login');
        }
        $direccion_id = $this->request->getPost('direccion_id');
        if ($direccion_id) {
            $direccion = $this->direccionModel->find($direccion_id);
            if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
                return redirect()->back()->with('error', 'Dirección no válida.');
            }
            session()->set('checkout_data', [
                'direccion_id' => $direccion_id
            ]);
            return redirect()->to('checkout/resumen');
        } else {
            // Guardar nueva dirección
            $validation = \Config\Services::validation();
            $request = \Config\Services::request();

            $validation->setRules([
                'alias' => 'required|max_length[50]',
                'direccion' => 'required|max_length[255]',
                'codigo_postal' => 'required|max_length[10]',
                'ciudad' => 'required|max_length[100]',
                'provincia' => 'required|max_length[100]',
                'pais' => 'required|max_length[100]'
            ], [
                'alias' => [
                    'required' => 'El alias es obligatorio',
                    'max_length' => 'El alias no debe exceder los 50 caracteres'
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
                ],
                'pais' => [
                    'required' => 'El país es obligatorio',
                    'max_length' => 'El país no debe exceder los 100 caracteres'
                ]
            ]);

            if (!$validation->withRequest($request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $nueva = [
                'usuario_id' => $usuario_id,
                'tipo' => 'envio',
                'alias' => $request->getPost('alias'),
                'direccion' => $request->getPost('direccion'),
                'codigo_postal' => $request->getPost('codigo_postal'),
                'ciudad' => $request->getPost('ciudad'),
                'provincia' => $request->getPost('provincia'),
                'pais' => $request->getPost('pais'),
                'es_principal' => 0
            ];
            $id_nueva = $this->direccionModel->insert($nueva, true);
            session()->set('checkout_data', [
                'direccion_id' => $id_nueva
            ]);
            return redirect()->to('checkout/resumen');
        }
    }

    // Paso 2: Resumen del pedido
    public function resumenPedido()
    {
        $usuario_id = session()->get('id_usuario');
        $checkout_data = session()->get('checkout_data');
        if (!$usuario_id || !$checkout_data || !$checkout_data['direccion_id']) {
            return redirect()->to('checkout/direccion');
        }
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'No tienes productos en el carrito.');
        }
        $direccion = $this->direccionModel->find($checkout_data['direccion_id']);
        // Calcular total
        $total = 0;
        foreach ($items as &$item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if (!$producto) {
                return redirect()->to('carrito')->with('error', 'Uno de los productos ya no existe');
            }
            
            // Verificar que el producto esté activo
            if ($producto['activo'] != 1) {
                return redirect()->to('carrito')->with('error', 'El producto "' . $producto['nombre'] . '" ya no está disponible');
            }
            
            $item['producto'] = $producto;
            $item['subtotal'] = $producto['precio'] * $item['cantidad'];
            $total += $item['subtotal'];
        }
        $data = [
            'titulo' => 'Resumen del Pedido',
            'items' => $items,
            'total' => $total,
            'direccion' => $direccion
        ];
        return view('header', $data)
            . view('navbar')
            . view('checkout/resumen_pedido', $data)
            . view('footer');
    }

    // Confirmar resumen y pasar a pago
    public function confirmarResumen()
    {
        $usuario_id = session()->get('id_usuario');
        $checkout_data = session()->get('checkout_data');
        if (!$usuario_id || !$checkout_data || !$checkout_data['direccion_id']) {
            return redirect()->to('checkout/direccion');
        }
        // Aquí podrías guardar instrucciones de entrega, teléfono, etc. si lo pides en el resumen
        // Por simplicidad, solo avanzamos
        return redirect()->to('checkout/pago');
    }

    // Paso 3: Selección de método de pago
    public function pago()
    {
        $usuario_id = session()->get('id_usuario');
        $checkout_data = session()->get('checkout_data');
        if (!$usuario_id || !$checkout_data || !$checkout_data['direccion_id']) {
            return redirect()->to('checkout/direccion');
        }
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        $total = 0;
        foreach ($items as &$item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $item['producto'] = $producto;
            $item['subtotal'] = $producto['precio'] * $item['cantidad'];
            $total += $item['subtotal'];
        }
        
        // Obtener información de la dirección de envío
        $direccion = $this->direccionModel->find($checkout_data['direccion_id']);
        
        $data = [
            'titulo' => 'Pago',
            'items' => $items,
            'total' => $total,
            'direccion' => $direccion
        ];
        return view('header', $data)
            . view('navbar')
            . view('checkout/pago', $data)
            . view('footer');
    }

    // Procesar pago y crear venta
    public function procesarPago()
    {
        $usuario_id = session()->get('id_usuario');
        $checkout_data = session()->get('checkout_data');
        if (!$usuario_id || !$checkout_data || !$checkout_data['direccion_id']) {
            return redirect()->to('checkout/direccion');
        }
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'No tienes productos en el carrito.');
        }
        $direccion = $this->direccionModel->find($checkout_data['direccion_id']);
        // Calcular total
        $total = 0;
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if (!$producto) {
                return redirect()->to('carrito')->with('error', 'Uno de los productos ya no existe');
            }
            
            // Verificar que el producto esté activo
            if ($producto['activo'] != 1) {
                return redirect()->to('carrito')->with('error', 'El producto "' . $producto['nombre'] . '" ya no está disponible');
            }
            
            if ($producto['stock'] < $item['cantidad']) {
                return redirect()->to('carrito')->with('error', 'Stock insuficiente para ' . ($producto['nombre'] ?? 'un producto'));
            }
            $total += $producto['precio'] * $item['cantidad'];
        }
        // Validar método de pago
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'metodo_pago' => 'required|in_list[Tarjeta,Transferencia,Contrapago,Bitcoin]'
        ], [
            'metodo_pago' => [
                'required' => 'Debe seleccionar un método de pago',
                'in_list' => 'Método de pago inválido'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $metodo_pago = $request->getPost('metodo_pago');

        // Validaciones adicionales por método
        if ($metodo_pago === 'Tarjeta') {
            $validation->setRules([
                'numero_tarjeta' => 'required|min_length[15]|max_length[16]|numeric',
                'nombre_tarjeta' => 'required|max_length[100]',
                'fecha_expiracion' => 'required',
                'cvv' => 'required|numeric|min_length[3]|max_length[4]'
            ], [
                'numero_tarjeta' => [
                    'required' => 'El número de tarjeta es obligatorio',
                    'min_length' => 'El número de tarjeta debe tener al menos 15 dígitos',
                    'max_length' => 'El número de tarjeta no puede exceder los 16 dígitos',
                    'numeric' => 'El número de tarjeta debe contener solo números'
                ],
                'nombre_tarjeta' => [
                    'required' => 'El nombre en la tarjeta es obligatorio',
                    'max_length' => 'El nombre no puede exceder los 100 caracteres'
                ],
                'fecha_expiracion' => [
                    'required' => 'La fecha de expiración es obligatoria'
                ],
                'cvv' => [
                    'required' => 'El código CVV es obligatorio',
                    'numeric' => 'El CVV debe contener solo números',
                    'min_length' => 'El CVV debe tener al menos 3 dígitos',
                    'max_length' => 'El CVV no puede exceder los 4 dígitos'
                ]
            ]);

            if (!$validation->withRequest($request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
        } elseif ($metodo_pago === 'Transferencia') {
            $validation->setRules([
                'referencia_pago' => 'required|min_length[5]|max_length[50]'
            ], [
                'referencia_pago' => [
                    'required' => 'La referencia de pago es obligatoria',
                    'min_length' => 'La referencia debe tener al menos 5 caracteres',
                    'max_length' => 'La referencia no puede exceder los 50 caracteres'
                ]
            ]);

            if (!$validation->withRequest($request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
        }
        // --- INICIO TRANSACCIÓN ---
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            // 1. Crear venta
            $venta_id = $this->ventaModel->insert([
                'usuario_id' => $usuario_id,
                'fecha_venta' => date('Y-m-d H:i:s'),
                'estado' => 'pendiente',
                'total' => $total,
                'id_direccion_envio' => 0 // temporal, se actualiza luego
            ], true);
            // 2. Crear dirección_envio
            // Obtener datos personales del usuario
            $persona = $this->personaModel->getPersonaByUsuario($usuario_id);

            // Crear dirección_envio con todos los datos necesarios
            $id_direccion_envio = $this->direccionEnvioModel->insert([
                'venta_id' => $venta_id,
                'direccion' => $direccion['direccion'],
                'ciudad' => $direccion['ciudad'],
                'provincia' => $direccion['provincia'],
                'codigo_postal' => $direccion['codigo_postal'],
                'pais' => $direccion['pais'],
                'nombre_destinatario' => $persona['nombre'] . ' ' . $persona['apellido'], // Nombre completo
                'telefono_contacto' => $persona['telefono'],
                'instrucciones_entrega' => '' // O cualquier instrucción que se haya capturado
            ], true);
            // 3. Actualizar venta con id_direccion_envio
            $this->ventaModel->update($venta_id, ['id_direccion_envio' => $id_direccion_envio]);
            // 4. Crear venta_items y actualizar stock
            foreach ($items as $item) {
                $producto = $this->productoModel->find($item['producto_id']);
                $this->ventaItemModel->insert([
                    'venta_id' => $venta_id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto['precio']
                ]);
                // Actualizar stock
                $nuevo_stock = $producto['stock'] - $item['cantidad'];
                $this->productoModel->update($item['producto_id'], ['stock' => $nuevo_stock]);
                // Actualizar ventas totales
                $this->productoModel->incrementarVentas($item['producto_id'], $item['cantidad']);
            }
            // 5. Registrar pago
            $pago_data = [
                'venta_id' => $venta_id,
                'monto' => $total,
                'metodo_pago' => $metodo_pago,
                'estado' => 'exitoso',
                'fecha_pago' => date('Y-m-d H:i:s'),
                'comprobante' => null,
                'referencia_pago' => null
            ];
            if ($metodo_pago === 'Tarjeta') {
                $pago_data['comprobante'] = substr($request->getPost('numero_tarjeta'), -4);
            } elseif ($metodo_pago === 'Transferencia') {
                $pago_data['referencia_pago'] = $request->getPost('referencia_pago');
            }
            $this->pagoModel->insert($pago_data);
            // 6. Actualizar estado venta
            $this->ventaModel->update($venta_id, ['estado' => 'pagado']);
            // 7. Registrar en historial
            $this->historicoVentaModel->insert([
                'venta_id' => $venta_id,
                'estado_anterior' => 'pendiente',
                'estado_nuevo' => 'pagado',
                'accion' => 'Compra realizada',
                'usuario_id' => $usuario_id,
                'fecha' => date('Y-m-d H:i:s')
            ]);
            // 8. Vaciar carrito
            $this->carritoItemModel->where('carrito_id', $carrito['id_carrito'])->delete();
            // si es compra directa, eliminar carrito
            if (session()->has('checkout_directo')) {
                    session()->remove('checkout_directo');
            }
            // 9. Confirmar transacción
            $db->transCommit();
            session()->remove('checkout_data');
            return redirect()->to('checkout/confirmacion/' . $venta_id);
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('checkout/pago')->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }

    // Paso 4: Confirmación de compra
    public function confirmacion($id_venta)
    {
        $usuario_id = session()->get('id_usuario');
        $venta = $this->ventaModel->find($id_venta);
        if (!$venta || $venta['usuario_id'] != $usuario_id) {
            return redirect()->to('/')->with('error', 'Pedido no encontrado.');
        }
        $items = $this->ventaItemModel->where('venta_id', $id_venta)->findAll();
        foreach ($items as &$item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $item['producto'] = $producto;
            $item['subtotal'] = $item['precio_unitario'] * $item['cantidad'];
        }
        $direccion = $this->direccionEnvioModel->where('venta_id', $id_venta)->first();
        $pago = $this->pagoModel->where('venta_id', $id_venta)->first();
        $data = [
            'titulo' => 'Confirmación de Compra',
            'venta' => $venta,
            'items' => $items,
            'direccion' => $direccion,
            'pago' => $pago
        ];
        return view('header', $data)
            . view('navbar')
            . view('checkout/confirmacion', $data)
            . view('footer');
    }

    public function redirigirAgregarDireccion()
    {
        session()->setFlashdata('from_checkout', true);
        return redirect()->to('perfil/direcciones/agregar');
    }
}