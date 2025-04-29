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

    <!--Cards de Ingresos-->
    <div class="container-fluid mb-3">
    <h3 class="text-center my-4">Nuevos Ingresos</h3>

    <div class="d-flex justify-content-center flex-wrap">

        <div class="card shadow rounded-4 overflow-hidden mx-1 my-2 d-flex flex-column  hover-shadow" style="width: 20rem; height: 450px; border: none;">
        <video src="assets/img/video/GalaxyA56.mp4" class="card-img-top flex-grow-0" autoplay loop muted playsinline style="height: 300px; object-fit: cover;"></video>
        <div class="card-body text-center bg-light d-flex flex-column justify-content-center">
            <h5 class="card-title m-2">Samsung</h5>
            <p class="card-text text-muted">Galaxy A56</p>
        </div>
        </div>

        <div class="card shadow rounded-4 overflow-hidden mx-1 my-2 d-flex flex-column  hover-shadow" style="width: 20rem; height: 450px; border: none;">
        <video src="assets/img/video/iphone16.mp4" class="card-img-top flex-grow-0" autoplay loop muted playsinline style="height: 300px; object-fit: cover;"></video>
        <div class="card-body text-center bg-light d-flex flex-column justify-content-center">
            <h5 class="card-title m-2">iPhone</h5>
            <p class="card-text text-muted">16</p>
        </div>
        </div>

        <div class="card shadow rounded-4 overflow-hidden mx-1 my-2 d-flex flex-column  hover-shadow" style="width: 20rem; height: 450px; border: none;">
        <video src="assets/img/video/zenbook-s16.mp4" class="card-img-top flex-grow-0" autoplay loop muted playsinline style="height: 300px; object-fit: cover;"></video>
        <div class="card-body text-center bg-light d-flex flex-column justify-content-center">
            <h5 class="card-title m-2">Asus</h5>
            <p class="card-text text-muted">Zenbook S16</p>
        </div>
        </div>

        <div class="card shadow rounded-4 overflow-hidden mx-1 my-2 d-flex flex-column  hover-shadow" style="width: 20rem; height: 450px; border: none;">
        <video src="assets/img/video/auriculares.mp4" class="card-img-top flex-grow-0" autoplay loop muted playsinline style="height: 300px; object-fit: cover;"></video>
        <div class="card-body text-center bg-light d-flex flex-column justify-content-center">
            <h5 class="card-title m-2">Sony</h5>
            <p class="card-text text-muted">Noise Cancelling</p>
        </div>
        </div>

    </div>
    </div>


    <!--Cards de Categorias-->
    <div class="container-fluid mb-3">
    <h3 class="text-center my-4">Categorías Favoritas</h3>

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