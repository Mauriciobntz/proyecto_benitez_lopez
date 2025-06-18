<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="icon-success mb-3">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="mb-3">¡Pedido Confirmado!</h2>
                        <p class="lead">Gracias por tu compra. Tu pedido ha sido recibido y está siendo procesado.</p>
                        <p class="text-muted">Número de pedido: <strong>#<?= $venta['id_venta'] ?></strong></p>
                        <?php if (isset($pago) && isset($pago['metodo_pago'])): ?>
                            <p class="mb-1">Método de Pago: <strong><?= esc(ucfirst(strtolower($pago['metodo_pago'])) ?? 'No especificado') ?></strong></p>
                            <p class="mb-1">Estado del Pago: <strong><?= ucfirst($pago['estado'] ?? 'No especificado') ?></strong></p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="text-center mx-4">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 60px; height: 60px;">
                                <i class="bi bi-envelope text-primary fs-4"></i>
                            </div>
                            <small>Recibirás un correo de confirmación</small>
                        </div>
                        <div class="text-center mx-4">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 60px; height: 60px;">
                                <i class="bi bi-clock text-primary fs-4"></i>
                            </div>
                            <small>Entrega estimada: 2-3 días</small>
                        </div>
                        <div class="text-center mx-4">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 60px; height: 60px;">
                                <i class="bi bi-credit-card text-primary fs-4"></i>
                            </div>
                            <small>Pago recibido</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="<?= base_url('perfil/pedidos/' . $venta['id_venta']) ?>" class="btn btn-primary me-3">
                            <i class="bi bi-receipt me-2"></i> Ver detalles del pedido
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i> Volver a la tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>