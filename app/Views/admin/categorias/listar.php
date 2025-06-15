<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Categorías</h2>
        <a href="<?= base_url('admin/categorias/crear') ?>" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nueva Categoría
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?= $categoria['id_categoria'] ?></td>
                                <td>
                                    <?php if (!empty($categoria['imagen_url'])): ?>
                                        <img src="<?= base_url('public/uploads/categorias/' . $categoria['imagen_url']) ?>" 
                                            class="img-thumbnail" style="max-height: 50px; max-width: 75px;">
                                    <?php else: ?>
                                        <span class="text-muted">Sin imagen</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $categoria['nombre'] ?></td>
                                <td><?= $categoria['descripcion'] ?? 'Sin descripción' ?></td>
                                <td><?= $categoria['total_productos'] ?? 0 ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/categorias/editar/' . $categoria['id_categoria']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="confirmarEliminacion(<?= $categoria['id_categoria'] ?>)">
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
function confirmarEliminacion(categoriaId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta categoría? Los productos asociados no se eliminarán pero quedarán sin categoría.')) {
        window.location.href = '<?= base_url('admin/categorias/eliminar/') ?>' + categoriaId;
    }
}
</script>