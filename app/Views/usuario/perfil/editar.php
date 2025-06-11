<div class="container-fluid mt-4">
    <div class="card shadow" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header bg-dark text-white">
            <h2 class="mb-0">Editar Usuario: <?= $usuario['persona']['nombre'] ?? $usuario['username'] ?></h2>
        </div>
        <div class="card-body">
            <?php if (session()->has('validation')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session('validation')->getErrors() as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/usuarios/actualizar') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="usuario_id" value="<?= $usuario['id_usuario'] ?>">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               value="<?= old('nombre', $usuario['persona']['nombre'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                               value="<?= old('apellido', $usuario['persona']['apellido'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', $usuario['email']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= old('username', $usuario['username'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo_documento" class="form-label">Tipo Documento</label>
                        <select class="form-select" id="tipo_documento" name="tipo_documento">
                            <option value="DNI" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'DNI' ? 'selected' : '' ?>>DNI</option>
                            <option value="NIE" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'NIE' ? 'selected' : '' ?>>NIE</option>
                            <option value="Pasaporte" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                            <option value="CIF" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'CIF' ? 'selected' : '' ?>>CIF</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" 
                               value="<?= old('documento', $usuario['persona']['documento'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                               value="<?= old('telefono', $usuario['persona']['telefono'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="cliente" <?= $usuario['rol'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                            <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" 
                               value="<?= old('fecha_nacimiento', $usuario['persona']['fecha_nacimiento'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="genero" class="form-label">Género</label>
                        <select class="form-select" id="genero" name="genero">
                            <option value="">Seleccionar</option>
                            <option value="H" <?= ($usuario['persona']['genero'] ?? '') == 'H' ? 'selected' : '' ?>>Hombre</option>
                            <option value="M" <?= ($usuario['persona']['genero'] ?? '') == 'M' ? 'selected' : '' ?>>Mujer</option>
                            <option value="O" <?= ($usuario['persona']['genero'] ?? '') == 'O' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>