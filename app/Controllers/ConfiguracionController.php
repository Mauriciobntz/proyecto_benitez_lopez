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
        
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'nombre_tienda' => 'required|min_length[3]|max_length[100]',
            'razon_social' => 'required|max_length[100]',
            'email_tienda' => 'required|valid_email|max_length[100]',
            'telefono_tienda' => 'required|max_length[20]',
            'whatsapp_tienda' => 'permit_empty|max_length[20]',
            'direccion_tienda' => 'required|max_length[255]',
            'cuit' => 'required|max_length[20]',
            'cbu' => 'required|numeric|max_length[22]',
            'alias_cbu' => 'required|max_length[50]',
            'banco' => 'required|max_length[100]',
            'titular_cuenta' => 'required|max_length[100]',
            'tipo_cuenta' => 'required|in_list[Caja de ahorro,Cuenta corriente]',
            'area_cobertura' => 'required|max_length[255]',
            'facebook_url' => 'required|valid_url|max_length[255]',
            'instagram_url' => 'required|valid_url|max_length[255]',
            'twitter_url' => 'required|valid_url|max_length[255]',
            'whatsapp_url' => 'required|valid_url|max_length[255]',
            'horario_atencion' => 'required|max_length[255]',
            'mensaje_bienvenida' => 'required',
            'logo' => 'if_exist|uploaded[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]|max_size[logo,2048]'
        ], [
            'nombre_tienda' => [
                'required' => 'El nombre de la tienda es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 100 caracteres'
            ],
            'razon_social' => [
                'required' => 'La razón social es obligatoria',
                'max_length' => 'La razón social no puede exceder los 100 caracteres'
            ],
            'email_tienda' => [
                'required' => 'El email es obligatorio',
                'valid_email' => 'Debe ingresar un email válido',
                'max_length' => 'El email no puede exceder los 100 caracteres'
            ],
            'telefono_tienda' => [
                'required' => 'El teléfono es obligatorio',
                'max_length' => 'El teléfono no puede exceder los 20 caracteres'
            ],
            'whatsapp_tienda' => [
                'max_length' => 'El WhatsApp no puede exceder los 20 caracteres'
            ],
            'direccion_tienda' => [
                'required' => 'La dirección es obligatoria',
                'max_length' => 'La dirección no puede exceder los 255 caracteres'
            ],
            'cuit' => [
                'required' => 'El CUIT es obligatorio',
                'max_length' => 'El CUIT no puede exceder los 20 caracteres'
            ],
            'cbu' => [
                'required' => 'El CBU es obligatorio',
                'numeric' => 'El CBU debe contener solo números',
                'max_length' => 'El CBU no puede exceder los 22 caracteres'
            ],
            'alias_cbu' => [
                'required' => 'El alias CBU es obligatorio',
                'max_length' => 'El alias CBU no puede exceder los 50 caracteres'
            ],
            'banco' => [
                'required' => 'El banco es obligatorio',
                'max_length' => 'El banco no puede exceder los 100 caracteres'
            ],
            'titular_cuenta' => [
                'required' => 'El titular de la cuenta es obligatorio',
                'max_length' => 'El titular no puede exceder los 100 caracteres'
            ],
            'tipo_cuenta' => [
                'required' => 'El tipo de cuenta es obligatorio',
                'in_list' => 'El tipo de cuenta no es válido'
            ],
            'area_cobertura' => [
                'required' => 'El area de cobertura es obligatoria',
                'max_length' => 'El área de cobertura no puede exceder los 255 caracteres'
            ],
            'facebook_url' => [
                'required' => 'La URL de Facebook es obligatoria',
                'valid_url' => 'La URL de Facebook no es válida',
                'max_length' => 'La URL no puede exceder los 255 caracteres'
            ],
            'instagram_url' => [
                'required' => 'La URL de Instagram es obligatoria',
                'valid_url' => 'La URL de Instagram no es válida',
                'max_length' => 'La URL no puede exceder los 255 caracteres'
            ],
            'twitter_url' => [
                'required' => 'La URL de Twitter es obligatoria',
                'valid_url' => 'La URL de Twitter no es válida',
                'max_length' => 'La URL no puede exceder los 255 caracteres'
            ],
            'whatsapp_url' => [
                'required' => 'La URL de WhatsApp es obligatoria',
                'valid_url' => 'La URL de WhatsApp no es válida',
                'max_length' => 'La URL no puede exceder los 255 caracteres'
            ],
            'horario_atencion' => [
                'required' => 'El horario de atención es obligatorio',
                'max_length' => 'El horario no puede exceder los 255 caracteres'
            ],
            'mensaje_bienvenida' => [
                'required' => 'El mensaje de bienvenida es obligatorio'
            ],
            'logo' => [
                'uploaded' => 'Debe seleccionar un archivo para subir',
                'mime_in' => 'El archivo debe ser una imagen JPG, JPEG o PNG',
                'max_size' => 'El tamaño máximo permitido es 2MB'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
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