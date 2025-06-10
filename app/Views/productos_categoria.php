<?php
// Vista para mostrar productos por categoría
// Espera recibir: $productos, $categoria, $categorias
?>

<div class="container-fluid p-0">
  <!-- banner -->
  <div class="banner" style="background-image: url('assets/img/banners.png'); background-size: cover; background-position: center; height: 310px;">
    <div class="d-flex h-100 align-items-center justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
      <h1 class="text-white text-center"><?= htmlspecialchars($categoria['nombre'] ?? 'Categoría') ?></h1>
    </div>
  </div>
  
  <section class="container-fluid mt-5">
    <div class="row">
      <!-- Menú lateral -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar mt-5">
        <!-- Título con botón hamburguesa para móviles -->
        <div class="d-flex align-items-center mb-3 d-md-none">
          <button class="btn p-0 me-2 border-0 d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#menuCategorias" aria-expanded="false" aria-controls="menuCategorias">
            <i class="bi bi-list fs-2"></i>
            <h5 class="m-0 ms-2">Categorías</h5>
          </button>
        </div>

        <!-- Título normal para desktop -->
        <h5 class="mb-3 d-none d-md-block">Categorías</h5>

        <!-- Contenido colapsable -->
        <div class="collapse d-md-block" id="menuCategorias">
          <div class="d-flex flex-column w-100 gap-2">
            <a href="<?= base_url('productos') ?>" class="btn btn-outline-dark w-100 text-start py-2">Todos los productos</a>
            <?php if(isset($categorias) && is_array($categorias)): ?>
              <?php foreach($categorias as $cat): ?>
                <a href="<?= base_url('productos/categoria/'.$cat['id_categoria']) ?>" class="btn btn-outline-dark w-100 text-start py-2 <?= ($cat['id_categoria'] == ($categoria['id_categoria'] ?? null)) ? 'active' : '' ?>">
                  <?= htmlspecialchars($cat['nombre']) ?>
                </a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- Ordenar productos -->
        <div class="mt-4">
          <label for="ordenar" class="form-label fw-bold">Ordenado por:</label>
          <select id="ordenar" class="form-select" onchange="ordenarProductos(this.value)">
            <option value="destacado">Más vendidos</option>
            <option value="menor_precio">Menor precio</option>
            <option value="mayor_precio">Mayor precio</option>
            <option value="a_z">Nombre a-z</option>
            <option value="z_a">Nombre z-a</option>
          </select>
        </div>
      </nav>

      <!-- Sección principal de productos -->
      <main class="col-md-9 col-lg-10 mt-4">
        <?php if(empty($productos)): ?>
          <div class="alert alert-info">
            No se encontraron productos en esta categoría.
          </div>
        <?php else: ?>
          <div class="mb-4">
            <h2><?= htmlspecialchars($categoria['nombre'] ?? 'Categoría') ?></h2>
            <p><?= htmlspecialchars($categoria['descripcion'] ?? '') ?></p>
          </div>
          
          <div class="row g-4" id="productos-container">
            <?php foreach ($productos as $producto): ?>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card">
                  <a href="<?= base_url('productos/'.$producto['id_producto']) ?>">
                    <?php if(!empty($producto['imagen_url'])): ?>
                      <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    <?php else: ?>
                      <img src="<?= base_url('assets/img/placeholder.png') ?>" class="card-img-top" alt="Imagen no disponible">
                    <?php endif; ?>
                  </a>
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                    <p class="card-text">
                      <?= !empty($producto['marca']) ? htmlspecialchars($producto['marca']) : '' ?> 
                      <?= !empty($producto['modelo']) ? htmlspecialchars($producto['modelo']) : '' ?>
                    </p>
                    <p class="fw-bold mt-auto"><?= number_format($producto['precio'], 2) ?> €</p>
                    <div class="row mt-2">
                      <a href="<?= base_url('productos/'.$producto['id_producto']) ?>" class="btn btn-outline-dark col-9 rounded-pill">Ver detalles</a>
                      <a href="#" class="btn btn-outline-success col-3 rounded-pill">
                        <img src="<?= base_url('assets/img/carrito.svg') ?>" alt="carrito">
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </main>
    </div>
  </section>
</div>

<script>
function ordenarProductos(criterio) {
  const container = document.getElementById('productos-container');
  if (!container) return;
  
  const productos = Array.from(container.children);
  
  productos.sort((a, b) => {
    const precioA = parseFloat(a.querySelector('.fw-bold').textContent.replace(' €', '').replace(',', ''));
    const precioB = parseFloat(b.querySelector('.fw-bold').textContent.replace(' €', '').replace(',', ''));
    const nombreA = a.querySelector('.card-title').textContent.toLowerCase();
    const nombreB = b.querySelector('.card-title').textContent.toLowerCase();
    
    switch(criterio) {
      case 'menor_precio':
        return precioA - precioB;
      case 'mayor_precio':
        return precioB - precioA;
      case 'a_z':
        return nombreA.localeCompare(nombreB);
      case 'z_a':
        return nombreB.localeCompare(nombreA);
      default:
        return 0; // Mantener orden original para "destacado"
    }
  });
  
  container.innerHTML = '';
  productos.forEach(producto => container.appendChild(producto));
}
</script>