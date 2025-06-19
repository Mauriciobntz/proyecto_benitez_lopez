<section class="container my-5">
    <div class="row g-4">
        <!-- Galería de imágenes mejorada -->
        <div class="col-lg-7">
            <div class="bg-light p-3 rounded-3 shadow-sm position-relative">
                <!-- Badge de oferta o destacado -->
                <?php if($producto['ventas_totales'] > 50): ?>
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                        ¡Popular! <span class="visually-hidden">Producto popular</span>
                    </span>
                <?php endif; ?>
                
                <div id="productGallery" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner ratio ratio-1x1">
                        <div class="carousel-item active">
                            <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url'] ?? 'assets/img/no-image.jpg') ?>" 
                                 class="d-block w-100 object-fit-contain" 
                                 alt="<?= esc($producto['nombre']) ?>"
                                 loading="lazy">
                        </div>
                    </div>
                    <div class="carousel-indicators position-static mt-2">
                        <button type="button" data-bs-target="#productGallery" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Información del producto mejorada -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <!-- Encabezado -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="h3 fw-bold mb-2"><?= esc($producto['nombre']) ?></h1>
                                <p class="text-muted mb-2"><?= esc($producto['marca'] ?? 'Marca no especificada') ?></p>
                            </div>
                            <?php if($producto['stock'] > 0 && $producto['stock'] < 10): ?>
                                <span class="badge bg-warning text-dark">¡Últimas unidades!</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                <?= str_repeat('★', round($promedio)) . str_repeat('☆', 5 - round($promedio)) ?>
                            </div>
                            <small class="text-muted">
                                <?= $totalResenas ?> <?= $totalResenas == 1 ? 'reseña' : 'reseñas' ?>
                                <?php if($totalResenas > 0): ?>
                                    | <a href="#reseñas" class="text-decoration-none">Ver todas</a>
                                <?php endif; ?>
                            </small>
                        </div>
                        
                        <div class="d-flex align-items-baseline">
                            <span class="text-success fw-bold fs-4">$<?= number_format($producto['precio'], 2, ',', '.') ?></span>
                            <?php if(isset($producto['precio_anterior']) && $producto['precio_anterior'] > $producto['precio']): ?>
                                <span class="text-decoration-line-through text-muted ms-2">$<?= number_format($producto['precio_anterior'], 2, ',', '.') ?></span>
                                <span class="badge bg-danger ms-2"><?= round(100 - ($producto['precio'] / $producto['precio_anterior'] * 100)) ?>% OFF</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-2">
                            <span class="badge bg-info"><?= esc($categoria['nombre'] ?? 'Sin categoría') ?></span>
                            <?php if ($producto['stock'] > 0): ?>
                                <span class="badge bg-success ms-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Disponible
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger ms-2">
                                    <i class="bi bi-x-circle-fill me-1"></i> Sin stock
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Stock y detalles -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-2 bg-light rounded">
                                    <h6 class="fw-bold mb-1 small text-muted">Stock:</h6>
                                    <p class="mb-0 fw-bold"><?= $producto['stock'] ?> unidades</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded">
                                    <h6 class="fw-bold mb-1 small text-muted">Vendidos:</h6>
                                    <p class="mb-0 fw-bold"><?= $producto['ventas_totales'] ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded">
                                    <h6 class="fw-bold mb-1 small text-muted">Modelo:</h6>
                                    <p class="mb-0"><?= esc($producto['modelo'] ?? 'No especificado') ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded">
                                    <h6 class="fw-bold mb-1 small text-muted">Garantía:</h6>
                                    <p class="mb-0"><?= $producto['garantia_meses'] ?> meses</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción mejorados -->
                    <div class="d-grid gap-3">
                        <?php if ($producto['stock'] > 0): ?>
                            <!-- Selector de cantidad mejorado -->
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" id="decrement">-</button>
                                <input type="number" name="cantidad" id="cantidad" class="form-control text-center" 
                                       value="1" min="1" max="<?= $producto['stock'] ?>">
                                <button class="btn btn-outline-secondary" type="button" id="increment">+</button>
                            </div>
                            
                            <!-- Botón de carrito mejorado -->
                            <form action="<?= base_url('carrito/agregar/'.$producto['id_producto']) ?>" method="post">
                                <input type="hidden" name="cantidad" id="cantidad-carrito" value="1">
                                <button type="submit" class="btn btn-outline-dark rounded-pill py-2 w-100">
                                    <i class="bi bi-cart-plus me-2"></i> AÑADIR AL CARRITO
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Formulario de aviso cuando no hay stock -->
                            <button class="btn btn-danger rounded-pill py-2 w-100" disabled>
                                <i class="bi bi-x-circle me-2"></i> PRODUCTO AGOTADO
                            </button>
                            <form action="<?= base_url('productos/aviso-stock/'.$producto['id_producto']) ?>" method="post">
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" placeholder="Avísame cuando esté disponible">
                                    <button class="btn btn-outline-secondary" type="submit">Notificar</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción y especificaciones mejoradas -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Sección de Descripción -->
                    <div class="mb-5">
                        <h2 class="h4 fw-bold mb-3">Acerca de este producto</h2>
                        <div class="lead"><?= nl2br(esc($producto['descripcion'])) ?></div>
                        
                        <?php if(!empty($producto['caracteristicas_destacadas'])): ?>
                            <div class="mt-4">
                                <h3 class="h5 fw-bold">Características destacadas</h3>
                                <ul class="list-unstyled">
                                    <?php foreach(explode("\n", $producto['caracteristicas_destacadas']) as $caracteristica): ?>
                                        <?php if(trim($caracteristica)): ?>
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i><?= esc(trim($caracteristica)) ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Sección de Especificaciones -->
                    <div class="mb-5">
                        <h2 class="h4 fw-bold mb-3">Detalles técnicos</h2>
                        <?php if (!empty($especificaciones)): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($especificaciones as $key => $value): ?>
                                            <tr>
                                                <th scope="row" class="w-25"><?= esc($key) ?></th>
                                                <td><?= esc($value) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if ($producto['peso_kg']): ?>
                                            <tr>
                                                <th scope="row">Peso</th>
                                                <td><?= $producto['peso_kg'] ?> kg</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($producto['dimensiones']): ?>
                                            <tr>
                                                <th scope="row">Dimensiones</th>
                                                <td><?= esc($producto['dimensiones']) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No hay especificaciones técnicas disponibles para este producto.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Sección de Reseñas (solo visualización) -->
                    <div id="reseñas">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h4 fw-bold mb-0">Opiniones de clientes</h2>
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-2">
                                    <?= str_repeat('★', round($promedio)) . str_repeat('☆', 5 - round($promedio)) ?>
                                </div>
                                <span class="fw-bold"><?= number_format($promedio, 1) ?> de 5</span>
                            </div>
                        </div>
                        
                        <?php if (!empty($resenas)): ?>
                            <div class="row g-3">
                                <?php foreach ($resenas as $resena): ?>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <span class="fw-bold"><?= esc($resena['usuario_nombre'] ?? 'Anónimo') ?></span>
                                                        <div class="text-warning small">
                                                            <?= str_repeat('★', $resena['calificacion']) . str_repeat('☆', 5 - $resena['calificacion']) ?>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></small>
                                                </div>
                                                <?php if(!empty($resena['comentario'])): ?>
                                                    <p class="mb-0"><?= esc($resena['comentario']) ?></p>
                                                <?php else: ?>
                                                    <p class="text-muted fst-italic mb-0">El cliente no dejó comentario adicional</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-chat-square-text fs-1 text-muted"></i>
                                <p class="mt-3 text-muted">Aún no hay reseñas para este producto.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript para manejar la cantidad -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cantidadInput = document.getElementById('cantidad');
    const incrementBtn = document.getElementById('increment');
    const decrementBtn = document.getElementById('decrement');
    const maxStock = <?= $producto['stock'] ?>;
    
    // Actualizar inputs ocultos de los formularios
    function updateHiddenInputs() {
        document.getElementById('cantidad-carrito').value = cantidadInput.value;
        document.getElementById('cantidad-checkout').value = cantidadInput.value;
    }
    
    incrementBtn.addEventListener('click', function() {
        let value = parseInt(cantidadInput.value);
        if (value < maxStock) {
            cantidadInput.value = value + 1;
            updateHiddenInputs();
        }
    });
    
    decrementBtn.addEventListener('click', function() {
        let value = parseInt(cantidadInput.value);
        if (value > 1) {
            cantidadInput.value = value - 1;
            updateHiddenInputs();
        }
    });
    
    cantidadInput.addEventListener('change', function() {
        let value = parseInt(this.value);
        if (isNaN(value) || value < 1) {
            this.value = 1;
        } else if (value > maxStock) {
            this.value = maxStock;
        }
        updateHiddenInputs();
    });
    
    // Inicializar los valores ocultos
    updateHiddenInputs();
});
</script>