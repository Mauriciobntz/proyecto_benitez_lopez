<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dirección de Envío</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('usuario/carrito/procesar-compra') ?>" method="post">
                        <?php if (!empty($direcciones)): ?>
                            <?php foreach ($direcciones as $direccion): ?>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="direccion_id" id="direccion<?= $direccion['id_direccion'] ?>" value="<?= $direccion['id_direccion'] ?>" <?= $direccion['es_principal'] ? 'checked' : '' ?>>
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
                        <?php else: ?>
                            <div class="alert alert-warning">No tienes direcciones registradas. Por favor, agrega una dirección para continuar.</div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="telefono_contacto" class="form-label">Teléfono de Contacto</label>
                            <input type="tel" class="form-control" id="telefono_contacto" name="telefono_contacto" required>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Método de Pago</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                                    <label class="form-check-label" for="tarjeta">
                                        <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito/Débito
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                    <label class="form-check-label" for="transferencia">
                                        <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <i class="bi bi-paypal me-2"></i> PayPal
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" <?= empty($direcciones) ? 'disabled' : '' ?>>Confirmar Compra</button>
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
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span>€<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Envío:</span>
                            <span>€<?= number_format($costo_envio, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>IVA (21%):</span>
                            <span>€<?= number_format($iva, 2) ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>€<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <a href="<?= base_url('usuario/carrito') ?>" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="bi bi-arrow-left me-2"></i> Volver al carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>