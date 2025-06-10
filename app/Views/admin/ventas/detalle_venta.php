<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pedido #<?= $venta['id_venta'] ?></h2>
        <div class="btn-group">
            <a href="<?= base_url('admin/ventas/factura/' . $venta['id_venta']) ?>" class="btn btn-outline-secondary" target="_blank">
                <i class="bi bi-printer"></i> Imprimir
            </a>
            <a href="<?= base_url('admin/ventas/factura/' . $venta['id_venta']) ?>" class="btn btn-outline-secondary" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Productos</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <?php if (!empty($item['imagen_url'])): ?>
                                                    <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url']) ?>" class="img-thumbnail me-3" style="width: 60px; height: 60px;">
                                                <?php else: ?>
                                                    <img src="https://via.placeholder.com/60" class="img-thumbnail me-3" style="width: 60px; height: 60px;">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1"><?= $item['nombre'] ?></h6>
                                                    <?php if (!empty($item['marca'])): ?>
                                                        <small class="text-muted">Marca: <?= $item['marca'] ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>€<?= number_format($item['precio_unitario'], 2) ?></td>
                                        <td><?= $item['cantidad'] ?></td>
                                        <td>€<?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Historial de Estado</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($historial as $evento): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><?= $evento['accion'] ?></span>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($evento['fecha'])) ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Información del Pedido</div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Estado actual</h6>
                        <?php 
                        $badgeClass = [
                            'pendiente' => 'bg-secondary',
                            'pagado' => 'bg-primary',
                            'enviado' => 'bg-info',
                            'entregado' => 'bg-success',
                            'cancelado' => 'bg-danger'
                        ];
                        ?>
                        <span class="badge <?= $badgeClass[$venta['estado']] ?>"><?= ucfirst($venta['estado']) ?></span>
                    </div>

                    <div class="mb-3">
                        <h6>Fecha del pedido</h6>
                        <p><?= date('d/m/Y H:i', strtotime($venta['fecha_venta'])) ?></p>
                    </div>

                    <div class="mb-3">
                        <h6>Método de pago</h6>
                        <p><?= ucfirst($venta['metodo_pago'] ?? 'N/A') ?></p>
                    </div>

                    <div class="mb-3">
                        <h6>Dirección de envío</h6>
                        <address>
                            <?php if (!empty($direccion)): ?>
                                <strong><?= $direccion['nombre'] ?? 'N/A' ?></strong><br>
                                <?= $direccion['direccion'] ?? 'N/A' ?><br>
                                <?= $direccion['codigo_postal'] ?? 'N/A' ?> <?= $direccion['ciudad'] ?? 'N/A' ?>, <?= $direccion['provincia'] ?? 'N/A' ?><br>
                                <?= $direccion['pais'] ?? 'N/A' ?><br>
                                Teléfono: <?= $direccion['telefono'] ?? 'N/A' ?>
                            <?php else: ?>
                                <p class="text-muted">Dirección no disponible</p>
                            <?php endif; ?>
                        </address>
                    </div>

                    <div class="mb-3">
                        <h6>Resumen de pago</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Subtotal</th>
                                <td class="text-end">€<?= number_format($venta['subtotal'] ?? $venta['total'], 2) ?></td>
                            </tr>
                            <tr>
                                <th>Envío</th>
                                <td class="text-end">€<?= number_format($venta['costo_envio'] ?? 0, 2) ?></td>
                            </tr>
                            <?php if (isset($venta['iva']) && $venta['iva'] > 0): ?>
                                <tr>
                                    <th>IVA (<?= $venta['iva'] ?>%)</th>
                                    <td class="text-end">€<?= number_format($venta['total_iva'], 2) ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="table-active">
                                <th>Total</th>
                                <td class="text-end fw-bold">€<?= number_format($venta['total'], 2) ?></td>
                            </tr>
                        </table>
                    </div>

                    <?php if ($venta['estado'] != 'cancelado'): ?>
                        <div class="mb-3">
                            <h6>Cambiar estado</h6>
                            <form action="<?= base_url('admin/ventas/actualizar-estado/' . $venta['id_venta']) ?>" method="post">
                                <?= csrf_field() ?>
                                <select class="form-select mb-2" name="nuevo_estado">
                                    <option value="">Seleccionar estado</option>
                                    <option value="pendiente" <?= $venta['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="pagado" <?= $venta['estado'] == 'pagado' ? 'selected' : '' ?>>Pagado</option>
                                    <option value="enviado" <?= $venta['estado'] == 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                    <option value="entregado" <?= $venta['estado'] == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                                    <option value="cancelado">Cancelar</option>
                                </select>
                                <button type="submit" class="btn btn-primary w-100">Actualizar estado</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>