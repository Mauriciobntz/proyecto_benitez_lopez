<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <!-- Información de Dirección de Envío -->
                    <?php if (isset($direccion) && !empty($direccion)): ?>
                    <div class="mb-4">
                        <h6>Dirección de Envío</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php if (isset($direccion['alias'])): ?>
                                            <h6 class="mb-2"><?= esc($direccion['alias']) ?></h6>
                                        <?php endif; ?>
                                        <p class="mb-1"><?= esc($direccion['direccion']) ?></p>
                                        <p class="mb-1">
                                            <?= esc($direccion['codigo_postal']) ?>, 
                                            <?= esc($direccion['ciudad']) ?>, 
                                            <?= esc($direccion['provincia']) ?>
                                        </p>
                                        <p class="mb-0"><?= esc($direccion['pais']) ?></p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="<?= base_url('checkout/direccion') ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Cambiar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Productos -->
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
                                    <td><?= $item['producto']['nombre'] ?></td>
                                    <td>$<?= number_format($item['producto']['precio'], 2) ?></td>
                                    <td><?= $item['cantidad'] ?></td>
                                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Resumen de Costos -->
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr class="fw-bold">
                                    <td>Total:</td>
                                    <td class="text-end">$<?= number_format($total, 2) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <form action="<?= base_url('checkout/confirmar-resumen') ?>" method="post">
                        <button type="submit" class="btn btn-primary w-100 mt-3">Confirmar y Pagar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>