<section class="mt-3 mb-3">
    <div class="container d-flex justify-content-center">
        <div class="card shadow" style="width: 70%;">
            <div class="card-header text-center bg-dark text-white">
                <h2>Registro de Usuario</h2>
            </div>
            
            <!-- Mostrar mensajes de error/success -->
            <?php if (session('error') || session('errors')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                    <?php 
                    if (session('errors')) {
                        foreach (session('errors') as $error) {
                            echo "<p>$error</p>";
                        }
                    }
                    ?>
                </div>
            <?php endif ?>

            <!-- Inicio del formulario de registro -->
            <form method="post" action="<?= base_url('sign') ?>">
                <div class="card-body">
                    <div class="mb-2">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input name="username" type="text" 
                               class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                               placeholder="Nombre de usuario" 
                               value="<?= old('username') ?? '' ?>" 
                               required>
                        <?php if (isset($validation) && $validation->hasError('username')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-2">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input name="email" type="email" 
                               class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                               placeholder="Correo electrónico" 
                               value="<?= old('email') ?? '' ?>" 
                               required>
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-2">
                        <label for="password" class="form-label">Contraseña</label>
                        <input name="password" type="password" 
                               class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                               placeholder="Contraseña (mínimo 8 caracteres)" 
                               minlength="8" 
                               required>
                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <input name="confirm_password" type="password" 
                               class="form-control <?= isset($validation) && $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>" 
                               placeholder="Repetir contraseña" 
                               required>
                        <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('confirm_password') ?>
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