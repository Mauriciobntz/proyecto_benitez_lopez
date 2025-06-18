<!--  Categorias de Productos -->
<div class="container mb-5">
    <h2 class="section-header fw-bold text-center my-4">CATEGORÍAS</h2>

    <div class="row g-3 justify-content-center mt-3">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-12 col-md-6">
                <div class="card shadow rounded-4 overflow-hidden border-0 position-relative hover-shadow" style="height: 250px;">
                    <?php if(!empty($categoria['imagen_url'])): ?>
                        <img src="<?= base_url('public/uploads/categorias/'.$categoria['imagen_url']) ?>" 
                             class="w-100 h-100" 
                             style="object-fit: cover;"
                             alt="<?= esc($categoria['nombre']) ?>"
                             loading="lazy">
                    <?php else: ?>
                        <div class="bg-secondary w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-3x text-white"></i>
                        </div>
                    <?php endif; ?>
                                        <div class="position-absolute top-50 start-50 translate-middle">
                        <a href="<?= base_url('productos/categoria/'.esc($categoria['id_categoria'])) ?>" 
                           class="btn btn-dark rounded-pill px-4 py-2 fs-5">
                            <?= esc($categoria['nombre']) ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Fin Cards de Categorias -->
