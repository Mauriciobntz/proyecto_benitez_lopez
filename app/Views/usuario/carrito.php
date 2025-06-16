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
    <h2><?= $titulo ?></h2>
    
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
                        <div class="table-responsive">
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
                                                <img src="<?= base_url('public/uploads/productos/' . $item['producto']['imagen_url']) ?>" class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                                                <div>
                                                    <h6 class="mb-1"><?= $item['producto']['nombre'] ?></h6>
                                                    <small class="text-muted">Marca: <?= $item['producto']['marca'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>€<?= number_format($item['producto']['precio'], 2) ?></td>
                                        <td>
                                            <form action="<?= base_url('usuario/carrito/actualizar/' . $item['id_item']) ?>" method="post" class="d-flex">
                                                <input type="number" name="cantidad" class="form-control" style="width: 70px;" 
                                                    value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['producto']['stock'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>€<?= number_format($item['subtotal'], 2) ?></td>
                                        <td>
                                            <a href="<?= base_url('usuario/carrito/eliminar/' . $item['id_item']) ?>" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('productos') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Seguir comprando
                            </a>
                            <a href="<?= base_url('usuario/carrito/vaciar') ?>" class="btn btn-outline-danger">Vaciar carrito</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header"><h4>Resumen del Pedido</h4></div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td class="text-end">€<?= number_format($total, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>Total productos sin IVA</th>
                                    <td class="text-end">€<?= number_format($total / 1.21, 2) ?></td>
                                </tr>
                                <tr class="table-active">
                                    <th>Total</th>
                                    <td class="text-end fw-bold">€<?= number_format($total, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('usuario/carrito/checkout') ?>" class="btn btn-primary">Proceder al pago</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>