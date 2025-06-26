<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
$errors = session('errors') ?? [];
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
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Contraseña Actual</label>
                            <input type="password" 
                                   class="form-control <?= isset($errors['current_password']) ? 'is-invalid' : '' ?>" 
                                   id="currentPassword" 
                                   name="current_password">
                            <?php if (isset($errors['current_password'])): ?>
                                <div class="invalid-feedback"><?= $errors['current_password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control <?= isset($errors['new_password']) ? 'is-invalid' : '' ?>" 
                                   id="newPassword" 
                                   name="new_password">
                            <div class="form-text">Mínimo 8 caracteres, incluyendo mayúsculas, números y símbolos.</div>
                            <?php if (isset($errors['new_password'])): ?>
                                <div class="invalid-feedback"><?= $errors['new_password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" 
                                   id="confirmPassword" 
                                   name="confirm_password">
                            <?php if (isset($errors['confirm_password'])): ?>
                                <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
                            <?php endif; ?>
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