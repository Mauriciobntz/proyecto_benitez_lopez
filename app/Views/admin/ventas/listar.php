<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ventas</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Exportar
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Excel</a></li>
                <li><a class="dropdown-item" href="#">PDF</a></li>
                <li><a class="dropdown-item" href="#">CSV</a></li>
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
                <div class="col-md-3">
                    <input type="text" class="form-control" id="search-id" placeholder="Buscar por ID..." value="<?= service('request')->getGet('id') ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filter-status">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" <?= service('request')->getGet('estado') == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="pagado" <?= service('request')->getGet('estado') == 'pagado' ? 'selected' : '' ?>>Pagado</option>
                        <option value="enviado" <?= service('request')->getGet('estado') == 'enviado' ? 'selected' : '' ?>>Enviado</option>
                        <option value="entregado" <?= service('request')->getGet('estado') == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                        <option value="cancelado" <?= service('request')->getGet('estado') == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filter-date-from" value="<?= service('request')->getGet('desde') ?>">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filter-date-to" value="<?= service('request')->getGet('hasta') ?>">
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
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Método Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta): ?>
                            <?php 
                            $badgeClass = [
                                'pendiente' => 'bg-secondary',
                                'pagado' => 'bg-primary',
                                'enviado' => 'bg-info',
                                'entregado' => 'bg-success',
                                'cancelado' => 'bg-danger'
                            ];
                            ?>
                            <tr>
                                <td>#<?= $venta['id_venta'] ?></td>
                                <td><?= date('d/m/Y', strtotime($venta['fecha_venta'])) ?></td>
                                <td><?= $venta['nombre_cliente'] ?? 'Cliente #' . $venta['usuario_id'] ?></td>
                                <td>€<?= number_format($venta['total'], 2) ?></td>
                                <td><span class="badge <?= $badgeClass[$venta['estado']] ?>"><?= ucfirst($venta['estado']) ?></span></td>
                                <td><?= isset($venta['metodo_pago']) ? ucfirst(strtolower($venta['metodo_pago'])) : 'No especificado' ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/ventas/detalle/' . $venta['id_venta']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/ventas/factura/' . $venta['id_venta']) ?>" class="btn btn-outline-secondary" target="_blank">
                                            <i class="bi bi-printer"></i>
                                        </a>
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
        
        const id = document.getElementById('search-id').value;
        const status = document.getElementById('filter-status').value;
        const dateFrom = document.getElementById('filter-date-from').value;
        const dateTo = document.getElementById('filter-date-to').value;
        
        if (id) params.set('id', id);
        if (status) params.set('estado', status);
        if (dateFrom) params.set('desde', dateFrom);
        if (dateTo) params.set('hasta', dateTo);
        
        window.location.href = '<?= base_url('admin/ventas/listar') ?>?' + params.toString();
    };

    document.getElementById('search-id').addEventListener('change', applyFilters);
    document.getElementById('filter-status').addEventListener('change', applyFilters);
    document.getElementById('filter-date-from').addEventListener('change', applyFilters);
    document.getElementById('filter-date-to').addEventListener('change', applyFilters);
});
</script>