<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CarritoModel;
use App\Models\ProductoModel;

class CarritoController extends BaseController
{
    protected $carritoModel;
    protected $productoModel;
    
    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->productoModel = new ProductoModel();
        helper('number');
    }
    
    public function index()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();
        
        if (!$carrito) {
            $carrito_id = $this->carritoModel->insert(['usuario_id' => $usuario_id]);
            $carrito = $this->carritoModel->find($carrito_id);
        }
        
        $items = $this->carritoModel->getItems($carrito->id_carrito);
        
        // Calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item->precio * $item->cantidad;
        }
        
        $data = [
            'items' => $items,
            'total' => $total,
            'total_formateado' => number_to_currency($total, 'EUR', 'es-ES')
        ];
        
        return view('customer/carrito/index', $data);
    }
    
    public function add()
    {
        $producto_id = $this->request->getPost('producto_id');
        $cantidad = $this->request->getPost('cantidad') ?? 1;
        
        $producto = $this->productoModel->find($producto_id);
        
        if (!$producto || $producto->stock < $cantidad) {
            return redirect()->back()->with('error', 'Producto no disponible en la cantidad solicitada');
        }
        
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();
        
        if (!$carrito) {
            $carrito_id = $this->carritoModel->insert(['usuario_id' => $usuario_id]);
            $carrito = $this->carritoModel->find($carrito_id);
        }
        
        // Verificar si el producto ya está en el carrito
        $item = $this->carritoModel->db->table('carrito_items')
            ->where('carrito_id', $carrito->id_carrito)
            ->where('producto_id', $producto_id)
            ->get()
            ->getRow();
        
        if ($item) {
            // Actualizar cantidad
            $this->carritoModel->db->table('carrito_items')
                ->where('id_item', $item->id_item)
                ->update(['cantidad' => $item->cantidad + $cantidad]);
        } else {
            // Añadir nuevo item
            $this->carritoModel->db->table('carrito_items')->insert([
                'carrito_id' => $carrito->id_carrito,
                'producto_id' => $producto_id,
                'cantidad' => $cantidad
            ]);
        }
        
        return redirect()->to('/carrito')->with('success', 'Producto añadido al carrito');
    }
    
    public function remove($item_id)
    {
        $this->carritoModel->db->table('carrito_items')->delete(['id_item' => $item_id]);
        return redirect()->to('/carrito')->with('success', 'Producto eliminado del carrito');
    }
}