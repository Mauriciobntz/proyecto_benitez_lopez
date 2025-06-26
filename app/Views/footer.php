<?php
$isLoggedIn = session('logged_in');
$isAdmin = $isLoggedIn && session('rol') === 'admin';
$isUser = $isLoggedIn && !$isAdmin;
?>

<section class="mt-3">

<?php if (!$isAdmin): ?>

<!--Cinta de Marcas-->
<div class="brands-carousel">
    <div class="brands-track">
        <div class="brands-container">
        <a href="/marca/adata/">
            <img src="https://statics.qloud.ar/MARCAS/adata.jpg" alt="ADATA">
        </a>
        <a href="/marca/aerocool/">
            <img src="https://statics.qloud.ar/MARCAS/aerocool.jpg" alt="AEROCOOL">
        </a>
        <a href="/marca/amd/">
            <img src="https://statics.qloud.ar/MARCAS/amd.jpg" alt="AMD">
        </a>
        <a href="/marca/asrock/">
            <img src="https://statics.qloud.ar/MARCAS/asrock.jpg" alt="ASROCK">
        </a>
        <a href="/marca/asus/">
            <img src="https://statics.qloud.ar/MARCAS/asus.jpg" alt="ASUS">
        </a>
        <a href="/marca/corsair/">
            <img src="https://statics.qloud.ar/MARCAS/corsair.jpg" alt="CORSAIR">
        </a>
        <a href="/marca/dell/">
            <img src="https://statics.qloud.ar/MARCAS/dell.jpg" alt="DELL">
        </a>
        <a href="/marca/hp/">
            <img src="https://statics.qloud.ar/MARCAS/hp.jpg" alt="HP">
        </a>
        <a href="/marca/intel/">
            <img src="https://statics.qloud.ar/MARCAS/intel.jpg" alt="INTEL">
        </a>
        <a href="/marca/kingston/">
            <img src="https://statics.qloud.ar/MARCAS/kingston.jpg" alt="KINGSTON">
        </a>
        </div>
        <!-- Duplicamos las marcas para el efecto infinito -->
        <div class="brands-container">
        <a href="/marca/adata/">
            <img src="https://statics.qloud.ar/MARCAS/adata.jpg" alt="ADATA">
        </a>
        <a href="/marca/aerocool/">
            <img src="https://statics.qloud.ar/MARCAS/aerocool.jpg" alt="AEROCOOL">
        </a>
        <a href="/marca/amd/">
            <img src="https://statics.qloud.ar/MARCAS/amd.jpg" alt="AMD">
        </a>
        <a href="/marca/asrock/">
            <img src="https://statics.qloud.ar/MARCAS/asrock.jpg" alt="ASROCK">
        </a>
        <a href="/marca/asus/">
            <img src="https://statics.qloud.ar/MARCAS/asus.jpg" alt="ASUS">
        </a>
        <a href="/marca/corsair/">
            <img src="https://statics.qloud.ar/MARCAS/corsair.jpg" alt="CORSAIR">
        </a>
        <a href="/marca/dell/">
            <img src="https://statics.qloud.ar/MARCAS/dell.jpg" alt="DELL">
        </a>
        <a href="/marca/hp/">
            <img src="https://statics.qloud.ar/MARCAS/hp.jpg" alt="HP">
        </a>
        <a href="/marca/intel/">
            <img src="https://statics.qloud.ar/MARCAS/intel.jpg" alt="INTEL">
        </a>
        <a href="/marca/kingston/">
            <img src="https://statics.qloud.ar/MARCAS/kingston.jpg" alt="KINGSTON">
        </a>
        </div>
    </div>
</div>
<!--Fin cinta de Marcas-->

<?php endif; ?>


<!-- Footer -->
<footer class="bg-dark mt-5">

