<?php

$masVendidos = [
    [
        "id" => 1,
        "nombre" => "Xiaomi 14T",
        "descripcion" => "512GB RAM | Color: Black",
        "precio" => "$750",
        "img" => "xiaomi14t.png",
        "categoria" => "celulares",
        "marca" => "Xiaomi"
    ],
    [
        "id" => 19,
        "nombre" => "Lenovo ThinkPad X1 Carbon",
        "descripcion" => "Intel Core i7 vPro | Teclado mecánico",
        "precio" => "$1500",
       "img" => "lenovo.png",
       "categoria" => "notebooks",
       "marca" => "Lenovo"
    ],
    [
        "id" => 3,
        "nombre" => "Poco X6 Pro",
        "descripcion" => "256GB RAM | Color: Yellow",
        "precio" => "$350",
        "img" => "pocox6pro.png",
        "categoria" => "celulares",
        "marca" => "Xiaomi"
    ],
    [
      "id" => 33,
      "nombre" => "Xiaomi Pad 6",
      "descripcion" => "Snapdragon 870 | Pantalla 11 2,8K",
      "precio" => "$369",
      "img" => "xiaomipad6.png",
      "categoria" => "tablets",
      "marca" => "Xiaomi"
  ],
    [
        "id" => 5,
        "nombre" => "Samsung A55 5G",
        "descripcion" => "512GB RAM | Color: White",
        "precio" => "$450",
        "img" => "a55.png",
        "categoria" => "celulares",
        "marca" => "Samsung"
    ],
    [
        "id" => 6,
        "nombre" => "Samsung S25 Ultra",
        "descripcion" => "1024GB RAM | Color: White",
        "precio" => "$1100",
        "img" => "s25ultra.png",
        "categoria" => "celulares",
        "marca" => "Samsung"
    ],
    [
        "id" => 7,
        "nombre" => "iPhone 16",
        "descripcion" => "512GB RAM | Color: Blue",
        "precio" => "$1000",
        "img" => "iphone16.png",
        "categoria" => "celulares",
        "marca" => "Apple"
    ],
    [
        "id" => 8,
        "nombre" => "iPhone 16 Pro Max",
        "descripcion" => "1024GB RAM | Color: White",
        "precio" => "$1250",
        "img" => "iphone16promax.png",
        "categoria" => "celulares",
        "marca" => "Apple"
    ]
];
?>

<div class="container-fluid p-0">
  <!-- banner -->
  <div class="banner" style="background-image: url('assets/img/banners.png'); background-size: cover; background-position: center; height: 310px;">
    <div class="d-flex h-100 align-items-center justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
      <h1 class="text-white text-center">Los mejores productos de tecnología</h1>
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
          <a href="productos" class="btn btn-outline-dark w-100 text-start py-2">Más vendidos</a>
          <a href="celulares" class="btn btn-outline-dark w-100 text-start py-2">Celulares</a>
          <a href="auriculares" class="btn btn-outline-dark w-100 text-start py-2">Auriculares</a>
          <a href="notebooks" class="btn btn-outline-dark w-100 text-start py-2">Notebooks</a>
          <a href="perifericos" class="btn btn-outline-dark w-100 text-start py-2">Perifericos</a>
          <a href="tablets" class="btn btn-outline-dark w-100 text-start py-2">Tablets</a>
          </div>
        </div>

        <!-- Ordenar productos -->
        <div class="mt-4">
          <label for="ordenar" class="form-label fw-bold">Ordenado por:</label>
          <select id="ordenar" class="form-select">
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
        <div class="row g-4" id="productos-container">
          <?php foreach ($masVendidos as $producto): ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-categoria="<?= htmlspecialchars($producto['categoria']) ?>">
            <div class="card h-100 product-card">
              <a href="producto.php?id=<?= $producto['id'] ?? '' ?>">
                <img src="assets/img/<?= htmlspecialchars($producto['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
              </a>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
                <p class="fw-bold mt-auto"><?= htmlspecialchars($producto['precio']) ?></p>
                <div class="row mt-2">
                  <a href="<?php echo base_url('producto'); ?>" class="btn btn-outline-dark col-9 rounded-pill">Comprar</a>
                  <a href="#" class="btn btn-outline-success col-3 rounded-pill">
                    <img src="assets/img/carrito.svg" alt="carrito">
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </main>
    </div>
  </section>
</div>




