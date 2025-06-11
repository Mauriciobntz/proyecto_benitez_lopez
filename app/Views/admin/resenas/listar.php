<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reseñas</h2>
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
                <div class="col-md-3">
                    <select class="form-select" id="filter-product">
                        <option value="">Todos los productos</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id_producto'] ?>" <?= $request->getGet('producto_id') == $producto['id_producto'] ? 'selected' : '' ?>>
                                <?= $producto['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filter-user">
                        <option value="">Todos los usuarios</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id_usuario'] ?>" <?= $request->getGet('usuario_id') == $usuario['id_usuario'] ? 'selected' : '' ?>>
                                <?= $usuario['username'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filter-rating">
                        <option value="">Todas las calificaciones</option>
                        <option value="1" <?= $request->getGet('calificacion') == 1 ? 'selected' : '' ?>>1 estrella</option>
                        <option value="2" <?= $request->getGet('calificacion') == 2 ? 'selected' : '' ?>>2 estrellas</option>
                        <option value="3" <?= $request->getGet('calificacion') == 3 ? 'selected' : '' ?>>3 estrellas</option>
                        <option value="4" <?= $request->getGet('calificacion') == 4 ? 'selected' : '' ?>>4 estrellas</option>
                        <option value="5" <?= $request->getGet('calificacion') == 5 ? 'selected' : '' ?>>5 estrellas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="filter-date-from" value="<?= $request->getGet('desde') ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="filter-date-to" value="<?= $request->getGet('hasta') ?>">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Usuario</th>
                            <th>Calificación</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resenas as $resena): ?>
                            <tr>
                                <td><?= $resena['id_resena'] ?></td>
                                <td><?= $resena['producto_nombre'] ?></td>
                                <td><?= $resena['usuario_nombre'] ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= $resena['calificacion'] ? '-fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                </td>
                                <td><?= $resena['comentario'] ? substr($resena['comentario'], 0, 50) . (strlen($resena['comentario']) > 50 ? '...' : '') : 'Sin comentario' ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($resena['fecha'])) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/resenas/editar/' . $resena['id_resena']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="confirmarEliminacion(<?= $resena['id_resena'] ?>)">
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
document.addEventListener('DOMContentLoaded', function() {
    // Filtros
    const applyFilters = () => {
        const params = new URLSearchParams();
        
        const product = document.getElementById('filter-product').value;
        const user = document.getElementById('filter-user').value;
        const rating = document.getElementById('filter-rating').value;
        const dateFrom = document.getElementById('filter-date-from').value;
        const dateTo = document.getElementById('filter-date-to').value;
        
        if (product) params.set('producto_id', product);
        if (user) params.set('usuario_id', user);
        if (rating) params.set('calificacion', rating);
        if (dateFrom) params.set('desde', dateFrom);
        if (dateTo) params.set('hasta', dateTo);
        
        window.location.href = '<?= base_url('admin/resenas/listar') ?>?' + params.toString();
    };

    document.getElementById('filter-product').addEventListener('change', applyFilters);
    document.getElementById('filter-user').addEventListener('change', applyFilters);
    document.getElementById('filter-rating').addEventListener('change', applyFilters);
    document.getElementById('filter-date-from').addEventListener('change', applyFilters);
    document.getElementById('filter-date-to').addEventListener('change', applyFilters);
});

function confirmarEliminacion(resenaId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta reseña?')) {
        window.location.href = '<?= base_url('admin/resenas/eliminar/') ?>' + resenaId;
    }
}
</script>