<?php if (!$isAdmin): ?>


  <div class="container-fluid d-flex justify-content-center align-items-center" style="padding: 20px 50px;">
    <div class="row w-100 justify-content-center g-4">
      <!-- Columna 1: Información -->
      <div class="col-12 col-lg-2 text-white">
        <h6 class="text-uppercase fw-bold mb-4"><?= htmlspecialchars($nombreTienda) ?></h6>
        <p>
        <?= htmlspecialchars($configuracionTienda['mensaje_bienvenida']) ?>
        </p>
      </div>

      <!-- Columna 2: Productos -->
      <div class="col-6 col-lg-2 text-white">
        <h6 class="text-uppercase fw-bold mb-4">Productos</h6>
        <?php if(isset($categoriasGlobales) && is_array($categoriasGlobales)): ?>
          <?php foreach(array_slice($categoriasGlobales, 0, 4) as $categoria): ?>
            <p>
              <a href="<?= base_url('productos/categoria/'.$categoria['id_categoria']) ?>" class="text-reset text-decoration-none">
                <?= htmlspecialchars($categoria['nombre']) ?>
              </a>
            </p>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Columna 3: Menú -->
      <div class="col-6 col-lg-2 text-white">
        <h6 class="text-uppercase fw-bold mb-4">Menú</h6>
        <p>
          <a href="<?= base_url('principal') ?>" class="text-reset text-decoration-none">Inicio</a>
        </p>
        <p>
          <a href="<?= base_url('productos') ?>" class="text-reset text-decoration-none">Productos</a>
        </p>
        <p>
          <a href="<?= base_url('contacto') ?>" class="text-reset text-decoration-none">Contacto</a>
        </p>
        <p>
          <a href="<?= base_url('terminos') ?>" class="text-reset text-decoration-none">Términos de Uso</a>
        </p>
      </div>

      <!-- Columna 4: Contacto -->
      <div class="col-12 col-lg-3 text-white">
        <h6 class="text-uppercase fw-bold mb-4">Contacto</h6>
        <?php if(!empty($direccionTienda)): ?>
          <p><i class="fas fa-home me-3"></i><?= htmlspecialchars($direccionTienda) ?></p>
        <?php endif; ?>
        <?php if(!empty($emailTienda)): ?>
          <p><i class="fas fa-envelope me-3"></i><?= htmlspecialchars($emailTienda) ?></p>
        <?php endif; ?>
        <?php if(!empty($telefonoTienda)): ?>
          <p><i class="fas fa-phone me-3"></i><?= htmlspecialchars($telefonoTienda) ?></p>
        <?php endif; ?>
        <?php if(!empty($whatsappTienda)): ?>
          <p><i class="fab fa-whatsapp me-3"></i><?= htmlspecialchars($whatsappTienda) ?></p>
        <?php endif; ?>
        <?php if(!empty($horarioAtencion)): ?>
          <p><i class="fas fa-clock me-3"></i><?= htmlspecialchars($horarioAtencion) ?></p>
        <?php endif; ?>
      </div>

      <!-- Columna 5: Redes Sociales -->
      <div class="col-12 col-lg-2 text-white">
        <h6 class="text-uppercase fw-bold mb-4">Redes Sociales</h6>
        <div class="d-flex flex-column">
          <?php if(!empty($facebookUrl)): ?>
            <a href="<?= htmlspecialchars($facebookUrl) ?>" class="text-reset text-decoration-none mb-2" target="_blank">
              <i class="fab fa-facebook-f me-2"></i> Facebook
            </a>
          <?php endif; ?>
          <?php if(!empty($instagramUrl)): ?>
            <a href="<?= htmlspecialchars($instagramUrl) ?>" class="text-reset text-decoration-none mb-2" target="_blank">
              <i class="fab fa-instagram me-2"></i> Instagram
            </a>
          <?php endif; ?>
          <?php if(!empty($twitterUrl)): ?>
            <a href="<?= htmlspecialchars($twitterUrl) ?>" class="text-reset text-decoration-none mb-2" target="_blank">
              <i class="fab fa-twitter me-2"></i> Twitter
            </a>
          <?php endif; ?>
          <?php if(!empty($whatsappUrl)): ?>
            <a href="<?= htmlspecialchars($whatsappUrl) ?>" class="text-reset text-decoration-none" target="_blank">
              <i class="fab fa-whatsapp me-2"></i> WhatsApp
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>


  <!-- Copyright -->
  <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © <?= date('Y') ?> Copyright:
    <a class="text-white text-decoration-none" href="<?= base_url() ?>"><?= htmlspecialchars($nombreTienda) ?>.com.ar</a>
  </div>
</footer>

<!-- Scripts -->
<script src="http://localhost/proyecto_benitez_lopez/assets/js/bootstrap.bundle.min.js"></script>
<script src="http://localhost/proyecto_benitez_lopez/assets/js/mi-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>