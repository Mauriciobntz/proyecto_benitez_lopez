<section class="mt-3 mb-3">
    <div class="container d-flex justify-content-center">
        <div class="card shadow" style="width: 50%;">
            <div class="card-header text-center bg-dark text-white">
                <h2>Iniciar Sesión</h2>
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
            
            <!-- Inicio del formulario de login -->
            <form method="post" action="<?= base_url('login') ?>">
                <div class="card-body" media="(max-width: 768px)">
                    <div class="mb-2">
                        <label for="email" class="form-label">Correo</label>
                        <input name="email" type="text" class="form-control" placeholder="Correo" value="<?= old('email') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input name="pass" type="password" class="form-control" placeholder="contraseña">
                    </div>
                    <input type="submit" value="Ingresar" class="btn btn-dark"> 
                    <a href="<?= base_url('/') ?>" class="btn btn-danger">Cancelar</a> 
                    <br><span>¿Aún no se registró? <a href="<?= base_url('sign') ?>">Registrarse aquí</a></span>
                </div>
            </form>
        </div>
    </div>
</section>