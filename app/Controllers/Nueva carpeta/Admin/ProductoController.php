<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    
    public function index()
    {
        $data = [
            'productos' => $this->productoModel->findAll(),
            'pager' => $this->productoModel->pager
        ];
        
        return view('admin/productos/index', $data);
    }
    
    public function new()
    {
        $data = [
            'categorias' => $this->categoriaModel->findAll()
        ];
        
        return view('admin/productos/new', $data);
    }
    
    public function create()
    {
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[150]',
            'precio' => 'required|decimal',
            'stock' => 'required|integer',
            'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = $imagen->getRandomName();
        $imagen->move(WRITEPATH . 'uploads/productos', $nombreImagen);
        
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'stock' => $this->request->getPost('stock'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'imagen_url' => 'uploads/productos/' . $nombreImagen,
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];
        
        if ($this->productoModel->save($data)) {
            return redirect()->to('/admin/productos')->with('success', 'Producto creado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->productoModel->errors());
        }
    }
    
    public function edit($id)
    {
        $producto = $this->productoModel->find($id);
        
        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }
        
        $data = [
            'producto' => $producto,
            'categorias' => $this->categoriaModel->findAll()
        ];
        
        return view('admin/productos/edit', $data);
    }
    
    public function update($id)
    {
        $producto = $this->productoModel->find($id);
        
        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }
        
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[150]',
            'precio' => 'required|decimal',
            'stock' => 'required|integer'
        ];
        
        if ($this->request->getFile('imagen')->isValid()) {
            $rules['imagen'] = 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'id_producto' => $id,
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'stock' => $this->request->getPost('stock'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];
        
        if ($this->request->getFile('imagen')->isValid()) {
            $imagen = $this->request->getFile('imagen');
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(WRITEPATH . 'uploads/productos', $nombreImagen);
            $data['imagen_url'] = 'uploads/productos/' . $nombreImagen;
            
            // Eliminar imagen anterior si existe
            if ($producto->imagen_url && file_exists(WRITEPATH . $producto->imagen_url)) {
                unlink(WRITEPATH . $producto->imagen_url);
            }
        }
        
        if ($this->productoModel->save($data)) {
            return redirect()->to('/admin/productos')->with('success', 'Producto actualizado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->productoModel->errors());
        }
    }
    
    public function delete($id)
    {
        $producto = $this->productoModel->find($id);
        
        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }
        
        // Eliminar imagen si existe
        if ($producto->imagen_url && file_exists(WRITEPATH . $producto->imagen_url)) {
            unlink(WRITEPATH . $producto->imagen_url);
        }
        
        $this->productoModel->delete($id);
        return redirect()->to('/admin/productos')->with('success', 'Producto eliminado exitosamente');
    }
}