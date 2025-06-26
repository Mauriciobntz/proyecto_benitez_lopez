<?php
$errors = session('errors') ?? [];
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Perfil</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('perfil/actualizar') ?>" method="POST">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="<?= old('nombre', $usuario['persona']['nombre'] ?? '') ?>">
                                <?php if (isset($errors['nombre'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nombre'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['apellido']) ? 'is-invalid' : '' ?>" 
                                       id="apellido" 
                                       name="apellido" 
                                       value="<?= old('apellido', $usuario['persona']['apellido'] ?? '') ?>">
                                <?php if (isset($errors['apellido'])): ?>
                                    <div class="invalid-feedback"><?= $errors['apellido'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                       id="username" 
                                       name="username" 
                                       value="<?= old('username', $usuario['username'] ?? '') ?>">
                                <?php if (isset($errors['username'])): ?>
                                    <div class="invalid-feedback"><?= $errors['username'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" 
                                       class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= old('email', $usuario['email']) ?>">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control <?= isset($errors['telefono']) ? 'is-invalid' : '' ?>" 
                                       id="telefono" name="telefono" 
                                       value="<?= old('telefono', $usuario['persona']['telefono'] ?? '') ?>">
                                <?php if (isset($errors['telefono'])): ?>
                                    <div class="invalid-feedback"><?= $errors['telefono'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control <?= isset($errors['fecha_nacimiento']) ? 'is-invalid' : '' ?>" 
                                       id="fechaNacimiento" name="fecha_nacimiento" 
                                       value="<?= old('fecha_nacimiento', $usuario['persona']['fecha_nacimiento'] ?? '') ?>">
                                <?php if (isset($errors['fecha_nacimiento'])): ?>
                                    <div class="invalid-feedback"><?= $errors['fecha_nacimiento'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select <?= isset($errors['genero']) ? 'is-invalid' : '' ?>" id="genero" name="genero">
                                    <option value="H" <?= (old('genero', $usuario['persona']['genero'] ?? '')) == 'H' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="M" <?= (old('genero', $usuario['persona']['genero'] ?? '')) == 'M' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="O" <?= (old('genero', $usuario['persona']['genero'] ?? '')) == 'O' ? 'selected' : '' ?>>Otro</option>
                                </select>
                                <?php if (isset($errors['genero'])): ?>
                                    <div class="invalid-feedback"><?= $errors['genero'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                                <select class="form-select <?= isset($errors['tipo_documento']) ? 'is-invalid' : '' ?>" id="tipoDocumento" name="tipo_documento">
                                    <option value="DNI" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '')) == 'DNI' ? 'selected' : '' ?>>DNI</option>
                                    <option value="NIE" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '')) == 'NIE' ? 'selected' : '' ?>>NIE</option>
                                    <option value="Pasaporte" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '')) == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                    <option value="CIF" <?= (old('tipo_documento', $usuario['persona']['tipo_documento'] ?? '')) == 'CIF' ? 'selected' : '' ?>>CIF</option>
                                </select>
                                <?php if (isset($errors['tipo_documento'])): ?>
                                    <div class="invalid-feedback"><?= $errors['tipo_documento'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="documento" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control <?= isset($errors['documento']) ? 'is-invalid' : '' ?>" 
                                       id="documento" name="documento" 
                                       value="<?= old('documento', $usuario['persona']['documento'] ?? '') ?>">
                                <?php if (isset($errors['documento'])): ?>
                                    <div class="invalid-feedback"><?= $errors['documento'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('perfil') ?>" class="btn btn-outline-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 