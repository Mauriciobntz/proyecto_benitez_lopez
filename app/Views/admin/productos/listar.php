<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Productos</h2>
        <a href="<?= base_url('admin/productos/crear') ?>" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nuevo Producto
        </a>
    </div>
    
    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session()->get('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->get('error') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar productos...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Todas las categorías</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?= $producto['id_producto'] ?></td>
                                <td>
                                    <?php if (!empty($producto['imagen_url'])): ?>
                                        <img src="<?= base_url('public/uploads/productos/' . $producto['imagen_url']) ?>" class="img-thumbnail" style="width: 50px; height: 50px;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50" class="img-thumbnail" style="width: 50px; height: 50px;">
                                    <?php endif; ?>
                                </td>
                                <td><?= $producto['nombre'] ?></td>
                                <td>
                                    <?php 
                                    $categoriaNombre = 'Desconocida';
                                    foreach ($categorias as $cat) {
                                        if ($cat['id_categoria'] == $producto['categoria_id']) {
                                            $categoriaNombre = $cat['nombre'];
                                            break;
                                        }
                                    }
                                    echo $categoriaNombre;
                                    ?>
                                </td>
                                <td>€<?= number_format($producto['precio'], 2) ?></td>
                                <td><?= $producto['stock'] ?></td>
                                <td>
                                    <span class="badge <?= $producto['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $producto['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/productos/editar/' . $producto['id_producto']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="confirmarEliminacion(<?= $producto['id_producto'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación podría ir aquí si implementas paginación -->
        </div>
    </div>
</div>

<script>
function confirmarEliminacion(productoId) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        window.location.href = '<?= base_url('admin/productos/eliminar/') ?>' + productoId;
    }
}
</script>