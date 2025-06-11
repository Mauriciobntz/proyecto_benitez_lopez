<div class="container mt-4">
    <h2>Mis Reseñas</h2>

    <?php if (session()->has('message')): ?>
        <div class="alert alert-success">
            <?= session()->get('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= session()->get('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($resenas)): ?>
        <div class="alert alert-info">
            No has realizado ninguna reseña todavía.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($resenas as $resena): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <?php if (!empty($resena['imagen_url'])): ?>
                                    <img src="<?= base_url('public/' . $resena['imagen_url']) ?>" class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/80" class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                                <?php endif; ?>
                                <div>
                                    <h5 class="card-title"><?= $resena['producto_nombre'] ?></h5>
                                    <div class="text-warning mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $resena['calificacion'] ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-muted small"><?= date('d/m/Y H:i', strtotime($resena['fecha'])) ?></p>
                                </div>
                            </div>
                            <?php if (!empty($resena['comentario'])): ?>
                                <p class="card-text"><?= nl2br(htmlspecialchars($resena['comentario'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>