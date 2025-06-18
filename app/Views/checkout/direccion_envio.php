<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dirección de Envío</h5>
                </div>
                <div class="card-body">
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ((array)session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('checkout/guardar-direccion') ?>" method="post" id="checkoutForm">
                        <input type="hidden" name="tipo" value="envio">
                        <?php if (!empty($direcciones)): ?>
                            <?php foreach ($direcciones as $direccion): ?>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="direccion_id" 
                                           id="direccion<?= $direccion['id_direccion'] ?>" 
                                           value="<?= $direccion['id_direccion'] ?>" 
                                           <?= $direccion['es_principal'] ? 'checked' : '' ?> required>
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
                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#nuevaDireccionModal">
                                <i class="bi bi-plus"></i> Añadir nueva dirección
                            </button>
                        <?php else: ?>
                            <div class="alert alert-warning">No tienes direcciones registradas. Por favor, agrega una dirección para continuar.</div>
                        <?php endif; ?>

                        <!-- Modal para nueva dirección -->
                        <div class="modal fade" id="nuevaDireccionModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nueva Dirección</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="nuevaDireccionForm">
                                            <input type="hidden" name="tipo" value="envio">
                                            <div class="mb-3">
                                                <label for="alias" class="form-label">Alias (Ej: Casa, Trabajo)</label>
                                                <input type="text" class="form-control<?= session('errors.alias') ? ' is-invalid' : '' ?>" id="alias" name="alias" value="<?= old('alias') ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="direccion" class="form-label">Dirección</label>
                                                <input type="text" class="form-control<?= session('errors.direccion') ? ' is-invalid' : '' ?>" id="direccion" name="direccion" value="<?= old('direccion') ?>">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="codigo_postal" class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control<?= session('errors.codigo_postal') ? ' is-invalid' : '' ?>" id="codigo_postal" name="codigo_postal" value="<?= old('codigo_postal') ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="ciudad" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control<?= session('errors.ciudad') ? ' is-invalid' : '' ?>" id="ciudad" name="ciudad" value="<?= old('ciudad') ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="provincia" class="form-label">Provincia</label>
                                                <input type="text" class="form-control<?= session('errors.provincia') ? ' is-invalid' : '' ?>" id="provincia" name="provincia" value="<?= old('provincia') ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="pais" class="form-label">País</label>
                                                <input type="text" class="form-control<?= session('errors.pais') ? ' is-invalid' : '' ?>" id="pais" name="pais" value="<?= old('pais', 'España') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary" name="nueva_direccion" value="1">Guardar Dirección</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                            <span>€<?= number_format($item['subtotal'], 2) ?></span>
                        </div>
                        <?php endforeach; ?>
                        <hr>
                        
                        <!-- Resumen de Costos -->
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>€<?= number_format($total, 2) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>