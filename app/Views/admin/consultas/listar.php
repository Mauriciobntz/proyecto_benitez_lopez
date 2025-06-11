<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Consultas</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Exportar
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Excel</a></li>
                <li><a class="dropdown-item" href="#">PDF</a></li>
            </ul>
        </div>
    </div>

    <?php if (session()->has('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3 mb-2 mb-md-0">
                    <input type="text" class="form-control" id="search-term" placeholder="Buscar por nombre, correo o mensaje..." value="<?= esc($filtros['search'] ?? '') ?>">
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <select class="form-select" id="filter-status">
                        <option value="">Todos los estados</option>
                        <option value="Sin Leer" <?= ($filtros['estado'] ?? '') == 'Sin Leer' ? 'selected' : '' ?>>Sin Leer</option>
                        <option value="Leida" <?= ($filtros['estado'] ?? '') == 'Leida' ? 'selected' : '' ?>>Leída</option>
                        <option value="En proceso" <?= ($filtros['estado'] ?? '') == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                        <option value="Resuelta" <?= ($filtros['estado'] ?? '') == 'Resuelta' ? 'selected' : '' ?>>Resuelta</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <select class="form-select" id="filter-subject">
                        <option value="">Todos los asuntos</option>
                        <option value="Solicitud de Cotizacion" <?= ($filtros['asunto'] ?? '') == 'Solicitud de Cotizacion' ? 'selected' : '' ?>>Solicitud de Cotización</option>
                        <option value="Soporte Tecnico" <?= ($filtros['asunto'] ?? '') == 'Soporte Tecnico' ? 'selected' : '' ?>>Soporte Técnico</option>
                        <option value="Consulta Facturacion" <?= ($filtros['asunto'] ?? '') == 'Consulta Facturacion' ? 'selected' : '' ?>>Facturación</option>
                        <option value="Reclamo" <?= ($filtros['asunto'] ?? '') == 'Reclamo' ? 'selected' : '' ?>>Reclamo</option>
                        <option value="Sugerencia" <?= ($filtros['asunto'] ?? '') == 'Sugerencia' ? 'selected' : '' ?>>Sugerencia</option>
                        <option value="Otros" <?= ($filtros['asunto'] ?? '') == 'Otros' ? 'selected' : '' ?>>Otros</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <input type="date" class="form-control" id="filter-date-from" value="<?= esc($filtros['desde'] ?? '') ?>">
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <input type="date" class="form-control" id="filter-date-to" value="<?= esc($filtros['hasta'] ?? '') ?>">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultas as $consulta): ?>
                            <tr>
                                <td>#<?= $consulta['id_consulta'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($consulta['fecha_creacion'])) ?></td>
                                <td><?= esc($consulta['nombre']) ?></td>
                                <td><?= esc($consulta['correo']) ?></td>
                                <td><?= esc($consulta['asunto']) ?></td>
                                <td>
                                    <span class="badge <?= [
                                        'Sin Leer' => 'bg-secondary',
                                        'Leida' => 'bg-primary',
                                        'En proceso' => 'bg-warning',
                                        'Resuelta' => 'bg-success'
                                    ][$consulta['estado']] ?>">
                                        <?= $consulta['estado'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/consultas/detalle/' . $consulta['id_consulta']) ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
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
    const applyFilters = () => {
        const params = new URLSearchParams();

        const term = document.getElementById('search-term').value;
        const status = document.getElementById('filter-status').value;
        const subject = document.getElementById('filter-subject').value;
        const dateFrom = document.getElementById('filter-date-from').value;
        const dateTo = document.getElementById('filter-date-to').value;

        if (term) params.set('search', term);
        if (status) params.set('estado', status);
        if (subject) params.set('asunto', subject);
        if (dateFrom) params.set('desde', dateFrom);
        if (dateTo) params.set('hasta', dateTo);

        window.location.href = '<?= base_url('admin/consultas/listar') ?>?' + params.toString();
    };

    document.getElementById('search-term').addEventListener('change', applyFilters);
    document.getElementById('filter-status').addEventListener('change', applyFilters);
    document.getElementById('filter-subject').addEventListener('change', applyFilters);
    document.getElementById('filter-date-from').addEventListener('change', applyFilters);
    document.getElementById('filter-date-to').addEventListener('change', applyFilters);
});
</script>