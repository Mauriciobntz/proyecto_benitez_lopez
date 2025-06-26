<?php
$errors = session('errors') ?? [];
$oldData = session('_ci_old_input') ?? [];
?>
<section class="mt-3 mb-3">
    <div class="container d-flex justify-content-center">
        <div class="card shadow" style="width: 70%;">
            <div class="card-header text-center bg-dark text-white">
                <h2>Registro de Usuario</h2>
            </div>
            
            <!-- Mostrar mensajes de error/success -->
            <?php if (session('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif ?>

            <!-- Inicio del formulario de registro -->
            <form method="post" action="<?= base_url('sign') ?>">
                <?= csrf_field() ?>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" 
                               class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                               id="username" 
                               name="username" 
                               value="<?= old('username') ?>" 
                               placeholder="Nombre de usuario">
                        <?php if (isset($errors['username'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['username'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-2">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               value="<?= old('email') ?>" 
                               placeholder="Correo electrónico">
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-2">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" 
                               class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Contraseña">
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['password'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <input type="password" 
                               class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" 
                               id="confirm_password" 
                               name="confirm_password" 
                               placeholder="Confirmar contraseña">
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['confirm_password'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <input type="submit" value="Registrarse" class="btn btn-dark"> 
                    <a href="<?= site_url('/') ?>" class="btn btn-danger">Cancelar</a>
                    <br><span>¿Ya tienes una cuenta? <a href="<?= site_url('login') ?>">Inicia sesión aquí</a></span>
                </div>
            </form>
        </div>
    </div>
</section>