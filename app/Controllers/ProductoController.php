<?php
namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ResenaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    protected $resenaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->resenaModel = new ResenaModel();
    }

    public function productos()
    {
        $productos = $this->productoModel->findAll();
        
        $data = [
            'titulo' => 'Productos',
            'productos' => $productos,
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('header', $data) . view('navbar') . view('productos') . view('footer');
    }

public function detalle($producto_id)
{
    $producto = $this->productoModel->find($producto_id);
    
    if (!$producto) {
        return redirect()->to('productos')->with('error', 'Producto no encontrado');
    }

    $categoria = $this->categoriaModel->find($producto['categoria_id']);
    $resenas = $this->resenaModel->getResenasProducto($producto_id);
    $promedio = $this->resenaModel->getPromedioCalificacion($producto_id);

    // Procesar especificaciones si existen
    $especificaciones = [];
    if (!empty($producto['especificaciones'])) {
        $especificaciones = json_decode($producto['especificaciones'], true);
    }

    $data = [
        'titulo' => $producto['nombre'],
        'producto' => $producto,
        'categoria' => $categoria,
        'resenas' => $resenas,
        'promedio' => $promedio['calificacion'] ?? 0,
        'totalResenas' => count($resenas),
        'especificaciones' => $especificaciones,
        'yaReseno' => $this->resenaModel->usuarioYaReseno($producto_id, session()->get('id_usuario'))
    ];

    return view('header', $data) . view('navbar') . view('producto') . view('footer');
}


    public function productosPorCategoria($categoria_id)
    {
        $productos = $this->productoModel->getProductosByCategoria($categoria_id);
        $categoria = $this->categoriaModel->find($categoria_id);
        
        $data = [
            'titulo' => 'Productos en categoría: ' . ($categoria ? $categoria['nombre'] : 'Desconocida'),
            'productos' => $productos,
            'categoria' => $categoria,
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('header', $data) . view('navbar') . view('productos_categoria') . view('footer');
    }

    public function listar()
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $productos = $this->productoModel->findAll();
        $categorias = $this->categoriaModel->findAll();
        
        $data = [
            'titulo' => 'Gestión de Productos',
            'productos' => $productos,
            'categorias' => $categorias
        ];

        return view('header', $data) . view('navbar') . view('admin/productos/listar') . view('footer');
    }

    public function listarPorCategoria($categoria_id)
    {
        $productos = $this->productoModel->getProductosByCategoria($categoria_id);
        $categoria = $this->categoriaModel->find($categoria_id);
        
        $data = [
            'titulo' => 'Productos en categoría: ' . ($categoria ? $categoria['nombre'] : 'Desconocida'),
            'productos' => $productos,
            'categoria' => $categoria,
        ];

        return view('header', $data) . view('navbar') . view('productos_categoria') . view('footer');
    }

    public function agregarProducto()
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        // Cargar categorías para el formulario
        $categorias = $this->categoriaModel->findAll();
    
        $data = [
            'titulo' => 'Agregar Nuevo Producto',
            'categorias' => $categorias,
            'validation' => session()->get('validation') ?? null
        ];

        return view('header', $data) . view('navbar') . view('admin/productos/agregar') . view('footer');
    }

    public function guardarProducto()
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[150]',
            'descripcion' => 'required|min_length[10]',
            'marca' => 'permit_empty|max_length[100]',
            'modelo' => 'permit_empty|max_length[100]',
            'precio' => 'required|decimal',
            'stock' => 'required|integer',
            'categoria_id' => 'required|integer',
            'garantia_meses' => 'required|integer',
            'peso_kg' => 'permit_empty|decimal',
            'dimensiones' => 'permit_empty|max_length[50]',
            'imagen' => [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,2048]',
            ]
        ], [
            'nombre' => [
                'required' => 'El nombre del producto es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 150 caracteres'
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria',
                'min_length' => 'La descripción debe tener al menos 10 caracteres'
            ],
            'precio' => [
                'required' => 'El precio es obligatorio',
                'decimal' => 'El precio debe ser un número válido'
            ],
            'stock' => [
                'required' => 'El stock es obligatorio',
                'integer' => 'El stock debe ser un número entero'
            ],
            'categoria_id' => [
                'required' => 'La categoría es obligatoria',
                'integer' => 'Seleccione una categoría válida'
            ],
            'garantia_meses' => [
                'required' => 'La garantía en meses es obligatoria',
                'integer' => 'La garantía debe ser un número entero'
            ],
            'imagen' => [
                'uploaded' => 'Debe subir una imagen del producto',
                'mime_in' => 'El archivo debe ser una imagen (JPG, JPEG, PNG)',
                'max_size' => 'La imagen no puede pesar más de 2MB'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Procesar las especificaciones
        $especificaciones = [];
        $keys = $request->getPost('especificaciones_key');
        $values = $request->getPost('especificaciones_value');
        
        if ($keys && $values) {
            foreach ($keys as $index => $key) {
                if (!empty($key)) {
                    $especificaciones[$key] = $values[$index] ?? '';
                }
            }
        }

        // Procesar la imagen
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = null;

        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/productos', $nombreImagen);
        }

        // Preparar datos del producto
        $data = [
            'nombre' => $request->getPost('nombre'),
            'descripcion' => $request->getPost('descripcion'),
            'marca' => $request->getPost('marca'),
            'modelo' => $request->getPost('modelo'),
            'precio' => $request->getPost('precio'),
            'stock' => $request->getPost('stock'),
            'categoria_id' => $request->getPost('categoria_id'),
            'especificaciones' => json_encode($especificaciones),
            'garantia_meses' => $request->getPost('garantia_meses'),
            'peso_kg' => $request->getPost('peso_kg'),
            'dimensiones' => $request->getPost('dimensiones'),
            'activo' => 1
        ];

        // Si se subió una imagen, agregar la URL
        if ($nombreImagen) {
            $data['imagen_url'] = 'uploads/productos/' . $nombreImagen;
        }

        // Insertar el producto
        if ($this->productoModel->insert($data)) {
            $productoId = $this->productoModel->getInsertID();
            
            // Registrar en el historial de precios
            $this->registrarCambioPrecio($productoId, 0, $data['precio']);
            
            return redirect()->to('admin/productos/listar')->with('message', 'Producto agregado correctamente');
        } else {
            // Si falla, eliminar la imagen subida
            if ($nombreImagen && file_exists(ROOTPATH . 'public/uploads/productos/' . $nombreImagen)) {
                unlink(ROOTPATH . 'public/uploads/productos/' . $nombreImagen);
            }
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al guardar el producto');
        }
    }

    public function editarProducto($producto_id = null)
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        // Si no se proporciona ID, redirigir a la lista
        if (!$producto_id) {
            return redirect()->to('admin/productos/listar');
        }

        $producto = $this->productoModel->find($producto_id);
        $categorias = $this->categoriaModel->findAll();
        
        if (!$producto) {
            return redirect()->to('admin/productos/listar')->with('error', 'Producto no encontrado');
        }

        $data = [
            'titulo' => 'Editar Producto: ' . $producto['nombre'],
            'producto' => $producto,
            'categorias' => $categorias,
            'validation' => session()->get('validation') ?? null
        ];

        return view('header', $data) . view('navbar') . view('admin/productos/editar') . view('footer');
    }

    public function actualizarProducto()
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $producto_id = $this->request->getPost('producto_id');
        $producto = $this->productoModel->find($producto_id);
        
        if (!$producto) {
            return redirect()->to('productos')->with('error', 'Producto no encontrado');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación (similar a guardarProducto pero sin requerir imagen)
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[150]',
            'descripcion' => 'required|min_length[10]',
            'marca' => 'permit_empty|max_length[100]',
            'modelo' => 'permit_empty|max_length[100]',
            'precio' => 'required|decimal',
            'stock' => 'required|integer',
            'categoria_id' => 'required|integer',
            'garantia_meses' => 'required|integer',
            'peso_kg' => 'permit_empty|decimal',
            'dimensiones' => 'permit_empty|max_length[50]',
            'especificaciones' => 'permit_empty',
            'imagen' => [
                'if_exist',
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,2048]',
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Procesar la imagen si se subió una nueva
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = null;
        $imagenAnterior = $producto['imagen_url'];

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/productos', $nombreImagen);
        }

        // Preparar datos del producto
        $data = [
            'nombre' => $request->getPost('nombre'),
            'descripcion' => $request->getPost('descripcion'),
            'marca' => $request->getPost('marca'),
            'modelo' => $request->getPost('modelo'),
            'precio' => $request->getPost('precio'),
            'stock' => $request->getPost('stock'),
            'categoria_id' => $request->getPost('categoria_id'),
            'especificaciones' => $request->getPost('especificaciones'),
            'garantia_meses' => $request->getPost('garantia_meses'),
            'peso_kg' => $request->getPost('peso_kg'),
            'dimensiones' => $request->getPost('dimensiones'),
            'activo' => $request->getPost('activo') ? 1 : 0
        ];

        // Si se subió una nueva imagen, actualizar la URL
        if ($nombreImagen) {
            $data['imagen_url'] = 'uploads/productos/' . $nombreImagen;
            
            // Eliminar la imagen anterior si existe
            if ($imagenAnterior && file_exists(ROOTPATH . 'public/' . $imagenAnterior)) {
                unlink(ROOTPATH . 'public/' . $imagenAnterior);
            }
        }

        // Verificar si el precio cambió para registrar en el histórico
        if ($producto['precio'] != $data['precio']) {
            $this->registrarCambioPrecio($producto_id, $producto['precio'], $data['precio']);
        }

        // Actualizar el producto
        if ($this->productoModel->update($producto_id, $data)) {
            return redirect()->to('admin/productos/listar')->with('message', 'Producto actualizado correctamente');
        } else {
            // Si falla, eliminar la nueva imagen subida (si hubo)
            if ($nombreImagen && file_exists(ROOTPATH . 'public/uploads/productos/' . $nombreImagen)) {
                unlink(ROOTPATH . 'public/uploads/productos/' . $nombreImagen);
            }
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar el producto');
        }
    }

    private function registrarCambioPrecio($productoId, $precioAnterior, $precioNuevo)
    {
        $historicoModel = new \App\Models\HistoricoPreciosModel();
        
        $data = [
            'producto_id' => $productoId,
            'precio_anterior' => $precioAnterior,
            'precio_nuevo' => $precioNuevo
        ];
        
        $historicoModel->insert($data);
    }

    public function buscar()
    {
        $termino = $this->request->getGet('question');
        $productos = $this->productoModel->buscarProductos($termino);
        
        $data = [
            'titulo' => 'Resultados de búsqueda: ' . $termino,
            'productos' => $productos,
            'termino' => $termino
        ];

        return view('header', $data) . view('navbar') . view('busqueda') . view('footer');
    }

    public function agregarResena($producto_id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'calificacion' => 'required|integer|greater_than[0]|less_than[6]',
            'comentario' => 'permit_empty|max_length[500]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $usuario_id = session()->get('id_usuario');
        
        if ($this->resenaModel->usuarioYaReseno($producto_id, $usuario_id)) {
            return redirect()->back()->with('error', 'Ya has reseñado este producto');
        }

        $data = [
            'producto_id' => $producto_id,
            'usuario_id' => $usuario_id,
            'calificacion' => $this->request->getPost('calificacion'),
            'comentario' => $this->request->getPost('comentario')
        ];

        $this->resenaModel->insert($data);

        return redirect()->back()->with('message', 'Reseña agregada correctamente');
    }
}