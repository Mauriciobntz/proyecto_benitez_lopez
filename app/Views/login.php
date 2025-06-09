<section class="mt-3 mb-3">
    <div class="container d-flex justify-content-center">
        <div class="card shadow" style="width: 70%;">
            <div class="card-header text-center bg-dark text-white">
                <h2>Iniciar Sesión</h2>
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
            
            <?php if (session('message')): ?>
                <div class="alert alert-success">
                    <?= session('message') ?>
                </div>
            <?php endif ?>

            <!-- Inicio del formulario de login -->
            <form method="post" action="<?= base_url('login') ?>">
                <div class="card-body" media="(max-width: 768px)">
                    <div class="mb-2">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input name="email" type="email" 
                               class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                               placeholder="Correo electrónico" 
                               value="<?= old('email') ?>">
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input name="password" type="password" 
                               class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                               placeholder="Contraseña" minlength="8" required> 
                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
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