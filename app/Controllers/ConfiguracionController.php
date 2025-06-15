<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class ConfiguracionController extends BaseController
{
    protected $configuracionModel;
    protected $helpers = ['form', 'filesystem'];

    public function __construct()
    {
        $this->configuracionModel = new ConfiguracionModel();
    }

    public function ver()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'Acceso restringido');
        }

        $config = $this->configuracionModel->getConfiguracion();
        
        $data = [
            'titulo' => 'Configuración de la Tienda',
            'config' => $config
        ];

        return view('header', $data) 
            . view('navbar') 
            . view('admin/configuracion/tienda/ver', $data) 
            . view('footer');
    }

    public function editar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'Acceso restringido');
        }

        $config = $this->configuracionModel->getConfiguracion();
        
        $data = [
            'titulo' => 'Configuración de la Tienda',
            'config' => $config,
            'validation' => \Config\Services::validation()
        ];

        return view('header', $data) 
             . view('navbar') 
             . view('admin/configuracion/tienda/editar', $data) 
             . view('footer');
    }

    public function actualizar()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'Acceso restringido');
        }

        // Reglas de validación con mensajes personalizados
        $rules = [
            'nombre_tienda' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'El nombre de la tienda es obligatorio',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres',
                    'max_length' => 'El nombre no puede exceder los 100 caracteres'
                ]
            ],
            'razon_social' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'La razón social es obligatoria',
                    'max_length' => 'La razón social no puede exceder los 100 caracteres'
                ]
            ],
            'email_tienda' => [
                'rules' => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required' => 'El email es obligatorio',
                    'valid_email' => 'Debe ingresar un email válido',
                    'max_length' => 'El email no puede exceder los 100 caracteres'
                ]
            ],
            'telefono_tienda' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'El teléfono es obligatorio',
                    'max_length' => 'El teléfono no puede exceder los 20 caracteres'
                ]
            ],
            'whatsapp_tienda' => [
                'rules' => 'permit_empty|max_length[20]',
                'errors' => [
                    'required' => 'El whatsapp es obligatorio',
                    'max_length' => 'El WhatsApp no puede exceder los 20 caracteres'
                ]
            ],
            'direccion_tienda' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'La dirección es obligatoria',
                    'max_length' => 'La dirección no puede exceder los 255 caracteres'
                ]
            ],
            'cuit' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'El CUIT es obligatorio',
                    'max_length' => 'El CUIT no puede exceder los 20 caracteres'
                ]
            ],
            'cbu' => [
                'rules' => 'required|numeric|max_length[12]',
                'errors' => [
                    'required' => 'El CBU es obligatorio',
                    'numeric' => 'El CBU debe contener solo números',
                    'max_length' => 'El CBU no puede exceder los 12 caracteres'
                ]
            ],
            'area_cobertura' => [
                'rules' => 'required|max_length[255]',
                    'required' => 'El area de cobertura es obligatoria',
                'errors' => [
                    'max_length' => 'El área de cobertura no puede exceder los 255 caracteres'
                ]
            ],
            'facebook_url' => [
                'rules' => 'required|valid_url|max_length[255]',
                'errors' => [
                    'required' => 'La URL de Facebook es obligatoria',
                    'valid_url' => 'La URL de Facebook no es válida',
                    'max_length' => 'La URL no puede exceder los 255 caracteres'
                ]
            ],
            'instagram_url' => [
                'rules' => 'required|valid_url|max_length[255]',
                'errors' => [
                    'required' => 'La URL de Instagram es obligatoria',
                    'valid_url' => 'La URL de Instagram no es válida',
                    'max_length' => 'La URL no puede exceder los 255 caracteres'
                ]
            ],
            'twitter_url' => [
                'rules' => 'required|valid_url|max_length[255]',
                'errors' => [
                    'required' => 'La URL de Twitter es obligatoria',
                    'valid_url' => 'La URL de Twitter no es válida',
                    'max_length' => 'La URL no puede exceder los 255 caracteres'
                ]
            ],
            'whatsapp_url' => [
                'rules' => 'required|valid_url|max_length[255]',
                'errors' => [
                    'required' => 'La URL de WhatsApp es obligatoria',
                    'valid_url' => 'La URL de WhatsApp no es válida',
                    'max_length' => 'La URL no puede exceder los 255 caracteres'
                ]
            ],
            'horario_atencion' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'El horario de atención es obligatorio',
                    'max_length' => 'El horario no puede exceder los 255 caracteres'
                ]
            ],
            'mensaje_bienvenida' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El mensaje de bienvenida es obligatorio'
                ]
            ],
            'logo' => [
                'rules' => 'if_exist|uploaded[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]|max_size[logo,2048]',
                'errors' => [
                    'uploaded' => 'Debe seleccionar un archivo para subir',
                    'mime_in' => 'El archivo debe ser una imagen JPG, JPEG o PNG',
                    'max_size' => 'El tamaño máximo permitido es 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        // Procesar eliminación de logo si se marcó la opción
        $eliminarLogo = $this->request->getPost('eliminar_logo');
        $configActual = $this->configuracionModel->getConfiguracion();
        
        if ($eliminarLogo == '1') {
            if (!empty($configActual['logo_url'])) {
                if (file_exists(ROOTPATH . 'public/uploads/config/' . $configActual['logo_url'])) {
                    unlink(ROOTPATH . 'public/uploads/config/' . $configActual['logo_url']);
                }
                $data['logo_url'] = null;
            }
        }

        // Procesar logo si se subió uno nuevo
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            // Eliminar logo anterior si existe
            if (!empty($configActual['logo_url'])) {
                if (file_exists(ROOTPATH . 'public/uploads/config/' . $configActual['logo_url'])) {
                    unlink(ROOTPATH . 'public/uploads/config/' . $configActual['logo_url']);
                }
            }

            // Mover nuevo logo
            $nombreLogo = $logo->getRandomName();
            $logo->move(ROOTPATH . 'public/uploads/config', $nombreLogo);
            $data['logo_url'] = $nombreLogo;
        }

        // Actualizar configuración
        if ($this->configuracionModel->actualizarConfiguracion($data)) {
            return redirect()->to('admin/configuracion/tienda/ver')
                ->with('message', 'Configuración actualizada correctamente');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar la configuración');
        }
    }
}