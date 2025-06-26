<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarruselModel;

class CarruselController extends BaseController
{
    protected $carruselModel;

    public function __construct()
    {
        $this->carruselModel = new CarruselModel();
        helper(['form', 'url']);
    }

    public function listar()
    {
        // Filtros
        $filtros = [
            'titulo' => $this->request->getGet('titulo'),
            'estado' => $this->request->getGet('estado'),
            'orden_min' => $this->request->getGet('orden_min'),
            'orden_max' => $this->request->getGet('orden_max')
        ];

        $data = [
            'slides' => $this->carruselModel->getSlidesConFiltros($filtros),
            'titulo' => 'Administrar Carrusel',
            'request' => $this->request
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/carrusel/listar', $data)
             . view('footer');
    }

    public function crear()
    {
        $data = [
            'titulo' => 'Agregar Slide al Carrusel',
            'orden' => $this->carruselModel->getMaxOrden() + 1
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/carrusel/agregar', $data)
             . view('footer');
    }

    public function guardar()
    {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'titulo' => 'required|max_length[100]',
            'descripcion' => 'max_length[500]',
            'enlace' => 'valid_url|max_length[255]',
            'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
            'orden' => 'required|numeric|greater_than[0]|is_unique[carrusel.orden]'
        ], [
            'titulo' => [
                'required' => 'El título es obligatorio',
                'max_length' => 'El título no puede exceder los 100 caracteres'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede exceder los 500 caracteres'
            ],
            'enlace' => [
                'valid_url' => 'El enlace debe ser una URL válida',
                'max_length' => 'El enlace no puede exceder los 255 caracteres'
            ],
            'imagen' => [
                'uploaded' => 'La imagen es obligatoria',
                'max_size' => 'La imagen no puede exceder los 2MB',
                'is_image' => 'El archivo debe ser una imagen válida',
                'mime_in' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP'
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

        $imagen = $this->request->getFile('imagen');
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $tempPath = $imagen->getTempName();
            if (!$this->validateImageDimensions($tempPath, 1200, 400, 2000, 600)) {
                return redirect()->back()->withInput()->with('errors', ['imagen' => 'La imagen debe tener entre 1200x400px y 2000x600px']);
            }
        }

        $nombreImagen = $imagen->getRandomName();
        $imagen->move(ROOTPATH . 'public/uploads/carrusel/', $nombreImagen);

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'enlace' => $this->request->getPost('enlace'),
            'imagen' => $nombreImagen,
            'orden' => $this->request->getPost('orden'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($this->carruselModel->save($data)) {
            return redirect()->to('admin/configuracion/carrusel/listar')->with('message', 'Slide agregado correctamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al guardar el slide');
    }


    public function editar($id)
    {
        $slide = $this->carruselModel->find($id);

        if (!$slide) {
            return redirect()->to('/admin/configuracion/carrusel/listar')->with('error', 'Slide no encontrado');
        }

        $data = [
            'titulo' => 'Editar Slide del Carrusel',
            'slide' => $slide
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/carrusel/editar', $data)
             . view('footer');
    }

    public function actualizar($id)
    {
        $slide = $this->carruselModel->find($id);

        if (!$slide) {
            return redirect()->to('/admin/configuracion/carrusel/listar')->with('error', 'Slide no encontrado');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'titulo' => 'required|max_length[100]',
            'descripcion' => 'max_length[500]',
            'enlace' => 'valid_url|max_length[255]',
            'orden' => "required|numeric|greater_than[0]|is_unique[carrusel.orden,id,{$id}]"
        ], [
            'titulo' => [
                'required' => 'El título es obligatorio',
                'max_length' => 'El título no puede exceder los 100 caracteres'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede exceder los 500 caracteres'
            ],
            'enlace' => [
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

        $imagen = $this->request->getFile('imagen');
        if ($imagen && $imagen->isValid()) {
            $validation->setRules([
                'imagen' => 'max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]'
            ], [
                'imagen' => [
                    'max_size' => 'La imagen no puede exceder los 2MB',
                    'is_image' => 'El archivo debe ser una imagen válida',
                    'mime_in' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP'
                ]
            ]);
        }

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'id' => $id,
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'enlace' => $this->request->getPost('enlace'),
            'orden' => $this->request->getPost('orden'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($imagen && $imagen->isValid()) {
            $tempPath = $imagen->getTempName();
            if (!$this->validateImageDimensions($tempPath, 1200, 400, 2000, 600)) {
                return redirect()->back()->withInput()->with('errors', ['imagen' => 'La imagen debe tener entre 1200x400px y 2000x600px']);
            }

            // Eliminar imagen anterior si existe
            if ($slide['imagen'] && file_exists(ROOTPATH . 'public/uploads/carrusel/' . $slide['imagen'])) {
                unlink(ROOTPATH . 'public/uploads/carrusel/' . $slide['imagen']);
            }

            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/carrusel/', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        if ($this->carruselModel->save($data)) {
            return redirect()->to('/admin/configuracion/carrusel/listar')->with('message', 'Slide actualizado correctamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al actualizar el slide');
    }

    public function eliminar($id)
    {
        $slide = $this->carruselModel->find($id);

        if (!$slide) {
            return redirect()->to('/admin/configuracion/carrusel/listar')->with('error', 'Slide no encontrado');
        }

        // Eliminar imagen si existe
        if ($slide['imagen'] && file_exists(ROOTPATH . 'public/uploads/carrusel/' . $slide['imagen'])) {
            unlink(ROOTPATH . 'public/uploads/carrusel/' . $slide['imagen']);
        }

        if ($this->carruselModel->delete($id)) {
            return redirect()->to('/admin/configuracion/carrusel/listar')->with('message', 'Slide eliminado correctamente');
        }

        return redirect()->to('/admin/configuracion/carrusel/listar')->with('error', 'Error al eliminar el slide');
    }

    protected function validateImageDimensions($imagePath, $minWidth, $minHeight, $maxWidth = null, $maxHeight = null)
    {
        $imageInfo = getimagesize($imagePath);
        if (!$imageInfo) {
            return false;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Validar dimensiones mínimas
        if ($width < $minWidth || $height < $minHeight) {
            return false;
        }

        // Validar dimensiones máximas si se especifican
        if ($maxWidth && $width > $maxWidth) {
            return false;
        }
        if ($maxHeight && $height > $maxHeight) {
            return false;
        }

        return true;
    }
}