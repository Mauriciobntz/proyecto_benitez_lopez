<section class="mt-3 mb-3">
    <div class="container d-flex justify-content-center">
        <div class="card shadow" style="width: 50%;">
            <div class="card-header text-center bg-dark text-white">
                <h2>Registrarse</h2>
            </div>
            
            <!-- Mostrar mensajes de error/success -->
            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            
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
            
            <!-- Inicio del formulario de registro -->
            <form method="post" action="<?= site_url('sign') ?>">
                <div class="card-body">
                    <div class="mb-2">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input name="username" type="text" 
                                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                placeholder="Nombre de usuario" 
                                value="<?= old('username') ?? '' ?>" 
                                required>
                        <?php if(isset($errors['username'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['username'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-2">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input name="email" type="email" 
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                placeholder="Correo electrónico" 
                                value="<?= old('email') ?? '' ?>" 
                                required>
                        <?php if(isset($errors['email'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-2">
                        <label for="password" class="form-label">Contraseña</label>
                        <input name="password" type="password" 
                                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                placeholder="Contraseña (mínimo 8 caracteres)" 
                                minlength="8" 
                                required>
                        <?php if(isset($errors['password'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['password'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                        <input name="password_confirm" type="password" 
                                class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                placeholder="Repetir contraseña" 
                                required>
                        <?php if(isset($errors['password_confirm'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['password_confirm'] ?>
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