<?php
namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProductoModel;

class CategoriaController extends BaseController
{
    protected $categoriaModel;
    protected $productoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->productoModel = new ProductoModel();
    }

    // Métodos públicos (frontend)
    public function listarCategorias()
    {
        $categorias = $this->categoriaModel->getCategoriasConProductos();
        
        $data = [
            'titulo' => 'Categorías',
            'categorias' => $categorias
        ];

        return view('header', $data) . view('navbar') . view('admin/categorias/listar') . view('footer');
    }

    public function productosPorCategoria($categoria_id)
    {
        $categoria = $this->categoriaModel->find($categoria_id);
        $productos = $this->productoModel->getProductosByCategoria($categoria_id);
        
        $data = [
            'titulo' => $categoria['nombre'],
            'productos' => $productos,
            'categoria' => $categoria
        ];

        return view('header', $data) . view('navbar') . view('productos_categoria') . view('footer');
    }

    // Métodos de administración
    public function listar()
    {
        // Verificar si el usuario es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $categorias = $this->categoriaModel->getCategoriasConProductos();
        
        $data = [
            'titulo' => 'Gestión de Categorías',
            'categorias' => $categorias
        ];

        return view('header', $data) . view('navbar') . view('admin/categorias/listar') . view('footer');
    }

    public function agregar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $data = [
            'titulo' => 'Agregar Nueva Categoría',
            'validation' => session()->get('validation') ?? null
        ];

        return view('header', $data) . view('navbar') . view('admin/categorias/agregar') . view('footer');
    }

    public function guardar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]|is_unique[categorias.nombre]',
            'descripcion' => 'permit_empty|max_length[500]'
        ], [
            'nombre' => [
                'required' => 'El nombre de la categoría es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 100 caracteres',
                'is_unique' => 'Ya existe una categoría con este nombre'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'nombre' => $request->getPost('nombre'),
            'descripcion' => $request->getPost('descripcion')
        ];

        if ($this->categoriaModel->insert($data)) {
            return redirect()->to('admin/categorias/listar')->with('message', 'Categoría agregada correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al guardar la categoría');
        }
    }

    public function editar($categoria_id = null)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        if (!$categoria_id) {
            return redirect()->to('admin/categorias/listar');
        }

        $categoria = $this->categoriaModel->find($categoria_id);
        
        if (!$categoria) {
            return redirect()->to('admin/categorias/listar')->with('error', 'Categoría no encontrada');
        }

        $data = [
            'titulo' => 'Editar Categoría: ' . $categoria['nombre'],
            'categoria' => $categoria,
            'validation' => session()->get('validation') ?? null
        ];

        return view('header', $data) . view('navbar') . view('admin/categorias/editar') . view('footer');
    }

    public function actualizar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $categoria_id = $this->request->getPost('categoria_id');
        $categoria = $this->categoriaModel->find($categoria_id);
        
        if (!$categoria) {
            return redirect()->to('admin/categorias/listar')->with('error', 'Categoría no encontrada');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // Reglas de validación (similar a guardar pero sin requerir imagen)
        $validation->setRules([
            'nombre' => "required|min_length[3]|max_length[100]|is_unique[categorias.nombre,id_categoria,{$categoria_id}]",
            'descripcion' => 'permit_empty|max_length[500]'
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'nombre' => $request->getPost('nombre'),
            'descripcion' => $request->getPost('descripcion')
        ];

        if ($this->categoriaModel->update($categoria_id, $data)) {
            return redirect()->to('admin/categorias/listar')->with('message', 'Categoría actualizada correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar la categoría');
        }
    }

    public function eliminar($categoria_id = null)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        if (!$categoria_id) {
            return redirect()->to('admin/categorias/listar');
        }

        // Verificar si hay productos asociados
        $productosAsociados = $this->productoModel->where('categoria_id', $categoria_id)->countAllResults();

        if ($productosAsociados > 0) {
            return redirect()->to('admin/categorias/listar')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados');
        }

        if ($this->categoriaModel->delete($categoria_id)) {
            return redirect()->to('admin/categorias/listar')->with('message', 'Categoría eliminada correctamente');
        } else {
            return redirect()->to('admin/categorias/listar')->with('error', 'Ocurrió un error al eliminar la categoría');
        }
    }
}