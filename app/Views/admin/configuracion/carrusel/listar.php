<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Administrar Carrusel</h2>
        <a href="<?= base_url('admin/configuracion/carrusel/crear') ?>" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nuevo Slide
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
                <div class="col-md-4">
                    <input type="text" class="form-control" id="search-title" placeholder="Buscar por título..." value="<?= service('request')->getGet('titulo') ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filter-status">
                        <option value="">Todos los estados</option>
                        <option value="activo" <?= service('request')->getGet('estado') == 'activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="inactivo" <?= service('request')->getGet('estado') == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" id="filter-order-min" placeholder="Orden mínimo" value="<?= service('request')->getGet('orden_min') ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" id="filter-order-max" placeholder="Orden máximo" value="<?= service('request')->getGet('orden_max') ?>">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-secondary w-100" id="reset-filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($slides as $slide): ?>
                            <tr>
                                <td><?= $slide['orden'] ?></td>
                                <td>
                                    <img src="<?= base_url('public/uploads/carrusel/'.$slide['imagen']) ?>" class="img-thumbnail" style="max-height: 50px;">
                                </td>
                                <td><?= $slide['titulo'] ?></td>
                                <td>
                                    <span class="badge <?= $slide['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $slide['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/configuracion/carrusel/editar/' . $slide['id']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="confirmarEliminacion(<?= $slide['id'] ?>)">
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
        
        const titulo = document.getElementById('search-title').value;
        const estado = document.getElementById('filter-status').value;
        const ordenMin = document.getElementById('filter-order-min').value;
        const ordenMax = document.getElementById('filter-order-max').value;
        
        if (titulo) params.set('titulo', titulo);
        if (estado) params.set('estado', estado);
        if (ordenMin) params.set('orden_min', ordenMin);
        if (ordenMax) params.set('orden_max', ordenMax);
        
        window.location.href = '<?= base_url('admin/configuracion/carrusel/listar') ?>?' + params.toString();
    };

    // Resetear filtros
    document.getElementById('reset-filters').addEventListener('click', function() {
        window.location.href = '<?= base_url('admin/configuracion/carrusel/listar') ?>';
    });

    // Aplicar filtros al cambiar valores
    document.getElementById('search-title').addEventListener('change', applyFilters);
    document.getElementById('filter-status').addEventListener('change', applyFilters);
    document.getElementById('filter-order-min').addEventListener('change', applyFilters);
    document.getElementById('filter-order-max').addEventListener('change', applyFilters);

    // Confirmación de eliminación
    window.confirmarEliminacion = function(slideId) {
        if (confirm('¿Estás seguro de que deseas eliminar este slide del carrusel?')) {
            window.location.href = '<?= base_url('admin/configuracion/carrusel/eliminar/') ?>' + slideId;
        }
    }
});
</script>