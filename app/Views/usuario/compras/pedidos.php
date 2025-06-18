<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Mis Pedidos</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($pedidos)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i> No has realizado ningún pedido aún.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>N° Pedido</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td>#<?= $pedido['id_venta'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($pedido['fecha_venta'])) ?></td>
                                            <td>$<?= number_format($pedido['total'], 2) ?></td>
                                            <td>
                                                <?php 
                                                $badgeClass = [
                                                    'pendiente' => 'bg-secondary',
                                                    'pagado' => 'bg-primary',
                                                    'enviado' => 'bg-info',
                                                    'entregado' => 'bg-success',
                                                    'cancelado' => 'bg-danger'
                                                ];
                                                ?>
                                                <span class="badge <?= $badgeClass[strtolower($pedido['estado'])] ?>">
                                                    <?= ucfirst($pedido['estado']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('perfil/pedidos/' . $pedido['id_venta']) ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if ($pedido['estado'] == 'pagado' || $pedido['estado'] == 'enviado'): ?>
                                                    <a href="<?= base_url('perfil/factura/' . $pedido['id_venta']) ?>" 
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-printer"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($pedido['estado'] == 'enviado'): ?>
                                                    <a href="<?= base_url('perfil/seguimiento/' . $pedido['id_venta']) ?>" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-truck"></i> Seguimiento
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="<?= base_url('perfil') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Perfil
                </a>
            </div>
        </div>
    </div>
</div> 