<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Usuarios</h2>
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
                <div class="col-md-4">
                    <input type="text" class="form-control" id="search-term" placeholder="Buscar por nombre, email..." value="<?= esc($request->getGet('q')) ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filter-role">
                        <option value="">Todos los roles</option>
                        <option value="admin" <?= $request->getGet('rol') == 'admin' ? 'selected' : '' ?>>Administrador</option>
                        <option value="cliente" <?= $request->getGet('rol') == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filter-date-from" value="<?= esc($request->getGet('desde')) ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" id="apply-filters">Filtrar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['id_usuario'] ?></td>
                                <td>
                                    <?= $usuario['nombre'] ?? 'N/A' ?> <?= $usuario['apellido'] ?? '' ?>
                                </td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td><?= esc($usuario['username'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge <?= $usuario['rol'] == 'admin' ? 'bg-primary' : 'bg-secondary' ?>">
                                        <?= ucfirst($usuario['rol']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm px-3">
                                        <a href="<?= base_url('admin/usuarios/editar/' . $usuario['id_usuario']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
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
    // Aplicar filtros
    document.getElementById('apply-filters').addEventListener('click', function() {
        const params = new URLSearchParams();
        
        const term = document.getElementById('search-term').value;
        const role = document.getElementById('filter-role').value;
        const dateFrom = document.getElementById('filter-date-from').value;
        
        if (term) params.set('q', term);
        if (role) params.set('rol', role);
        if (dateFrom) params.set('desde', dateFrom);
        
        window.location.href = '<?= base_url('admin/usuarios/listar') ?>?' + params.toString();
    });
});
</script>