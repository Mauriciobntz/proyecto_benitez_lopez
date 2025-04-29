<section class="mt-3 mb-3">
  <div class="container d-flex justify-content-center">
    <div class="card shadow" style="width: 50%;">
      <div class="card-header text-center bg-dark text-white">
        <h2>Registrarse</h2>
      </div>
      <!-- Incio del formulario de registro -->
      <form method="post" action="">
        <div class="card-body" media="(max-width: 768px)">
          <div class="mb-2">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input name="nombre" type="text" class="form-control" placeholder="Nombre y Apellido" required>
          </div>
          <div class="mb-2">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input name="email" type="email" class="form-control" placeholder="Correo" required>
          </div>
          <div class="mb-2">
            <label for="usuario" class="form-label">Nombre de Usuario</label>
            <input name="usuario" type="text" class="form-control" placeholder="Usuario" required>
          </div>
          <div class="mb-2">
            <label for="pass" class="form-label">Contraseña</label>
            <input name="pass" type="password" class="form-control" placeholder="Contraseña" required>
          </div>
          <div class="mb-3">
            <label for="confirm_pass" class="form-label">Confirmar Contraseña</label>
            <input name="confirm_pass" type="password" class="form-control" placeholder="Repetir Contraseña" required>
          </div>
          <input type="submit" value="Registrarse" class="btn btn-dark"> 
          <a href="" class="btn btn-danger">Cancelar</a> 
          <br><span>¿Ya tienes una cuenta? <a href="<?php echo base_url('login'); ?>">Inicia sesión aquí</a></span>
        </div>
      </form>
    </div>
  </div>
</section>