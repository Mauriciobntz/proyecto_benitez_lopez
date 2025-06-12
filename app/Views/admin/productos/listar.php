<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Productos</h2>
        <div>
            <a href="<?= base_url('admin/productos/crear') ?>" class="btn btn-primary">
                <i class="bi bi-plus"></i> Nuevo Producto
            </a>
            <div class="btn-group ms-2">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-download"></i> Exportar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('admin/productos/exportar/excel') ?>">Excel</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('admin/productos/exportar/pdf') ?>">PDF</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('admin/productos/exportar/csv') ?>">CSV</a></li>
                </ul>
            </div>
        </div>
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
                <div class="col-md-4">
                    <form id="search-form" method="get" action="<?= base_url('admin/productos/listar') ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" id="search-term" 
                                   placeholder="Buscar productos..." value="<?= esc($termino ?? '') ?>">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filter-category" onchange="applyFilters()">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id_categoria'] ?>" 
                                <?= ($categoria_seleccionada ?? '') == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                <?= $categoria['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filter-status" onchange="applyFilters()">
                        <option value="">Todos los estados</option>
                        <option value="1" <?= ($estado_seleccionado ?? '') === '1' ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= ($estado_seleccionado ?? '') === '0' ? 'selected' : '' ?>>Inactivo</option>
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
                                        <img src="<?= base_url('public/uploads/productos/' . $producto['imagen_url']) ?>" 
                                             class="img-thumbnail" style="width: 50px; height: 50px;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50" class="img-thumbnail" 
                                             style="width: 50px; height: 50px;">
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($producto['nombre']) ?></td>
                                <td>
                                    <?php 
                                    $categoriaNombre = 'Desconocida';
                                    foreach ($categorias as $cat) {
                                        if ($cat['id_categoria'] == $producto['categoria_id']) {
                                            $categoriaNombre = $cat['nombre'];
                                            break;
                                        }
                                    }
                                    echo esc($categoriaNombre);
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
                                        <a href="<?= base_url('admin/productos/editar/' . $producto['id_producto']) ?>" 
                                           class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger btn-eliminar" data-id="<?= $producto['id_producto'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const form = document.getElementById('search-form');
    const params = new URLSearchParams();
    
    // Agregar parámetros de búsqueda
    const term = document.getElementById('search-term').value;
    if (term) params.set('q', term);
    
    // Agregar filtro de categoría
    const category = document.getElementById('filter-category').value;
    if (category) params.set('categoria', category);
    
    // Agregar filtro de estado
    const status = document.getElementById('filter-status').value;
    if (status !== '') params.set('estado', status);
    
    // Redirigir con los parámetros
    window.location.href = '<?= base_url('admin/productos/listar') ?>?' + params.toString();
}


document.addEventListener('DOMContentLoaded', function() {
    // Manejar eliminación de productos (que ahora también puede desactivar)
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                fetch(`<?= base_url('admin/productos/eliminar/') ?>${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Recargar para ver los cambios
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar la solicitud');
                });
            }
        });
    });
});
</script>