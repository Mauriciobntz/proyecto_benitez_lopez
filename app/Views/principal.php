<!--
1. Página Principal
- Diseño responsive funcional, liviano, sencillo, de carga rápida y visible
óptimamente por cualquier navegador.
- Debe haber una presentación clara de la empresa y lo que ofrece. Una
introducción a cada uno de sus principales productos/servicios. Tener en
cuenta la extensión del texto y el impacto visual, seleccionar adecuadamente los
estilos CSS y el tipo de letra, respetando los colores de fondo y el contraste.
- Una barra de navegación que permita el acceso a las diferentes páginas del
sitio.
-->

<section class="mt-3">

<!--Cinta de Promos-->
    <div class="section-adbar mb-3">
        <div class="adbar-text-container js-adbar-animated">
            <span class="adbar-message">ENVÍO SAME DAY | CABA Y AMBA</span>
            <span class="adbar-message">3 Y 6 CUOTAS SIN INTERÉS</span>
            <span class="adbar-message">ENVÍO GRATIS A PARTIR DE $150.000</span>
        </div>
    </div>


<!-- Cards de Ingresos Mejoradas -->
<div class="new-arrivals py-5 bg-light">
  <div class="container">
    <div class="section-header text-center mb-5">
      <h2 class="fw-bold mb-3">NUEVOS INGRESOS</h2>
    </div>

    <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-all hover-shadow">
          <div class="product-media position-relative">
            <video class="w-100" autoplay loop muted playsinline style="height: 300px; object-fit: cover;">
              <source src="assets/img/video/GalaxyA56.mp4" type="video/mp4">
            </video>
            <div class="product-badge bg-danger text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">Nuevo</div>
          </div>
          <div class="card-body text-center pt-4 pb-3">
            <h5 class="card-title fw-semibold mb-1">Samsung Galaxy A56</h5>
            <p class="text-muted small mb-3">Pantalla Super AMOLED de 6.5"</p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-all hover-shadow">
          <div class="product-media position-relative">
            <video class="w-100" autoplay loop muted playsinline style="height: 300px; object-fit: cover;">
              <source src="assets/img/video/iphone16.mp4" type="video/mp4">
            </video>
            <div class="product-badge bg-danger text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">Nuevo</div>
          </div>
          <div class="card-body text-center pt-4 pb-3">
            <h5 class="card-title fw-semibold mb-1">iPhone 16 Pro</h5>
            <p class="text-muted small mb-3">Chip A18 Pro, 256GB</p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-all hover-shadow">
          <div class="product-media position-relative">
            <video class="w-100" autoplay loop muted playsinline style="height: 300px; object-fit: cover;">
              <source src="assets/img/video/zenbook-s16.mp4" type="video/mp4">
            </video>
            <div class="product-badge bg-danger text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">Nuevo</div>
          </div>
          <div class="card-body text-center pt-4 pb-3">
            <h5 class="card-title fw-semibold mb-1">Asus Zenbook S16</h5>
            <p class="text-muted small mb-3">Intel Core i9, 32GB RAM</p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-all hover-shadow">
          <div class="product-media position-relative">
            <video class="w-100" autoplay loop muted playsinline style="height: 300px; object-fit: cover;">
              <source src="assets/img/video/auriculares.mp4" type="video/mp4">
            </video>
            <div class="product-badge bg-danger text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">Nuevo</div>
          </div>
          <div class="card-body text-center pt-4 pb-3">
            <h5 class="card-title fw-semibold mb-1">Sony WH-1000XM5</h5>
            <p class="text-muted small mb-3">Cancelación de ruido líder</p>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>





    <!--Cards de Categorias-->
    <div class="container mb-3">
    <h3 class="section-header fw-bold text-center my-4">CATEGORIAS</h3>

    <div class="row g-3 justify-content-center">

        <div class="col-12 col-md-6">
        <div class="card shadow rounded-4 overflow-hidden border-0 position-relative hover-shadow" style="height: 250px;">
            <img src="<?php echo base_url('assets/img/celulares.png'); ?>" class="w-100 h-100" style="object-fit: cover;"></img>
            <div class="position-absolute top-50 start-50 translate-middle">
            <a href="<?php echo base_url('celulares'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fs-5">Celulares</a>
            </div>
        </div>
        </div>

        <div class="col-12 col-md-6">
        <div class="card shadow rounded-4 overflow-hidden border-0 position-relative  hover-shadow" style="height: 250px;">
        <img src="<?php echo base_url('assets/img/notebook.jpg'); ?>" class="w-100 h-100" style="object-fit: cover;"></img>
        <div class="position-absolute top-50 start-50 translate-middle">
        <a href="<?php echo base_url('notebooks'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fs-5">Notebooks</a>
            </div>
        </div>
        </div>

        <div class="col-12 col-md-6">
        <div class="card shadow rounded-4 overflow-hidden border-0 position-relative  hover-shadow" style="height: 250px;">
        <img src="<?php echo base_url('assets/img/tablet.jpg'); ?>" class="w-100 h-100" style="object-fit: cover;"></img>
            <div class="position-absolute top-50 start-50 translate-middle">
            <a href="<?php echo base_url('tablets'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fs-5">Tablets</a>
            </div>
        </div>
        </div>

        <div class="col-12 col-md-6">
        <div class="card shadow rounded-4 overflow-hidden border-0 position-relative  hover-shadow" style="height: 250px;">
            <video src="assets/img/video/auriculares.mp4" class="w-100 h-100" autoplay loop muted playsinline style="object-fit: cover;"></video>
            <div class="position-absolute top-50 start-50 translate-middle">
            <a href="<?php echo base_url('auriculares'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fs-5">Auriculares</a>
            </div>
        </div>
        </div>

    </div>
    </div>







    <!-- Sección de Marcas -->
    <div class="container my-5 py-4">
    <h3 class="text-center mb-4">Trabajamos con las mejores marcas</h3>
    <div class="d-flex flex-wrap justify-content-center align-items-center gap-5">
        <!-- Logo 1 -->
        <div class="logo-empresas">
            <img src="assets/img/samsunglogo.png" alt="Logo Marca 1" class="img-fluid" style="max-height: 60px;">
        </div>
        <!-- Logo 2 -->
        <div class="logo-empresas">
            <img src="assets/img/xiaomilogo.png" alt="Logo Marca 2" class="img-fluid" style="max-height: 60px;">
        </div>
        <!-- Logo 3 -->
        <div class="logo-empresas">
            <img src="assets/img/microsoftlogo.png" alt="Logo Marca 3" class="img-fluid" style="max-height: 60px;">
        </div>
        <!-- Logo 4 -->
        <div class="logo-empresas">
            <img src="assets/img/hyperx.png" alt="Logo Marca 4" class="img-fluid" style="max-height: 60px;">
        </div>
        <!-- Logo 5 -->
        <div class="logo-empresas">
            <img src="assets/img/apple.png" alt="Logo Marca 5" class="img-fluid" style="max-height: 60px;">
        </div>
    </div>
</div>



</section>
