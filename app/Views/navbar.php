
<!-- navbar -->


<section>

<!-- Gif Promociones -->
  <div class="text-center">
    <div class="flex justify-center w-100">
      <a href="/medios-de-pago" title="Promociones financieras | EASY" rel="" class="">
        <img title="Promociones financieras | EASY" alt="Promociones financieras | EASY" class=" img-fluid" src="https://arcencohogareasy.vtexassets.com/assets/vtex.file-manager-graphql/images/a83279ef-e3cb-454f-8add-9ca30b5bfd4f___6f44803169ce30a8d9dab97e27741824.gif" loading="lazy" fetchpriority="auto" crossorigin="anonymous">
      </a>
    </div>
  </div>
<!-- Fin Gif -->


  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <!-- Main Navbar Toggle Button (para abrir el offcanvas en pantallas pequeÃ±as) -->
      <button class="btn btn-light rounded-pill d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Brand (centrado en todo momento, con flexbox) -->
      <a class="navbar-brand text-white mx-auto" href="<?php echo base_url('principal'); ?>" style="flex-grow: 1; text-align: center;">
        <b>FOLLOW</b>
      </a>

    <ul class="navbar-nav mx-auto d-none d-lg-flex">
      <!-- Enlaces del proyecto 1 -->
      <li class="nav-item">
        <a class="nav-link text-white fw-bold" href="<?php echo base_url('principal'); ?>">Principal</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white fw-bold" href="<?php echo base_url('productos'); ?>">Productos</a>
      </li>      <li class="nav-item">
        <a class="nav-link text-white fw-bold" href="<?php echo base_url('somos'); ?>">Quienes Somos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white fw-bold" href="<?php echo base_url('comercializacion'); ?>">Comercializacion</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white fw-bold" href="<?php echo base_url('contacto'); ?>">Contacto</a>
      </li>
    </ul>

      <!-- Search Toggle Button navbar-toggler  -->
      <button class="btn btn-light rounded-pill d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
        <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg></span>
      </button>

      <!-- Search Form -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarSearch">
        <form class="d-flex" role="search">
          <input class="form-control me-2 rounded-pill" type="search" placeholder="Buscar" aria-label="search">
          <button class="btn btn-light me-2 rounded-pill" type="submit">Buscar</button>
        </form>
      </div>

      <div class="d-none d-lg-block">

        
    <!-- Botón para abrir el offcanvas -->
    <button class="btn btn-light rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" aria-label="Toggle carrito">
        <img src="<?php echo base_url('assets/img/carrito.svg'); ?>" alt="">
    </button>

        <a href="<?php echo base_url('login'); ?>" class="btn btn-light rounded-pill"><img src="<?php echo base_url('assets/img/person.svg'); ?>" alt=""></a>

      </div>
      
    </div>

  </nav>


  <!-- Offcanvas (solo visible en pantallas pequeÃ±as) -->
  <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="staticBackdropLabel">Menu Lateral</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo base_url('principal'); ?>">Principal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('productos'); ?>">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('somos'); ?>">Quienes Somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('comercializacion'); ?>">Comercializacion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('contacto'); ?>">Contacto</a>
        </li>
      </ul>
    </div>
  </div>


  <div class="offcanvas offcanvas-end" data-bs-backdrop="static" id="offcanvasRight" tabindex="-1" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Carrito de Compras</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column align-items-center" style="overflow-x: hidden;">
    
    <!-- Producto -->
    <div class="card mb-3 w-100 overflow-hidden" style="max-height: 120px;">
      <div class="row g-0 align-items-center">
        <div class="col-4">
          <img src="<?php echo base_url('assets/img/zapatilla.jpg'); ?>" class="img-fluid rounded-start d-block" alt="Nombre del producto">
        </div>
        <div class="col-8">
          <div class="card-body p-2">
            <h6 class="card-title mb-1">Nombre del Producto</h6>
            <p class="card-text mb-2">
              <small class="text-muted">Precio: $1.500</small>
            </p>
            <div class="d-flex align-items-center justify-content-between">
              <!-- Controles de cantidad -->
              <div class="btn-group" role="group" aria-label="Cantidad">
                <button type="button" class="btn btn-outline-dark btn-sm">−</button>
                <span class="px-2">2</span>
                <button type="button" class="btn btn-outline-dark btn-sm">+</button>
              </div>
              <!-- Botón de borrar -->
              <button type="button" class="btn btn-outline-danger btn-sm">
                <img src="<?php echo base_url('assets/img/delete.svg'); ?>" alt="Eliminar">
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Espaciador para empujar el total abajo -->
    <div class="flex-grow-1"></div>

    <!-- Total y botón de compra -->
    <div class="mt-auto w-100 border-top pt-3">
      <div class="d-flex justify-content-between align-items-center px-2">
        <strong>Total:</strong>
        <span>$3.000</span>
      </div>
      <div class="d-grid gap-2 px-2 mt-3">
        <button type="button" class="btn btn-dark">Finalizar compra</button>
      </div>
    </div>

  </div>
</div>


    </div>
  </nav>

