<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Pedido #<?= $pedido['id_venta'] ?></h4>
                        <span class="badge bg-<?= $badgeClass[strtolower($pedido['estado'])] ?>">
                            <?= ucfirst($pedido['estado']) ?>
                        </span>
                    </div>
                    <p class="text-muted mb-0">Fecha: <?= date('d/m/Y', strtotime($pedido['fecha_venta'])) ?></p>
                </div>
                <div class="card-body">
                    <h5 class="mb-4">Productos</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['imagen_url'])): ?>
                                                    <img src="<?= base_url('public/uploads/productos/' . $item['imagen_url']) ?>" 
                                                         alt="<?= esc($item['nombre']) ?>" width="60" class="me-3">
                                                <?php else: ?>
                                                    <img src="https://via.placeholder.com/60" 
                                                         alt="<?= esc($item['nombre']) ?>" width="60" class="me-3">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-0"><?= esc($item['nombre']) ?></h6>
                                                    <?php if (!empty($item['marca'])): ?>
                                                        <small class="text-muted">Marca: <?= esc($item['marca']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">$<?= number_format($item['precio_unitario'], 2) ?></td>
                                        <td class="text-center"><?= $item['cantidad'] ?></td>
                                        <td class="text-end">$<?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-group-divider">
                                <?php 
                                $subtotal = array_reduce($items, function($carry, $item) {
                                    return $carry + ($item['precio_unitario'] * $item['cantidad']);
                                }, 0);
                                ?>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                                </tr>
                                <tr class="table-active">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end fw-bold">$<?= number_format($pedido['total'] ?? $subtotal, 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <h5 class="mb-3">Dirección de Envío</h5>
                            <div class="card">
                                <div class="card-body">
                                    <?php if (isset($direccion) && !empty($direccion)): ?>
                                        <?php if (isset($direccion['alias'])): ?>
                                            <h6><?= esc($direccion['alias']) ?></h6>
                                        <?php endif; ?>
                                        <p class="mb-1"><?= esc($direccion['direccion'] ?? '') ?></p>
                                        <p class="mb-1">
                                            <?= esc($direccion['ciudad'] ?? '') ?>
                                            <?= isset($direccion['provincia']) ? ', ' . esc($direccion['provincia']) : '' ?>
                                            <?= isset($direccion['codigo_postal']) ? ' ' . esc($direccion['codigo_postal']) : '' ?>
                                        </p>
                                        <p class="mb-1"><?= esc($direccion['pais'] ?? '') ?></p>
                                        <?php if (isset($direccion['telefono'])): ?>
                                            <p class="mb-0">Teléfono: <?= esc($direccion['telefono']) ?></p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">No hay información de dirección disponible</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Método de Pago</h5>
                            <div class="card">
                                <div class="card-body">
                                    <?php if (isset($pago) && isset($pago['metodo_pago'])): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-credit-card fs-4 me-3"></i>
                                            <div>
                                                <h6 class="mb-0"><?= esc(ucfirst(strtolower($pago['metodo_pago'])) ?? 'No especificado') ?></h6>
                                                <?php if (isset($pago['comprobante'])): ?>
                                                    <small class="text-muted">Terminada en ****<?= esc($pago['comprobante']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <p class="mb-2">
                                            <strong>Estado del pago:</strong> 
                                            <?= isset($pago['estado']) ? ucfirst($pago['estado']) : 'No especificado' ?>
                                        </p>
                                        <?php if (isset($pago['fecha_pago'])): ?>
                                            <p class="mb-0">
                                                <strong>Fecha de pago:</strong> 
                                                <?= date('d/m/Y H:i', strtotime($pago['fecha_pago'])) ?>
                                            </p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">No hay información de pago disponible</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <?php if ($pedido['estado'] == 'pagado' || $pedido['estado'] == 'enviado'): ?>
                            <a href="<?= base_url('perfil/factura/' . $pedido['id_venta']) ?>" class="btn btn-outline-primary me-2">
                                <i class="bi bi-file-text"></i> Descargar Factura
                            </a>
                        <?php endif; ?>
                        <?php if ($pedido['estado'] == 'enviado'): ?>
                            <a href="<?= base_url('perfil/seguimiento/' . $pedido['id_venta']) ?>" class="btn btn-outline-info me-2">
                                <i class="bi bi-truck"></i> Seguimiento
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('perfil/pedidos') ?>" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Volver a Mis Pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 