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
                        <a href="<?= base_url('usuario/mis-compras/detalle/' . $venta['id_venta']) ?>" class="btn btn-primary me-3">
                            <i class="bi bi-receipt me-2"></i> Ver detalles del pedido
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i> Volver a la tienda
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Información del Pedido</h6>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Número de pedido</th>
                                        <td>#<?= $venta['id_venta'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Fecha</th>
                                        <td><?= date('d/m/Y H:i', strtotime($venta['fecha_venta'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>€<?= number_format($venta['total'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Método de pago</th>
                                        <td><?= ucfirst($pago['metodo_pago']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Dirección de Envío</h6>
                            <address>
                                <strong><?= $direccion['nombre_destinatario'] ?></strong><br>
                                <?= $direccion['direccion'] ?><br>
                                <?= $direccion['codigo_postal'] ?>, <?= $direccion['ciudad'] ?>, <?= $direccion['provincia'] ?><br>
                                Tel: <?= $direccion['telefono_contacto'] ?>
                            </address>
                        </div>
                    </div>

                    <hr>

                    <h6>Productos</h6>
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
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('public/uploads/productos/' . $item['producto']['imagen_url']) ?>" class="img-thumbnail me-3" width="60">
                                            <div>
                                                <h6 class="mb-1"><?= $item['producto']['nombre'] ?></h6>
                                                <small class="text-muted"><?= $item['producto']['marca'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>€<?= number_format($item['precio_unitario'], 2) ?></td>
                                    <td><?= $item['cantidad'] ?></td>
                                    <td>€<?= number_format($item['subtotal'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <th colspan="3" class="text-end">Total:</th>
                                    <td>€<?= number_format($venta['total'], 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>