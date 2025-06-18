<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Reseñas</h2>

            <?php if (session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($resenas) && empty($productosSinResena)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No has realizado ninguna reseña todavía.
                </div>
            <?php else: ?>
                <!-- Productos comprados que puedes reseñar -->
                <?php if (!empty($productosSinResena)): ?>
                    <div class="mb-5">
                        <h4 class="mb-3">Productos pendientes de reseñar</h4>
                        <div class="row">
                            <?php foreach ($productosSinResena as $producto): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($producto['nombre']) ?></h5>
                                            <?php if (!empty($producto['imagen_url'])): ?>
                                                <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url']) ?>" 
                                                     class="img-thumbnail mb-2" 
                                                     style="max-height: 100px;">
                                            <?php endif; ?>
                                            <p class="text-muted small">
                                                Comprado el <?= date('d/m/Y', strtotime($producto['fecha_compra'])) ?>
                                            </p>
                                            <a href="<?= base_url('perfil/resenas/agregar/'.$producto['id_producto']) ?>" 
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-star"></i> Reseñar producto
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reseñas existentes -->
                <?php if (!empty($resenas)): ?>
                    <h4 class="mb-3">Mis reseñas</h4>
                    <div class="row">
                        <?php foreach ($resenas as $resena): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title mb-1"><?= esc($resena['nombre_producto'] ?? 'Producto desconocido') ?></h5>
                                                <div class="text-warning mb-2">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="bi bi-star<?= $i <= $resena['calificacion'] ? '-fill' : '' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                <?= date('d/m/Y', strtotime($resena['fecha'])) ?>
                                            </small>
                                        </div>
                                        
                                        <p class="card-text"><?= esc($resena['comentario']) ?></p>
                                        
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?= base_url('perfil/resenas/editar/'.$resena['id_resena']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <a href="<?= base_url('perfil/resenas/eliminar/'.$resena['id_resena']) ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('¿Estás seguro de eliminar esta reseña?')">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>