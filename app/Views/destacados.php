<?php
$destacadosModel = new \App\Models\DestacadosModel();
$destacados = $destacadosModel->getDestacadosActivos();
?>

<!--Cinta de Promos-->
<div class="section-adbar mt-3 mb-3">
    <div class="adbar-text-container js-adbar-animated">
        <span class="adbar-message">ENVÍO SAME DAY | CABA Y AMBA</span>
        <span class="adbar-message">3 Y 6 CUOTAS SIN INTERÉS</span>
        <span class="adbar-message">ENVÍO GRATIS A PARTIR DE $150.000</span>
    </div>
</div>

<!-- Cards de Productos destacados -->
<div class="new-arrivals py-5 bg-light mt-3">
  <div class="container">
    <div class="section-header text-center mb-5">
      <h2 class="fw-bold mb-3">DESTACADOS</h2>
    </div>

    <div class="row g-4 justify-content-center">
      <?php foreach ($destacados as $destacado): ?>
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-all hover-shadow">
          <div class="product-media position-relative">
            <video class="w-100" autoplay loop muted playsinline style="height: 300px; object-fit: cover;">
              <source src="<?= base_url('public/uploads/destacados/'.$destacado['video_url']) ?>" type="video/mp4">
            </video>
            <div class="product-badge bg-success text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">Destacado</div>
          </div>
          <div class="card-body text-center pt-4 pb-3">
            <h5 class="card-title fw-semibold mb-1"><?= esc($destacado['titulo']) ?></h5>
            <p class="text-muted small mb-3"><?= esc($destacado['subtitulo']) ?></p>
            <div class="d-flex justify-content-center align-items-center">
              <span class="text-primary fw-bold">$<?= number_format($destacado['precio'], 2, ',', '.') ?></span>
            </div>
            <div class="d-flex justify-content-center mt-2">
              <a href="<?= base_url('productos/'.$destacado['producto_id']) ?>" class="btn btn-success text-white col-9 rounded-pill">Ver detalles</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>