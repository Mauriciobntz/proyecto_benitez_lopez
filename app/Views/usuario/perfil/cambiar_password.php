<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cambiar Contraseña</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('perfil/actualizar-password') ?>" method="POST">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="currentPassword" name="password_actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="newPassword" name="password_nueva" required>
                            <div class="form-text">Mínimo 8 caracteres, incluyendo mayúsculas, números y símbolos.</div>
                        </div>
                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmar" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('perfil') ?>" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 