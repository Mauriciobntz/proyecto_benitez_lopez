<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;

class PedidoController extends BaseController
{
    protected $pedidoModel;
    protected $usuarioModel;
    
    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
    }
    
    public function index()
    {
        $data = [
            'pedidos' => $this->pedidoModel->orderBy('fecha_pedido', 'DESC')->findAll(),
            'pager' => $this->pedidoModel->pager
        ];
        
        return view('admin/pedidos/index', $data);
    }
    
    public function show($id)
    {
        $pedido = $this->pedidoModel->find($id);
        
        if (!$pedido) {
            return redirect()->to('/admin/pedidos')->with('error', 'Pedido no encontrado');
        }
        
        $usuario = $this->usuarioModel->find($pedido->usuario_id);
        $items = $this->pedidoModel->getItems($pedido->id_pedido);
        
        $data = [
            'pedido' => $pedido,
            'usuario' => $usuario,
            'items' => $items
        ];
        
        return view('admin/pedidos/show', $data);
    }
    
    public function updateStatus($id)
    {
        $pedido = $this->pedidoModel->find($id);
        
        if (!$pedido) {
            return redirect()->to('/admin/pedidos')->with('error', 'Pedido no encontrado');
        }
        
        $estado = $this->request->getPost('estado');
        
        if ($this->pedidoModel->update($id, ['estado' => $estado])) {
            return redirect()->to("/admin/pedidos/$id")->with('success', 'Estado del pedido actualizado');
        } else {
            return redirect()->to("/admin/pedidos/$id")->with('error', 'Error al actualizar el estado');
        }
    }
}