<div class="container-fluid mt-4">
    <div class="card shadow" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header bg-dark text-white">
            <h2 class="mb-0">Editar Usuario: <?= $usuario['nombre'] ?? $usuario['username'] ?></h2>
        </div>
        <div class="card-body">
            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/usuarios/actualizar/'.$usuario['id_usuario']) ?>" method="post">
                <?= csrf_field() ?>
                
                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control <?= isset(session('errors')['nombre']) ? 'is-invalid' : '' ?>" id="nombre" name="nombre" 
                               value="<?= old('nombre', $usuario['persona']['nombre'] ?? '') ?>">
                        <?php if (isset(session('errors')['nombre'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['nombre']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control <?= isset(session('errors')['apellido']) ? 'is-invalid' : '' ?>" id="apellido" name="apellido" 
                               value="<?= old('apellido', $usuario['persona']['apellido'] ?? '') ?>">
                        <?php if (isset(session('errors')['apellido'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['apellido']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" id="email" name="email" 
                               value="<?= old('email', $usuario['email']) ?>">
                        <?php if (isset(session('errors')['email'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['email']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control <?= isset(session('errors')['username']) ? 'is-invalid' : '' ?>" id="username" name="username" 
                               value="<?= old('username', $usuario['username'] ?? '') ?>">
                        <?php if (isset(session('errors')['username'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['username']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo_documento" class="form-label">Tipo Documento</label>
                        <select class="form-select <?= isset(session('errors')['tipo_documento']) ? 'is-invalid' : '' ?>" id="tipo_documento" name="tipo_documento">
                            <option value="DNI" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '') == 'DNI') ? 'selected' : '' ?>>DNI</option>
                            <option value="NIE" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '') == 'NIE') ? 'selected' : '' ?>>NIE</option>
                            <option value="Pasaporte" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '') == 'Pasaporte') ? 'selected' : '' ?>>Pasaporte</option>
                            <option value="CIF" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '') == 'CIF') ? 'selected' : '' ?>>CIF</option>
                        </select>
                        <?php if (isset(session('errors')['tipo_documento'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['tipo_documento']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control <?= isset(session('errors')['documento']) ? 'is-invalid' : '' ?>" id="documento" name="documento" 
                               value="<?= old('documento', $usuario['persona']['documento'] ?? '') ?>">
                        <?php if (isset(session('errors')['documento'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['documento']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control <?= isset(session('errors')['telefono']) ? 'is-invalid' : '' ?>" id="telefono" name="telefono" 
                               value="<?= old('telefono', $usuario['persona']['telefono'] ?? '') ?>">
                        <?php if (isset(session('errors')['telefono'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['telefono']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select <?= isset(session('errors')['rol']) ? 'is-invalid' : '' ?>" id="rol" name="rol">
                            <option value="cliente" <?= old('rol', $usuario['rol']) == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                            <option value="admin" <?= old('rol', $usuario['rol']) == 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                        <?php if (isset(session('errors')['rol'])): ?>
                            <div class="invalid-feedback d-block"><?= esc(session('errors')['rol']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= base_url('admin/usuarios/listar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>