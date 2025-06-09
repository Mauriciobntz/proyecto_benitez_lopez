<!-- ==================== Promos (solo para no administradores) ==================== -->
<?php if (!session('logged_in') || (session('logged_in') && session('rol') !== 'admin')): ?>
<header class="header">
  <div class="text-center">
    <div class="flex justify-center w-100">
      <a href="<?= base_url('comercializacion'); ?>" title="Promociones financieras | EASY" rel="" class="">
        <img title="Promociones financieras" alt="Promociones financieras | EASY" class="img-fluid" src="https://arcencohogareasy.vtexassets.com/assets/vtex.file-manager-graphql/images/a83279ef-e3cb-454f-8add-9ca30b5bfd4f___6f44803169ce30a8d9dab97e27741824.gif" loading="lazy">
      </a>
    </div>
  </div>
</header>
<?php endif; ?>

<!-- ==================== NAVBAR PRINCIPAL ==================== -->
<nav class="navbar navbar-expand-lg <?= (session('logged_in') && session('rol') === 'admin' ? 'navbar-dark bg-dark' : 'bg-dark') ?>">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <!-- Botón menú mobile -->
    <button class="btn btn-light rounded-pill d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Logo -->
    <a class="navbar-brand text-white mx-auto" href="<?= base_url('principal'); ?>" style="flex-grow: 1; text-align: center;">
      <b>FOLLOW</b>
    </a>

    <!-- Menú principal -->
    <?php if (session('logged_in') && session('rol') === 'admin'): ?>
      <!-- Menú para administrador -->
      <ul class="navbar-nav mx-auto d-none d-lg-flex">
        <li class="nav-item">
          <a class="nav-link text-white" href="<?= base_url('panel') ?>">
            <i class="bi bi-speedometer2 me-1"></i> Panel
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white" href="<?= base_url('productos/crear') ?>">
            <i class="bi bi-box me-1"></i> Productos
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white" href="<?= base_url('') ?>">
            <i class="bi bi-card-list me-1"></i> Categorías
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white" href="<?= base_url('admin/ventas') ?>">
            <i class="bi bi-bag-check me-1"></i> Ventas
          </a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="configDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-gear me-1"></i> Configuración
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item text-white" href="<?= base_url('admin/usuarios') ?>"><i class="bi bi-person-badge me-2"></i> Carrusel</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('admin/usuarios') ?>"><i class="bi bi-person-badge me-2"></i> GIF Promociones</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('admin/usuarios') ?>"><i class="bi bi-person-badge me-2"></i> Nuevos Ingresos</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('admin/usuarios') ?>"><i class="bi bi-person-badge me-2"></i> Cinta Promociones</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('admin/usuarios') ?>"><i class="bi bi-person-badge me-2"></i> Cinta Marcas</a></li>
            <li><a class="dropdown-item text-white" href="<?= base_url('admin/config') ?>"><i class="bi bi-gear me-2"></i> Configuración Tienda</a></li>
          </ul>
        </li>
      </ul>
    <?php else: ?>
      <!-- Menú para clientes (logueados o no) -->
      <ul class="navbar-nav mx-auto d-none d-lg-flex">
        <li class="nav-item dropdown">
          <a class="nav-link text-white fw-bold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Productos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('productos'); ?>">Todos</a></li>
            <li><a class="dropdown-item" href="<?= base_url('celulares'); ?>">Celulares</a></li>
            <li><a class="dropdown-item" href="<?= base_url('notebooks'); ?>">Notebooks</a></li>
            <li><a class="dropdown-item" href="<?= base_url('tablets'); ?>">Tablets</a></li>
            <li><a class="dropdown-item" href="<?= base_url('auriculares'); ?>">Auriculares</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="<?= base_url('somos'); ?>">Quienes Somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="<?= base_url('comercializacion'); ?>">Comercializacion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-bold" href="<?= base_url('contacto'); ?>">Contacto</a>
        </li>
      </ul>
    <?php endif; ?>

    <!-- Buscador (solo para no administradores) -->
    <?php if (!session('logged_in') || (session('logged_in') && session('rol') !== 'admin')): ?>
      <button class="btn btn-light rounded-pill d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch">
        <i class="fas fa-search"></i>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarSearch">
        <form class="d-flex" role="search">
          <input class="form-control me-2 rounded-pill" type="search" placeholder="Buscar">
          <button class="btn btn-light me-2 rounded-pill" type="submit">Buscar</button>
        </form>
      </div>
    <?php endif; ?>

    <!-- Iconos derecha -->
    <div class="d-none d-lg-block">
      <?php if (!session('logged_in') || (session('logged_in') && session('rol') !== 'admin')): ?>
        <!-- Carrito solo para no administradores -->
        <button class="btn btn-light rounded-pill me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
          <i class="fas fa-shopping-cart"></i>
        </button>
      <?php else: ?>
        <!-- Notificaciones solo para admin -->
        <a class="btn btn-light rounded-pill position-relative me-2" href="<?= base_url('admin/consultas') ?>">
          <i class="bi bi-bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </a>
      <?php endif; ?>
      
      <?php if (session('logged_in')): ?>
        <!-- Usuario logueado - Mostrar menú dropdown -->
        <div class="btn-group">
          <button type="button" class="btn btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user"></i> <?= esc(session('username') ?? 'Usuario') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <?php if (session('rol') === 'admin'): ?>
              <!-- Opciones para administrador -->
            <?php else: ?>
              <!-- Opciones para clientes -->
              <li><a class="dropdown-item" href="<?= base_url('perfil') ?>"><i class="fas fa-user-circle me-2"></i>Mi Perfil</a></li>
              <li><a class="dropdown-item" href="<?= base_url('mis-pedidos') ?>"><i class="fas fa-box-open me-2"></i>Mis Pedidos</a></li>
              <li><hr class="dropdown-divider"></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
          </ul>
        </div>
      <?php else: ?>
        <!-- Usuario no logueado - Mostrar botón de login -->
        <a href="<?= base_url('login') ?>" class="btn btn-light rounded-pill">
          <i class="fas fa-user"></i> Iniciar Sesión
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Menú offcanvas mobile -->
<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu Lateral</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php if (session('logged_in') && session('rol') === 'admin'): ?>
        <!-- Menú mobile para admin -->
        <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('admin/dashboard') ?>">
            <i class="bi bi-speedometer2 me-2"></i>Principal
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/productos') ?>">
            <i class="bi bi-box me-2"></i>Productos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/categorias') ?>">
            <i class="bi bi-card-list me-2"></i>Categorías
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/ventas') ?>">
            <i class="bi bi-bag-check me-2"></i>Ventas
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-gear me-2"></i>Configuración
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('admin/config') ?>">Configuración</a></li>
            <li><a class="dropdown-item" href="<?= base_url('admin/usuarios') ?>">Administradores</a></li>
          </ul>
        </li>
      <?php else: ?>
        <!-- Menú mobile para clientes (logueados o no) -->
        <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('principal'); ?>">Principal</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Productos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('productos'); ?>">Todos</a></li>
            <li><a class="dropdown-item" href="<?= base_url('celulares'); ?>">Celulares</a></li>
            <li><a class="dropdown-item" href="<?= base_url('notebooks'); ?>">Notebooks</a></li>
            <li><a class="dropdown-item" href="<?= base_url('tablets'); ?>">Tablets</a></li>
            <li><a class="dropdown-item" href="<?= base_url('auriculares'); ?>">Auriculares</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('somos'); ?>">Quienes Somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('comercializacion'); ?>">Comercializacion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('contacto'); ?>">Contacto</a>
        </li>
      <?php endif; ?>
      
      <!-- Sección de usuario en mobile -->
      <?php if (session('logged_in')): ?>
        <li class="nav-item mt-3 border-top pt-2">
          <a class="nav-link" href="<?= base_url(session('rol') === 'admin' ? 'admin/perfil' : 'perfil') ?>">
            <i class="fas fa-user-circle me-2"></i>Mi Perfil
          </a>
        </li>
        <?php if (session('rol') === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>">
              <i class="fas fa-cog me-2"></i>Panel Admin
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('mis-pedidos') ?>">
              <i class="fas fa-box-open me-2"></i>Mis Pedidos
            </a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
          </a>
        </li>
      <?php else: ?>
        <li class="nav-item mt-3 border-top pt-2">
          <a class="nav-link" href="<?= base_url('login') ?>">
            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('registro') ?>">
            <i class="fas fa-user-plus me-2"></i>Registrarse
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<!-- Carrito offcanvas (solo para no administradores) -->
<?php if (!session('logged_in') || (session('logged_in') && session('rol') !== 'admin')): ?>
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" id="offcanvasRight">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Carrito de Compras</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column align-items-center" style="overflow-x: hidden;">
    <?php if (session('logged_in')): ?>
      <!-- Carrito para usuarios logueados -->
      <div class="card mb-3 w-100 overflow-hidden" style="max-height: 120px;">
        <div class="row g-0 align-items-center">
          <div class="col-4">
            <img src="<?= base_url('assets/img/zapatilla.jpg') ?>" class="img-fluid rounded-start d-block" alt="Producto">
          </div>
          <div class="col-8">
            <div class="card-body p-2">
              <h6 class="card-title mb-1">Nombre del Producto</h6>
              <p class="card-text mb-2">
                <small class="text-muted">Precio: $1.500</small>
              </p>
              <div class="d-flex align-items-center justify-content-between">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-outline-dark btn-sm">−</button>
                  <span class="px-2">2</span>
                  <button type="button" class="btn btn-outline-dark btn-sm">+</button>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex-grow-1"></div>
      <div class="mt-auto w-100 border-top pt-3">
        <div class="d-flex justify-content-between align-items-center px-2">
          <strong>Total:</strong>
          <span>$3.000</span>
        </div>
        <div class="d-grid gap-2 px-2 mt-3">
          <button type="button" class="btn btn-dark">Finalizar compra</button>
        </div>
      </div>
    <?php else: ?>
      <!-- Mensaje para usuarios no logueados -->
      <div class="text-center py-4">
        <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
        <h5>Tu carrito está vacío</h5>
        <p class="text-muted">Inicia sesión para ver los productos en tu carrito</p>
        <a href="<?= base_url('login') ?>" class="btn btn-dark mt-2">Iniciar Sesión</a>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<?php if (session('message_welcome')): ?>
  <div class="alert alert-success">
    <?= esc(session('message_welcome')) ?>
  </div>
  <?php session()->remove('message_welcome'); ?>
<?php endif; ?>