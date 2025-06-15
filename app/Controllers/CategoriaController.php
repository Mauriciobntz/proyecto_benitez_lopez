<?php
namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CategoriaController extends BaseController
{
    protected $categoriaModel;
    protected $productoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->productoModel = new ProductoModel();
    }

    public function listar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $categorias = $this->categoriaModel->getCategoriasConProductos();
        
        $data = [
            'titulo' => 'Gestión de Categorías',
            'categorias' => $categorias,
            'request' => $this->request
        ];

        return view('header', $data) . view('navbar') . view('admin/categorias/listar', $data) . view('footer');
    }

    public function crear()
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
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // TUS REGLAS PERSONALIZADAS
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]|is_unique[categorias.nombre]',
            'descripcion' => 'required|max_length[500]',
            'imagen' => [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
                'max_size[imagen,2048]',
            ]
        ], [
            'nombre' => [
                'required' => 'El nombre de la categoría es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 100 caracteres',
                'is_unique' => 'Ya existe una categoría con este nombre'
            ],
            'descripcion' => [
                'required' => 'La descripción de la categoría es obligatoria',
                'max_length' => 'La descripción no puede exceder los 500 caracteres'
            ],
            'imagen' => [
                'uploaded' => 'Debe subir una imagen para la categoría',
                'mime_in' => 'El archivo debe ser una imagen (JPG, JPEG, PNG o WEBP)',
                'max_size' => 'La imagen no puede pesar más de 2MB'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $imagen = $this->request->getFile('imagen');
        $nombreImagen = null;

        try {
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                $nombreImagen = $imagen->getRandomName();
                $imagen->move(ROOTPATH . 'public/uploads/categorias', $nombreImagen);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al subir la imagen: ' . $e->getMessage());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'imagen_url' => $nombreImagen
        ];

        if ($this->categoriaModel->insert($data)) {
            return redirect()->to('admin/categorias/listar')->with('message', 'Categoría agregada correctamente');
        } else {
            if ($nombreImagen && file_exists(ROOTPATH . 'public/uploads/categorias/' . $nombreImagen)) {
                unlink(ROOTPATH . 'public/uploads/categorias/' . $nombreImagen);
            }
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
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $categoria_id = $this->request->getPost('categoria_id');
        $categoria = $this->categoriaModel->find($categoria_id);
        
        if (!$categoria) {
            return redirect()->to('admin/categorias/listar')->with('error', 'Categoría no encontrada');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        // TUS REGLAS PERSONALIZADAS PARA ACTUALIZAR
        $validation->setRules([
            'nombre' => "required|min_length[3]|max_length[100]|is_unique[categorias.nombre,id_categoria,{$categoria_id}]",
            'descripcion' => 'required|max_length[500]',
            'imagen' => [
                'if_exist',
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
                'max_size[imagen,2048]',
            ]
        ], [
            'nombre' => [
                'required' => 'El nombre de la categoría es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 100 caracteres',
                'is_unique' => 'Ya existe una categoría con este nombre'
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria',
                'max_length' => 'La descripción no puede exceder los 500 caracteres'
            ],
            'imagen' => [
                'mime_in' => 'Solo se permiten imágenes JPG, JPEG, PNG o WEBP',
                'max_size' => 'La imagen no debe pesar más de 2MB'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $nombreImagen = $categoria['imagen_url'];
        $imagen = $this->request->getFile('imagen');
        $eliminarImagen = $this->request->getPost('eliminar_imagen') == '1';

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            try {
                $nombreImagen = $imagen->getRandomName();
                $imagen->move(ROOTPATH . 'public/uploads/categorias', $nombreImagen);
                
                if (!empty($categoria['imagen_url'])) {
                    $rutaAnterior = ROOTPATH . 'public/uploads/categorias/' . $categoria['imagen_url'];
                    if (file_exists($rutaAnterior)) {
                        unlink($rutaAnterior);
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error al subir la imagen: ' . $e->getMessage());
            }
        } elseif ($eliminarImagen) {
            if (!empty($categoria['imagen_url'])) {
                $rutaImagen = ROOTPATH . 'public/uploads/categorias/' . $categoria['imagen_url'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
            return redirect()->back()->withInput()->with('error', 'Debe subir una nueva imagen si desea eliminar la actual');
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'imagen_url' => $nombreImagen
        ];

        if ($this->categoriaModel->update($categoria_id, $data)) {
            return redirect()->to('admin/categorias/listar')->with('message', 'Categoría actualizada correctamente');
        } else {
            if ($imagen && $nombreImagen != $categoria['imagen_url']) {
                @unlink(ROOTPATH . 'public/uploads/categorias/' . $nombreImagen);
            }
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar la categoría');
        }
    }

    public function eliminar($categoria_id = null)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        if (!$categoria_id) {
            return redirect()->to('admin/categorias/listar');
        }

        $productosAsociados = $this->productoModel->where('categoria_id', $categoria_id)->countAllResults();

        if ($productosAsociados > 0) {
            return redirect()->to('admin/categorias/listar')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados');
        }

        $categoria = $this->categoriaModel->find($categoria_id);
        
        if ($this->categoriaModel->delete($categoria_id)) {
            if ($categoria && !empty($categoria['imagen_url'])) {
                $rutaImagen = ROOTPATH . 'public/uploads/categorias/' . $categoria['imagen_url'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
            
            return redirect()->to('admin/categorias/listar')->with('message', 'Categoría eliminada correctamente');
        } else {
            return redirect()->to('admin/categorias/listar')->with('error', 'Ocurrió un error al eliminar la categoría');
        }
    }
}