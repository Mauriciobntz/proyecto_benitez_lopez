<section class="mt-3 mb-3">
<div class="container d-flex justify-content-center">
<div class="card shadow" style="width: 50%;">
<div class="card-header text-center bg-dark text-white">
<h2>Iniciar Sesion</h2>
</div>
<!-- Mensaje de Error -->
<!-- Incio del formulario de login-->
<form method="post" action="">
<div class="card-body" media="(max-width: 768px)">
<div class="mb-2">
<label for="exampleFormControlInput1" class="form-label">Correo</label>
<input name="email" type="text" class="form-control" placeholder="Correo" >
</div>
<div class="mb-3">
<label for="exampleFormControlInput1" class="form-label">Password</label>
<input name="pass" type="password" class="form-control" placeholder="contraseña">
</div>
<input type="submit" value="Ingresar" class="btn btn-dark"> 
<a href="" class="btn btn-danger">Cancelar</a> 
<br><span>¿Aún no se registró? <a href="<?php echo base_url('sign'); ?>">Registrarse aquí</a></span>
</div>
</form>
</div>
</div>
</section>