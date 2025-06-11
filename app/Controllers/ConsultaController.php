<?php
namespace App\Controllers;

use App\Models\ConsultaModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class ConsultaController extends BaseController
{
    use ResponseTrait;

    protected $consultaModel;

    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
    }

    // Listar consultas (para admin)
    public function listarConsultas()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado');
        }

        $request = service('request');
        $filtros = [
            'search' => $request->getGet('search'),
            'estado' => $request->getGet('estado'),
            'asunto' => $request->getGet('asunto'),
            'desde' => $request->getGet('desde'),
            'hasta' => $request->getGet('hasta'),
        ];

        $consultas = $this->consultaModel->getConsultas($filtros);

        $data = [
            'titulo' => 'Gestión de Consultas',
            'consultas' => $consultas,
            'filtros' => $filtros,
            'request' => $request
        ];

        return view('header', $data) . view('navbar') . view('admin/consultas/listar', $data) . view('footer');
    }

    // Ver detalle de consulta
    public function detalleConsulta($id_consulta)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado');
        }

        $consulta = $this->consultaModel->find($id_consulta);

        if (!$consulta) {
            return redirect()->back()->with('error', 'Consulta no encontrada');
        }

        $data = [
            'titulo' => 'Consulta #' . $id_consulta,
            'consulta' => $consulta
        ];

        return view('header', $data) . view('navbar') . view('admin/consultas/detalle', $data) . view('footer');
    }

    // Actualizar estado de consulta (AJAX)
    public function actualizarEstado($id_consulta)
    {
        if (session()->get('rol') !== 'admin') {
            return $this->failForbidden('No tienes permisos para esta acción');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'estado' => 'required|in_list[Sin Leer,Leida,En proceso,Resuelta]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $estado = $this->request->getPost('estado');

        if ($this->consultaModel->actualizarEstado($id_consulta, $estado)) {
            return $this->respond([
                'success' => true, 
                'message' => 'Estado actualizado correctamente',
                'estado' => $estado,
                'badge_class' => $this->getBadgeClass($estado)
            ]);
        }

        return $this->fail('Error al actualizar el estado');
    }

    protected function getBadgeClass($estado)
    {
        $badgeClasses = [
            'Sin Leer' => 'bg-secondary',
            'Leida' => 'bg-primary',
            'En proceso' => 'bg-warning',
            'Resuelta' => 'bg-success'
        ];
        
        return $badgeClasses[$estado] ?? 'bg-secondary';
    }

    // Formulario de contacto público
    public function formularioContacto()
    {
        $data = [
            'titulo' => 'Contacto',
            'validation' => session()->get('validation')
        ];

        return view('header', $data) . view('navbar') . view('contacto', $data) . view('footer');
    }

    // Procesar formulario de contacto
    public function procesarConsulta()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]',
            'correo' => 'required|valid_email',
            'telefono' => 'permit_empty|min_length[8]',
            'asunto' => 'required|in_list[Solicitud de Cotizacion,Soporte Tecnico,Consulta Facturacion,Reclamo,Sugerencia,Otros]',
            'mensaje' => 'required|min_length[10]',
            'preferencia_contacto' => 'required|in_list[correo,llamada,whatsapp]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'razon_social' => $this->request->getPost('razon_social') ?? null,
            'correo' => $this->request->getPost('correo'),
            'telefono' => $this->request->getPost('telefono'),
            'asunto' => $this->request->getPost('asunto'),
            'mensaje' => $this->request->getPost('mensaje'),
            'preferencia_contacto' => $this->request->getPost('preferencia_contacto'),
            'estado' => 'Sin Leer'
        ];

        try {
            if ($this->consultaModel->insert($data)) {
                return redirect()->to('contacto')->with('message', 'Tu consulta ha sido enviada. Nos pondremos en contacto contigo pronto.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al insertar consulta: ' . $e->getMessage());
        }

        return redirect()->back()->withInput()->with('error', 'Ocurrió un error al enviar tu consulta. Por favor intenta nuevamente.');
    }
}