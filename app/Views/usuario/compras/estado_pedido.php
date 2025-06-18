<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Seguimiento del Pedido #<?= $pedido['id_venta'] ?></h4>
                        <span class="badge bg-<?= $badgeClass[strtolower($pedido['estado'])] ?>">
                            <?= ucfirst($pedido['estado']) ?>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Resumen del Pedido</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-end">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detalles as $detalle): ?>
                                        <tr>
                                            <td><?= esc($detalle['nombre']) ?></td>
                                            <td class="text-end">$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                                            <td class="text-center"><?= $detalle['cantidad'] ?></td>
                                            <td class="text-end">$<?= number_format($detalle['subtotal'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-end">$<?= number_format($pedido['total'], 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Estado del Envío</h5>
                    <div class="timeline">
                        <?php foreach ($estados as $estado): ?>
                            <div class="timeline-step <?= $estado['clase'] ?>">
                                <div class="timeline-icon">
                                    <i class="bi <?= $estado['icono'] ?>"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6><?= esc($estado['titulo']) ?></h6>
                                    <p class="mb-0 text-muted"><?= $estado['fecha'] ?></p>
                                    <p class="mb-0"><?= esc($estado['descripcion']) ?></p>
                                    <?php if (isset($estado['codigo_seguimiento'])): ?>
                                        <p class="mb-0"><strong>N° de Seguimiento:</strong> <?= esc($estado['codigo_seguimiento']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Información de Envío</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Dirección de Envío</h6>
                                        <p class="mb-1"><?= esc($direccion['alias']) ?></p>
                                        <p class="mb-1"><?= esc($direccion['direccion']) ?></p>
                                        <p class="mb-1"><?= esc($direccion['ciudad']) ?>, <?= esc($direccion['provincia']) ?> <?= esc($direccion['codigo_postal']) ?></p>
                                        <p class="mb-1"><?= esc($direccion['pais']) ?></p>
                                        <p class="mb-0">Teléfono: <?= esc($direccion['telefono']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Transportista</h6>
                                        <p class="mb-1"><strong><?= esc($pedido['transportista']) ?></strong></p>
                                        <?php if (isset($pedido['codigo_seguimiento'])): ?>
                                            <p class="mb-1">N° Seguimiento: <?= esc($pedido['codigo_seguimiento']) ?></p>
                                            <p class="mb-0">
                                                <a href="<?= esc($pedido['url_seguimiento']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    Rastrear Envío
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="<?= base_url('perfil/pedidos/' . $pedido['id_venta']) ?>" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Volver al Detalle
                        </a>
                        <a href="<?= base_url('perfil/factura/' . $pedido['id_venta']) ?>" class="btn btn-primary">
                            <i class="bi bi-file-earmark-text"></i> Ver Factura
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 3rem;
        margin: 0 0 0 1rem;
    }
    .timeline:before {
        content: '';
        position: absolute;
        left: 1.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    .timeline-step {
        position: relative;
        padding-bottom: 2rem;
    }
    .timeline-step:last-child {
        padding-bottom: 0;
    }
    .timeline-icon {
        position: absolute;
        left: -3rem;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .timeline-content {
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
    }
    .completed .timeline-icon {
        background-color: #198754;
    }
    .active .timeline-icon {
        background-color: #0d6efd;
    }
    .pending .timeline-icon {
        background-color: #6c757d;
    }
</style> 