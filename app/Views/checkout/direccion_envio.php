<?php
$errors = session('errors') ?? [];
$oldData = session('_ci_old_input') ?? [];
?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dirección de Envío</h5>
                </div>
                <div class="card-body">
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('checkout/guardar-direccion') ?>" method="post" id="checkoutForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="tipo" value="envio">
                        <?php if (!empty($direcciones)): ?>
                            <?php foreach ($direcciones as $direccion): ?>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="direccion_id" 
                                           id="direccion<?= $direccion['id_direccion'] ?>" 
                                           value="<?= $direccion['id_direccion'] ?>" 
                                           <?= $direccion['es_principal'] ? 'checked' : '' ?>>
                                    <label class="form-check-label w-100" for="direccion<?= $direccion['id_direccion'] ?>">
                                        <div class="d-flex justify-content-between">
                                            <strong><?= $direccion['alias'] ?></strong>
                                        </div>
                                        <div class="mt-2">
                                            <p class="mb-1"><?= $direccion['direccion'] ?></p>
                                            <p class="mb-1"><?= $direccion['codigo_postal'] ?>, <?= $direccion['ciudad'] ?>, <?= $direccion['provincia'] ?></p>
                                            <p class="mb-0"><?= $direccion['pais'] ?></p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <a href="<?= base_url('checkout/agregar-direccion') ?>" 
                               class="btn btn-outline-primary mb-3">
                                <i class="bi bi-plus"></i> Añadir nueva dirección
                            </a>
                        <?php else: ?>
                            <div class="alert alert-warning">No tienes direcciones registradas. Por favor, agrega una dirección para continuar.</div>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-primary w-100 mt-3" <?= empty($direcciones) ? 'disabled' : '' ?>>Continuar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($items)): ?>
                        <!-- Productos -->
                        <h6 class="text-muted">Productos</h6>
                        <?php foreach ($items as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= $item['producto']['nombre'] ?> x<?= $item['cantidad'] ?></span>
                            <span>$<?= number_format($item['subtotal'], 2) ?></span>
                        </div>
                        <?php endforeach; ?>
                        <hr>
                        
                        <!-- Resumen de Costos -->
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                        <a href="<?= base_url('carrito') ?>" class="btn btn-outline-danger w-100 mt-3">Volver al Carrito</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>