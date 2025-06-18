<?php
namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ResenaModel;
use App\Models\VentaItemModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    protected $resenaModel;
    protected $ventaItemModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->resenaModel = new ResenaModel();
        $this->ventaItemModel = new VentaItemModel();
    }

    public function productos()
    {
        $productos = $this->productoModel->findAll();
        
        $data = [
            'titulo' => 'Productos',
            'productos' => $productos,
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('header', $data) . view('navbar') . view('catalogo/productos') . view('footer');
    }

public function detalle($producto_id)
{
    $producto = $this->productoModel->find($producto_id);
    
    if (!$producto) {
        return redirect()->to('productos')->with('error', 'Producto no encontrado');
    }

    $categoria = $this->categoriaModel->find($producto['categoria_id']);
    $resenas = $this->resenaModel->getResenasByProducto($producto_id);
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

    return view('header', $data) . view('navbar') . view('catalogo/producto') . view('footer');
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

        return view('header', $data) . view('navbar') . view('catalogo/productos_categoria') . view('footer');
    }

    public function listar()
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        // Obtener parámetros de búsqueda y filtros
        $termino = $this->request->getGet('q');
        $categoria_id = $this->request->getGet('categoria');
        $estado = $this->request->getGet('estado');

        // Construir consulta
        $builder = $this->productoModel->builder();

        if (!empty($termino)) {
            $builder->groupStart()
                    ->like('nombre', $termino)
                    ->orLike('descripcion', $termino)
                    ->orLike('marca', $termino)
                    ->orLike('modelo', $termino)
                    ->groupEnd();
        }

        if (!empty($categoria_id)) {
            $builder->where('categoria_id', $categoria_id);
        }

        if ($estado !== null && $estado !== '') {
            $builder->where('activo', $estado);
        }

        $productos = $builder->get()->getResultArray();
        $categorias = $this->categoriaModel->findAll();
        
        $data = [
            'titulo' => 'Gestión de Productos',
            'productos' => $productos,
            'categorias' => $categorias,
            'termino' => $termino,
            'categoria_seleccionada' => $categoria_id,
            'estado_seleccionado' => $estado
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
                'if_exist', // Permitir que no se suba imagen
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
        // Asegurarse de que las especificaciones no estén vacías
        if ($keys && $values) {
            foreach ($keys as $index => $key) {
                if (!empty($key) && !empty($values[$index])) {
                    $especificaciones[$key] = $values[$index];
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
            $data['imagen_url'] = $nombreImagen;
        }

        // Insertar el producto
        if ($this->productoModel->insert($data)) {
            $productoId = $this->productoModel->getInsertID();
            
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
    $eliminarImagen = $this->request->getPost('eliminar_imagen') == '1';

    // Si se marca eliminar imagen o se sube una nueva
    if ($eliminarImagen || ($imagen && $imagen->isValid() && !$imagen->hasMoved())) {
        // Eliminar la imagen anterior si existe
        if (!empty($producto['imagen_url']) && file_exists(ROOTPATH . 'public/uploads/productos/' . $producto['imagen_url'])) {
            unlink(ROOTPATH . 'public/uploads/productos/' . $producto['imagen_url']);
        }
        
        // Si se sube nueva imagen, moverla
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/productos', $nombreImagen);
        }
    }

    // Procesar las especificaciones
    $especificaciones = [];
    $keys = $request->getPost('especificaciones_key');
    $values = $request->getPost('especificaciones_value');
    
    if ($keys && $values) {
        foreach ($keys as $index => $key) {
            if (!empty($key) && !empty($values[$index])) {
                $especificaciones[$key] = $values[$index];
            }
        }
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
        'especificaciones' => !empty($especificaciones) ? json_encode($especificaciones) : null,
        'garantia_meses' => $request->getPost('garantia_meses'),
        'peso_kg' => $request->getPost('peso_kg'),
        'dimensiones' => $request->getPost('dimensiones'),
        'activo' => $request->getPost('activo') ? 1 : 0
    ];

    // Manejar la imagen
    if ($eliminarImagen) {
        $data['imagen_url'] = null;
    } elseif ($nombreImagen) {
        $data['imagen_url'] = $nombreImagen;
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

    public function buscar()
    {
        $termino = $this->request->getGet('q');

        if ($termino === null || trim($termino) === '') {
            return redirect()->to(base_url('productos'))->with('error', 'Por favor ingresá un término de búsqueda.');
        }

        $filtros = [
            'orden' => $this->request->getGet('orden'),
            'categoria_id' => $this->request->getGet('categoria'),
            'stock_disponible' => $this->request->getGet('stock'),
            'precio_min' => $this->request->getGet('precio_min'),
            'precio_max' => $this->request->getGet('precio_max')
        ];

        $productos = $this->productoModel->buscarProductos($termino, $filtros);

        $data = [
            'titulo' => 'Resultados de búsqueda: ' . $termino,
            'productos' => $productos,
            'termino' => $termino,
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('header', $data)
            . view('navbar')
            . view('busqueda')
            . view('footer');
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

    public function verificarVentas($producto_id)
    {
        $tieneVentas = $this->ventaItemModel->where('producto_id', $producto_id)->countAllResults() > 0;
        return $this->response->setJSON(['tieneVentas' => $tieneVentas]);
    }

// En ProductoController.php
public function desactivar($producto_id)
{
    // Verificar si el producto existe
    $producto = $this->productoModel->find($producto_id);
    
    if (!$producto) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Producto no encontrado'
        ]);
    }

    // Actualizar el estado del producto
    $updated = $this->productoModel->update($producto_id, ['activo' => 0]);

    if ($updated) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Producto desactivado correctamente'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al desactivar el producto'
        ]);
    }
}

public function eliminar($id)
{
    // Verificar si la petición es AJAX
    if ($this->request->isAJAX()) {
        // Primero verificar si tiene ventas
        $tieneVentas = $this->ventaItemModel->where('producto_id', $id)->countAllResults() > 0;

        if ($tieneVentas) {
            // Si tiene ventas, desactivar en lugar de eliminar
            $this->productoModel->update($id, ['activo' => 0]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'El producto tiene ventas asociadas. Se ha desactivado en lugar de eliminar.'
            ]);
        } else {
            // Si no tiene ventas, proceder con eliminación
            $producto = $this->productoModel->find($id);

            if (!$producto) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Producto no encontrado.'
                ]);
            }

            // Eliminar imagen si existe
            if (!empty($producto['imagen_url']) && file_exists(ROOTPATH . 'public/' . $producto['imagen_url'])) {
                unlink(ROOTPATH . 'public/' . $producto['imagen_url']);
            }

            $this->productoModel->delete($id);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Producto eliminado permanentemente.'
            ]);
        }
    }

    return $this->response->setStatusCode(400)->setJSON([
        'success' => false,
        'message' => 'Solicitud inválida.'
    ]);
}
}
