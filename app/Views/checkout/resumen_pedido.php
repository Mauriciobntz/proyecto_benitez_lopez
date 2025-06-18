<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
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
                                    <td>€<?= number_format($item['producto']['precio'], 2) ?></td>
                                    <td><?= $item['cantidad'] ?></td>
                                    <td>€<?= number_format($item['subtotal'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <th colspan="3" class="text-end">Total:</th>
                                    <td>€<?= number_format($total, 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <form action="<?= base_url('checkout/confirmar-resumen') ?>" method="post">
                        <button type="submit" class="btn btn-primary w-100 mt-3">Confirmar y Pagar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>