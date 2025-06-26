<?php
$errors = session('errors') ?? [];
$oldData = session('_ci_old_input') ?? [];
?>

<section class="mt-3 mb-3">
    <div class="container d-flex justify-content-center">
        <div class="card shadow" style="width: 70%;">
            <div class="card-header text-center bg-dark text-white">
                <h2>Iniciar Sesión</h2>
            </div>
            
            <!-- Mostrar mensajes de error/success -->
            <?php if (session('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif ?>

            <?php if (session('message')): ?>
                <div class="alert alert-success">
                    <?= session('message') ?>
                </div>
            <?php endif ?>

            <!-- Inicio del formulario de login -->
            <form method="post" action="<?= base_url('login') ?>">
                <?= csrf_field() ?>
                <div class="card-body" media="(max-width: 768px)">
                    <div class="mb-2">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input name="email" type="email" 
                               class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               placeholder="Correo electrónico" 
                               value="<?= old('email') ?>">
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
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
                    <input type="submit" value="Ingresar" class="btn btn-dark"> 
                    <a href="<?= base_url('/') ?>" class="btn btn-danger">Cancelar</a> 
                    <br><span>¿Aún no se registró? <a href="<?= base_url('sign') ?>">Registrarse aquí</a></span>
                </div>
            </form>
        </div>
    </div>
</section>