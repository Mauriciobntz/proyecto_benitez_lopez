<?php
$productoModel = new \App\Models\ProductoModel();
$nuevosIngresos = $productoModel->where('activo', 1)
                               ->orderBy('fecha_alta', 'DESC')
                               ->limit(4)
                               ->findAll();
?>

<!-- Cards de Ingresos Mejoradas -->
<div class="new-arrivals py-5 bg-light">
  <div class="container">
    <div class="section-header text-center mb-5">
      <h2 class="fw-bold mb-3">NUEVOS INGRESOS</h2>
    </div>

    <div class="row g-4 justify-content-center">
      <?php foreach ($nuevosIngresos as $producto): ?>
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-all hover-shadow">
          <div class="product-media position-relative">
            <?php if($producto['imagen_url']): ?>
              <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url']) ?>" class="w-100" style="height: 300px; object-fit: cover;" alt="<?= esc($producto['nombre']) ?>">
            <?php else: ?>
              <img src="<?= base_url('assets/img/default-product.jpg') ?>" class="w-100" style="height: 300px; object-fit: cover;" alt="Producto sin imagen">
            <?php endif; ?>
            <div class="product-badge bg-danger text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">Nuevo</div>
          </div>
          <div class="card-body text-center pt-4 pb-3">
            <h5 class="card-title fw-semibold mb-1"><?= esc($producto['nombre']) ?></h5>
            <p class="text-muted small mb-3"><?= esc($producto['marca']).' '.esc($producto['modelo']) ?></p>
            <div class="d-flex justify-content-center align-items-center">
              <span class="text-primary fw-bold">$<?= number_format($producto['precio'], 2, ',', '.') ?></span>
            </div>
            <div class="d-flex justify-content-center mt-2">
                      <a href="<?= base_url('productos/'.$producto['id_producto']) ?>" class="btn btn-danger text-white col-9 rounded-pill">Ver detalles</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
