<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\ResenaModel;
use App\Models\ProductoModel;
use App\Models\PedidoModel;

class ResenaController extends BaseController
{
    protected $resenaModel;
    protected $productoModel;
    protected $pedidoModel;
    
    public function __construct()
    {
        $this->resenaModel = new ResenaModel();
        $this->productoModel = new ProductoModel();
        $this->pedidoModel = new PedidoModel();
    }
    
    public function create($producto_id)
    {
        $usuario_id = session()->get('id_usuario');
        $producto = $this->productoModel->find($producto_id);
        
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
        
        // Verificar si el usuario ha comprado el producto
        $haComprado = $this->pedidoModel->hasPurchasedProduct($usuario_id, $producto_id);
        
        if (!$haComprado) {
            return redirect()->back()->with('error', 'Debes comprar el producto antes de reseñarlo');
        }
        
        // Verificar si ya ha reseñado el producto
        $yaResenado = $this->resenaModel
            ->where('producto_id', $producto_id)
            ->where('usuario_id', $usuario_id)
            ->first();
            
        if ($yaResenado) {
            return redirect()->back()->with('error', 'Ya has reseñado este producto');
        }
        
        return view('customer/resenas/create', ['producto' => $producto]);
    }
    
    public function store($producto_id)
    {
        $usuario_id = session()->get('id_usuario');
        
        $rules = [
            'calificación' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'comentario' => 'permit_empty|max_length[500]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $this->resenaModel->insert([
            'producto_id' => $producto_id,
            'usuario_id' => $usuario_id,
            'calificación' => $this->request->getPost('calificación'),
            'comentario' => $this->request->getPost('comentario')
        ]);
        
        return redirect()->to("/productos/$producto_id")->with('success', 'Reseña publicada correctamente');
    }
    
    public function myReviews()
    {
        $usuario_id = session()->get('id_usuario');
        $resenas = $this->resenaModel->getByUsuario($usuario_id, 10);
        
        return view('customer/resenas/index', ['resenas' => $resenas]);
    }
    
    public function destroy($id)
    {
        $usuario_id = session()->get('id_usuario');
        $resena = $this->resenaModel->find($id);
        
        if (!$resena || $resena->usuario_id != $usuario_id) {
            return redirect()->back()->with('error', 'Reseña no encontrada');
        }
        
        $this->resenaModel->delete($id);
        return redirect()->back()->with('success', 'Reseña eliminada correctamente');
    }
}