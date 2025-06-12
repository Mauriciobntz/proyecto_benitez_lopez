<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Ventas Hoy</h6>
                            <h3 class="card-text">$<?= number_format($totalVentasHoy, 2) ?></h3>
                        </div>
                        <i class="bi bi-currency-dollar" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Pedidos Hoy</h6>
                            <h3 class="card-text"><?= $pedidosHoy ?></h3>
                        </div>
                        <i class="bi bi-cart" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Productos</h6>
                            <h3 class="card-text"><?= $totalProductos ?></h3>
                        </div>
                        <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Clientes</h6>
                            <h3 class="card-text"><?= $totalClientes ?></h3>
                        </div>
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Últimas Ventas</span>
                        <a href="<?= base_url('admin/ventas/listar') ?>" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ultimasVentas as $venta): 
                                    $badgeClass = [
                                        'pendiente' => 'bg-secondary',
                                        'pagado' => 'bg-primary',
                                        'enviado' => 'bg-info',
                                        'entregado' => 'bg-success',
                                        'cancelado' => 'bg-danger'
                                    ][$venta['estado']];
                                ?>
                                <tr>
                                    <td>#<?= $venta['id_venta'] ?></td>
                                    <td><?= $venta['nombre'] ?> <?= $venta['apellido'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($venta['fecha_venta'])) ?></td>
                                    <td>€<?= number_format($venta['total'], 2) ?></td>
                                    <td><span class="badge <?= $badgeClass ?>"><?= ucfirst($venta['estado']) ?></span></td>
                                    <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/ventas/detalle/' . $venta['id_venta']) ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/ventas/factura/' . $venta['id_venta']) ?>" class="btn btn-outline-secondary" target="_blank">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Productos con poco stock</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($productosBajoStock)): ?>
                            <?php foreach ($productosBajoStock as $producto): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $producto['nombre'] ?>
                                <span class="badge bg-warning rounded-pill"><?= $producto['stock'] ?> unidades</span>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">No hay productos con stock bajo</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Últimas reseñas</div>
                <div class="card-body">
                    <?php if (!empty($ultimasResenas)): ?>
                        <?php foreach ($ultimasResenas as $resena): ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <strong><?= $resena['producto_nombre'] ?></strong>
                                <div>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= $resena['calificacion'] ? '-fill' : '' ?> text-warning"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="small mb-1">"<?= $resena['comentario'] ?>"</p>
                            <p class="small text-muted">Por <?= $resena['nombre'] ?> <?= $resena['apellido'] ?> - <?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-muted">No hay reseñas recientes</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>