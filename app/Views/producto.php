<section class="container my-5">
    <div class="row g-4">
        <!-- Galería de imágenes -->
        <div class="col-lg-7">
            <div class="bg-light p-3 rounded-3 shadow-sm">
                <div id="productGallery" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner ratio ratio-1x1">
                        <div class="carousel-item active">
                            <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url'] ?? 'assets/img/no-image.jpg') ?>" 
                                 class="d-block w-100 object-fit-contain" 
                                 alt="<?= esc($producto['nombre']) ?>">
                        </div>
                        <!-- Puedes agregar más imágenes del producto si están disponibles -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <!-- Encabezado -->
                    <div class="border-bottom pb-3 mb-3">
                        <h1 class="h3 fw-bold mb-2"><?= esc($producto['nombre']) ?></h1>
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                <?= str_repeat('★', round($promedio)) . str_repeat('☆', 5 - round($promedio)) ?>
                            </div>
                            <small class="text-muted">(<?= $totalResenas ?> reseñas)</small>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <span class="text-success fw-bold fs-4">$<?= number_format($producto['precio'], 2) ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="badge bg-info"><?= esc($categoria['nombre'] ?? 'Sin categoría') ?></span>
                            <?php if ($producto['stock'] > 0): ?>
                                <span class="badge bg-success ms-2">Disponible</span>
                            <?php else: ?>
                                <span class="badge bg-danger ms-2">Sin stock</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Stock y marca -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1">Marca:</h6>
                                <p><?= esc($producto['marca'] ?? 'No especificada') ?></p>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Stock:</h6>
                                <p><?= $producto['stock'] ?> unidades</p>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Modelo:</h6>
                                <p><?= esc($producto['modelo'] ?? 'No especificado') ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-3">
                        <?php if ($producto['stock'] > 0): ?>
                            <button class="btn btn-dark rounded-pill py-2 fw-bold">COMPRAR AHORA</button>
                            <button class="btn btn-outline-dark rounded-pill py-2">
                                <i class="bi bi-cart-plus me-2"></i> AÑADIR AL CARRITO
                            </button>
                        <?php else: ?>
                            <button class="btn btn-secondary rounded-pill py-2 fw-bold" disabled>PRODUCTO AGOTADO</button>
                        <?php endif; ?>
                    </div>

                    <!-- Garantías -->
                    <div class="mt-3 pt-3 border-top">
                        <div class="row text-center">
                            <div class="col-6">
                                <i class="bi bi-shield-check fs-5 text-primary"></i>
                                <p class="mb-0 small">Garantía de <?= $producto['garantia_meses'] ?> meses</p>
                            </div>
                            <div class="col-6">
                                <i class="bi bi-headset fs-5 text-primary"></i>
                                <p class="mb-0 small">Soporte técnico</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción detallada -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">Descripción del producto</h2>
                    <p class="lead"><?= esc($producto['descripcion']) ?></p>
                    
                    <?php if (!empty($especificaciones)): ?>
                        <h3 class="h5 fw-bold mt-4">Especificaciones técnicas:</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                    <?php endif; ?>
                    
                    <!-- Reseñas -->
                    <h3 class="h5 fw-bold mt-4">Reseñas de clientes</h3>
                    <?php if (!empty($resenas)): ?>
                        <div class="row">
                            <?php foreach ($resenas as $resena): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div class="text-warning">
                                                    <?= str_repeat('★', $resena['calificacion']) . str_repeat('☆', 5 - $resena['calificacion']) ?>
                                                </div>
                                                <small class="text-muted"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></small>
                                            </div>
                                            <p class="mb-0"><?= esc($resena['comentario']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aún no hay reseñas para este producto.</p>
                    <?php endif; ?>
                    
                    <!-- Formulario de reseña -->
                    <?php if (session()->get('id_usuario') && !$yaReseno): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h4 class="h5 fw-bold mb-3">Deja tu reseña</h4>
                            <form action="<?= base_url('productos/' . $producto['id_producto'] . '/resena') ?>" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Calificación</label>
                                    <select name="calificacion" class="form-select" required>
                                        <option value="">Selecciona una calificación</option>
                                        <option value="5">Excelente (5 estrellas)</option>
                                        <option value="4">Muy bueno (4 estrellas)</option>
                                        <option value="3">Bueno (3 estrellas)</option>
                                        <option value="2">Regular (2 estrellas)</option>
                                        <option value="1">Malo (1 estrella)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Comentario (opcional)</label>
                                    <textarea name="comentario" class="form-control" rows="3" maxlength="500"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar reseña</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>