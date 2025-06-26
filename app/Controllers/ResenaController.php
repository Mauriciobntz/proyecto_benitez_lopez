<?php
namespace App\Controllers;

use App\Models\ResenaModel;
use App\Models\ProductoModel;
use App\Models\UsuarioModel;

class ResenaController extends BaseController
{
    protected $resenaModel;
    protected $productoModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->resenaModel = new ResenaModel();
        $this->productoModel = new ProductoModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function listar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $filtros = [
            'producto_id' => $this->request->getGet('producto_id'),
            'usuario_id' => $this->request->getGet('usuario_id'),
            'calificacion' => $this->request->getGet('calificacion'),
            'desde' => $this->request->getGet('desde'),
            'hasta' => $this->request->getGet('hasta')
        ];

        $resenas = $this->resenaModel->getResenasConFiltros($filtros);

        $data = [
            'titulo' => 'Gestión de Reseñas',
            'resenas' => $resenas,
            'productos' => $this->productoModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'request' => $this->request
        ];

        return view('header', $data) . view('navbar') . view('admin/resenas/listar') . view('footer');
    }

    public function editar($id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $resena = $this->resenaModel->find($id);
        if (!$resena) {
            return redirect()->to('admin/resenas/listar')->with('error', 'Reseña no encontrada');
        }

        $data = [
            'titulo' => 'Editar Reseña',
            'resena' => $resena,
            'productos' => $this->productoModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll()
        ];

        return view('header', $data) . view('navbar') . view('admin/resenas/editar') . view('footer');
    }

    public function actualizar($id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'producto_id' => 'required|integer',
            'usuario_id' => 'required|integer',
            'calificacion' => 'required|integer|greater_than[0]|less_than[6]',
            'comentario' => 'permit_empty|max_length[500]'
        ], [
            'producto_id' => [
                'required' => 'El producto es obligatorio',
                'integer' => 'El producto debe ser un número válido'
            ],
            'usuario_id' => [
                'required' => 'El usuario es obligatorio',
                'integer' => 'El usuario debe ser un número válido'
            ],
            'calificacion' => [
                'required' => 'La calificación es obligatoria',
                'integer' => 'La calificación debe ser un número entero',
                'greater_than' => 'La calificación debe ser mayor a 0',
                'less_than' => 'La calificación no puede ser mayor a 5'
            ],
            'comentario' => [
                'max_length' => 'El comentario no puede exceder los 500 caracteres'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'producto_id' => $request->getPost('producto_id'),
            'usuario_id' => $request->getPost('usuario_id'),
            'calificacion' => $request->getPost('calificacion'),
            'comentario' => $request->getPost('comentario')
        ];

        if ($this->resenaModel->update($id, $data)) {
            return redirect()->to('admin/resenas/listar')->with('message', 'Reseña actualizada correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la reseña');
        }
    }

    public function eliminar($id = null)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        if ($id === null || !is_numeric($id)) {
            return redirect()->to('admin/resenas/listar')->with('error', 'ID de reseña no válido');
        }

        if ($this->resenaModel->find($id)) {
            if ($this->resenaModel->delete($id)) {
                return redirect()->to('admin/resenas/listar')->with('message', 'Reseña eliminada correctamente');
            } else {
                return redirect()->to('admin/resenas/listar')->with('error', 'Error al eliminar la reseña');
            }
        } else {
            return redirect()->to('admin/resenas/listar')->with('error', 'Reseña no encontrada');
        }
    }
}