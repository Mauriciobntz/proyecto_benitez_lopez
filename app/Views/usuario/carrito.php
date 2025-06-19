<?php if (session()->getFlashdata('message')): ?>
    <div class="container mt-3">
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="container mt-3">
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            Tu carrito está vacío
        </div>
        <a href="<?= base_url('productos') ?>" class="btn btn-primary">Ir a Productos</a>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Mi Carrito</h4>
                    </div>
                    <div class="card-body">
                        <!-- Versión para escritorio (oculta en móviles) -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img src="<?= base_url('public/uploads/productos/' . $item['producto']['imagen_url']) ?>" 
                                                     class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1"><?= $item['producto']['nombre'] ?></h6>
                                                    <small class="text-muted">Marca: <?= $item['producto']['marca'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$<?= number_format($item['producto']['precio'], 2) ?></td>
                                        <td>
                                            <form action="<?= base_url('carrito/actualizar/' . $item['id_item']) ?>" method="post" class="d-flex">
                                                <input type="number" name="cantidad" class="form-control" style="width: 70px;" 
                                                       value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['producto']['stock'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                        <td>
                                            <a href="<?= base_url('carrito/eliminar/' . $item['id_item']) ?>" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Versión para móviles (oculta en escritorio) -->
                        <div class="d-block d-md-none">
                            <?php foreach ($items as $item): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="<?= base_url('public/uploads/productos/' . $item['producto']['imagen_url']) ?>" 
                                             class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6><?= $item['producto']['nombre'] ?></h6>
                                            <small class="text-muted">Marca: <?= $item['producto']['marca'] ?></small>
                                            <div class="mt-1">
                                                <span class="fw-bold">$<?= number_format($item['producto']['precio'], 2) ?></span>
                                            </div>
                                            
                                            <form action="<?= base_url('carrito/actualizar/' . $item['id_item']) ?>" method="post" class="mt-2">
                                                <div class="input-group">
                                                    <input type="number" name="cantidad" class="form-control" 
                                                           value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['producto']['stock'] ?>">
                                                    <button type="submit" class="btn btn-outline-primary">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                    <a href="<?= base_url('carrito/eliminar/' . $item['id_item']) ?>" class="btn btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </form>
                                            
                                            <div class="mt-2 fw-bold">
                                                Total: $<?= number_format($item['subtotal'], 2) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="<?= base_url('productos') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Seguir comprando
                            </a>
                            <a href="<?= base_url('carrito/vaciar') ?>" class="btn btn-outline-danger">Vaciar carrito</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4 sticky-md-top" style="top: 20px;">
                    <div class="card-header"><h4>Resumen del Pedido</h4></div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tbody>
                                <tr class="table-active">
                                    <th>Total</th>
                                    <td class="text-end fw-bold">$<?= number_format($total, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="d-grid gap-2">
                            <form action="<?= base_url('carrito/comprar') ?>" method="post">
                                <button type="submit" class="btn btn-primary w-100">Proceder al pago</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>