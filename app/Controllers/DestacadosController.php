<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DestacadosModel;
use App\Models\ProductoModel;

class DestacadosController extends BaseController
{
    protected $destacadosModel;
    protected $productosModel;

    public function __construct()
    {
        $this->destacadosModel = new DestacadosModel();
        $this->productosModel = new ProductoModel();
        helper(['form', 'url']);
    }

    public function listar()
    {
        $filtros = [
            'titulo' => $this->request->getGet('titulo'),
            'estado' => $this->request->getGet('estado'),
            'orden_min' => $this->request->getGet('orden_min'),
            'orden_max' => $this->request->getGet('orden_max')
        ];

        $data = [
            'destacados' => $this->destacadosModel->getDestacadosConFiltros($filtros),
            'titulo' => 'Administrar Productos Destacados',
            'request' => $this->request
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/destacados/listar', $data)
             . view('footer');
    }

    public function crear()
    {
        $data = [
            'titulo' => 'Agregar Producto Destacado',
            'orden' => $this->destacadosModel->getMaxOrden() + 1,
            'productos' => $this->productosModel->findAll()
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/destacados/agregar', $data)
             . view('footer');
    }

    public function guardar()
    {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        
        $validation->setRules([
            'producto_id' => 'required|numeric',
            'titulo' => 'required|max_length[150]',
            'subtitulo' => 'required|max_length[255]',
            'video_file' => 'uploaded[video_file]|max_size[video_file,10240]|ext_in[video_file,mp4,mov,avi]',
            'url_producto' => 'valid_url|max_length[255]',
            'orden' => 'required|numeric|greater_than[0]|is_unique[destacados.orden]'
        ], [
            'producto_id' => [
                'required' => 'El producto es obligatorio',
                'numeric' => 'El producto debe ser un ID válido'
            ],
            'titulo' => [
                'required' => 'El título es obligatorio',
                'max_length' => 'El título no puede exceder los 150 caracteres'
            ],
            'subtitulo' => [
                'required' => 'El subtítulo es obligatorio',
                'max_length' => 'El subtítulo no puede exceder los 255 caracteres'
            ],
            'video_file' => [
                'uploaded' => 'El video es obligatorio',
                'max_size' => 'El video es demasiado grande (máx 10MB)',
                'ext_in' => 'Formatos permitidos: mp4, mov, avi'
            ],
            'url_producto' => [
                'valid_url' => 'El enlace debe ser una URL válida',
                'max_length' => 'El enlace no puede exceder los 255 caracteres'
            ],
            'orden' => [
                'required' => 'El orden es obligatorio',
                'numeric' => 'El orden debe ser un número',
                'greater_than' => 'El orden debe ser mayor a 0',
                'is_unique' => 'Este número de orden ya está en uso'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $videoFile = $this->request->getFile('video_file');
        $newName = $videoFile->getRandomName();
        $videoFile->move(ROOTPATH . 'public/uploads/destacados', $newName);

        $data = [
            'producto_id' => $this->request->getPost('producto_id'),
            'titulo' => $this->request->getPost('titulo'),
            'subtitulo' => $this->request->getPost('subtitulo'),
            'video_url' => $newName,
            'url_producto' => $this->request->getPost('url_producto'),
            'orden' => $this->request->getPost('orden'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($this->destacadosModel->save($data)) {
            return redirect()->to('admin/configuracion/destacados/listar')->with('message', 'Producto destacado agregado correctamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al guardar el producto destacado');
    }

    public function editar($id)
    {
        $destacado = $this->destacadosModel->find($id);

        if (!$destacado) {
            return redirect()->to('/admin/configuracion/destacados/listar')->with('error', 'Producto destacado no encontrado');
        }

        $data = [
            'titulo' => 'Editar Producto Destacado',
            'destacado' => $destacado,
            'productos' => $this->productosModel->findAll()
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/destacados/editar', $data)
             . view('footer');
    }

    public function actualizar($id)
    {
        $destacado = $this->destacadosModel->find($id);

        if (!$destacado) {
            return redirect()->to('/admin/configuracion/destacados/listar')->with('error', 'Producto destacado no encontrado');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        
        $validation->setRules([
            'producto_id' => 'required|numeric',
            'titulo' => 'required|max_length[150]',
            'subtitulo' => 'required|max_length[255]',
            'video_file' => 'if_exist|max_size[video_file,10240]|ext_in[video_file,mp4,mov,avi]',
            'url_producto' => 'valid_url|max_length[255]',
            'orden' => "required|numeric|greater_than[0]|is_unique[destacados.orden,id_destacado,{$id}]"
        ], [
            'producto_id' => [
                'required' => 'El producto es obligatorio',
                'numeric' => 'El producto debe ser un ID válido'
            ],
            'titulo' => [
                'required' => 'El título es obligatorio',
                'max_length' => 'El título no puede exceder los 150 caracteres'
            ],
            'subtitulo' => [
                'required' => 'El subtítulo es obligatorio',
                'max_length' => 'El subtítulo no puede exceder los 255 caracteres'
            ],
            'video_file' => [
                'max_size' => 'El video es demasiado grande (máx 10MB)',
                'ext_in' => 'Formatos permitidos: mp4, mov, avi'
            ],
            'url_producto' => [
                'valid_url' => 'El enlace debe ser una URL válida',
                'max_length' => 'El enlace no puede exceder los 255 caracteres'
            ],
            'orden' => [
                'required' => 'El orden es obligatorio',
                'numeric' => 'El orden debe ser un número',
                'greater_than' => 'El orden debe ser mayor a 0',
                'is_unique' => 'Este número de orden ya está en uso'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'id_destacado' => $id,
            'producto_id' => $this->request->getPost('producto_id'),
            'titulo' => $this->request->getPost('titulo'),
            'subtitulo' => $this->request->getPost('subtitulo'),
            'url_producto' => $this->request->getPost('url_producto'),
            'orden' => $this->request->getPost('orden'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        // Manejar la subida del nuevo video si se proporciona
        $videoFile = $this->request->getFile('video_file');
        if ($videoFile && $videoFile->isValid()) {
            // Eliminar el video anterior si existe
            if ($destacado['video_url'] && file_exists(ROOTPATH . 'public/uploads/destacados/' . $destacado['video_url'])) {
                unlink(ROOTPATH . 'public/uploads/destados/' . $destacado['video_url']);
            }
            
            $newName = $videoFile->getRandomName();
            $videoFile->move(ROOTPATH . 'public/uploads/destacados', $newName);
            $data['video_url'] = $newName;
        }

        if ($this->destacadosModel->save($data)) {
            return redirect()->to('/admin/configuracion/destacados/listar')->with('message', 'Producto destacado actualizado correctamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al actualizar el producto destacado');
    }

    public function eliminar($id)
    {
        $destacado = $this->destacadosModel->find($id);

        if (!$destacado) {
            return redirect()->to('/admin/configuracion/destacados/listar')->with('error', 'Producto destacado no encontrado');
        }

        // Eliminar el archivo de video asociado
        if ($destacado['video_url'] && file_exists(ROOTPATH . 'public/uploads/destacados/' . $destacado['video_url'])) {
            unlink(ROOTPATH . 'public/uploads/destacados/' . $destacado['video_url']);
        }

        if ($this->destacadosModel->delete($id)) {
            return redirect()->to('/admin/configuracion/destacados/listar')->with('message', 'Producto destacado eliminado correctamente');
        }

        return redirect()->to('/admin/configuracion/destacados/listar')->with('error', 'Error al eliminar el producto destacado');
    }
}