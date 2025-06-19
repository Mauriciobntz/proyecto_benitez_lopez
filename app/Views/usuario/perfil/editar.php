<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
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
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?= esc($usuario['persona']['nombre'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                       value="<?= esc($usuario['persona']['apellido'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= esc($usuario['username'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= esc($usuario['email']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                       value="<?= esc($usuario['persona']['telefono'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fechaNacimiento" name="fecha_nacimiento" 
                                       value="<?= esc($usuario['persona']['fecha_nacimiento'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select" id="genero" name="genero">
                                    <option value="H" <?= ($usuario['persona']['genero'] ?? '') == 'H' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="M" <?= ($usuario['persona']['genero'] ?? '') == 'M' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="O" <?= ($usuario['persona']['genero'] ?? '') == 'O' ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                                <select class="form-select" id="tipoDocumento" name="tipo_documento">
                                    <option value="DNI" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'DNI' ? 'selected' : '' ?>>DNI</option>
                                    <option value="NIE" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'NIE' ? 'selected' : '' ?>>NIE</option>
                                    <option value="Pasaporte" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                    <option value="CIF" <?= ($usuario['persona']['tipo_documento'] ?? '') == 'CIF' ? 'selected' : '' ?>>CIF</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="documento" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento" 
                                       value="<?= esc($usuario['persona']['documento'] ?? '') ?>">
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