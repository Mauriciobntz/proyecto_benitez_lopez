<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Método de Pago</h5>
                </div>
                <div class="card-body">
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
                    <?php endif; ?>
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ((array)session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('checkout/procesar-pago') ?>" method="post" id="paymentForm">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="Tarjeta" checked>
                            <label class="form-check-label" for="tarjeta">
                                <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito/Débito
                            </label>
                        </div>
                        
                        <!-- Campos para tarjeta -->
                        <div id="tarjetaFields" class="p-3 border rounded mb-3">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="numero_tarjeta" class="form-label">Número de tarjeta</label>
                                    <input type="text" class="form-control<?= session('errors.numero_tarjeta') ? ' is-invalid' : '' ?>" id="numero_tarjeta" name="numero_tarjeta" 
                                           placeholder="1234 5678 9012 3456" value="<?= old('numero_tarjeta') ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre_tarjeta" class="form-label">Nombre en la tarjeta</label>
                                    <input type="text" class="form-control<?= session('errors.nombre_tarjeta') ? ' is-invalid' : '' ?>" id="nombre_tarjeta" name="nombre_tarjeta" 
                                           placeholder="Juan Pérez" value="<?= old('nombre_tarjeta') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha_expiracion" class="form-label">Expiración</label>
                                    <input type="text" class="form-control<?= session('errors.fecha_expiracion') ? ' is-invalid' : '' ?>" id="fecha_expiracion" name="fecha_expiracion" 
                                           placeholder="MM/AA" value="<?= old('fecha_expiracion') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control<?= session('errors.cvv') ? ' is-invalid' : '' ?>" id="cvv" name="cvv" 
                                           placeholder="123" value="<?= old('cvv') ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="Transferencia">
                            <label class="form-check-label" for="transferencia">
                                <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                            </label>
                        </div>
                        
                        <!-- Información para transferencia -->
                        <div id="transferenciaInfo" class="p-3 border rounded mb-3" style="display: none;">
                            <div class="alert alert-info">
                                <h5>Datos para transferencia</h5>
                                <p>CBU: <?= $cbu ?></p>
                                <p>Alias: <?= $aliasCbu ?></p>
                                <p>Razón Social: <?= $razonSocial ?></p>
                                <p>Una vez realizada la transferencia, envíe el comprobante a <?= $emailTienda ?></p>
                            </div>
                            <div class="mb-3">
                                <label for="referencia_pago" class="form-label">Número de referencia de la transferencia</label>
                                <input type="text" class="form-control<?= session('errors.referencia_pago') ? ' is-invalid' : '' ?>" id="referencia_pago" name="referencia_pago" 
                                       placeholder="Ingrese el número de referencia de su transferencia" value="<?= old('referencia_pago') ?>">
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="contrapago" value="Contrapago">
                            <label class="form-check-label" for="contrapago">
                                <i class="bi bi-cash me-2"></i> Contrapago (pago al recibir)
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="bitcoin" value="Bitcoin">
                            <label class="form-check-label" for="bitcoin">
                                <i class="bi bi-currency-bitcoin me-2"></i> Bitcoin
                            </label>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="acepto_terminos" id="aceptoTerminos" required>
                            <label class="form-check-label" for="aceptoTerminos">
                                Acepto los <a href="<?= base_url('terminos') ?>" target="_blank">Términos y Condiciones</a> y la 
                                <a href="<?= base_url('privacidad') ?>" target="_blank">Política de Privacidad</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirmar Pago</button>
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
                    <!-- Información de Dirección de Envío -->
                    <?php if (isset($direccion) && !empty($direccion)): ?>
                    <div class="mb-3">
                        <h6 class="text-muted">Dirección de Envío</h6>
                        <div class="bg-light p-2 rounded">
                            <?php if (isset($direccion['alias'])): ?>
                                <small class="fw-bold"><?= esc($direccion['alias']) ?></small><br>
                            <?php endif; ?>
                            <small><?= esc($direccion['direccion']) ?></small><br>
                            <small>
                                <?= esc($direccion['codigo_postal']) ?>, 
                                <?= esc($direccion['ciudad']) ?>, 
                                <?= esc($direccion['provincia']) ?>
                            </small><br>
                            <small><?= esc($direccion['pais']) ?></small>
                        </div>
                    </div>
                    <hr>
                    <?php endif; ?>

                    <!-- Productos -->
                    <h6 class="text-muted">Productos</h6>
                    <?php if (!empty($items)): ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar campos según método de pago
    function toggleMetodoPago() {
        const metodoPago = document.querySelector('input[name="metodo_pago"]:checked').value;
        
        document.getElementById('tarjetaFields').style.display = 
            metodoPago === 'Tarjeta' ? 'block' : 'none';
        document.getElementById('transferenciaInfo').style.display = 
            metodoPago === 'Transferencia' ? 'block' : 'none';
        
        // Actualizar campos requeridos
        document.getElementById('numero_tarjeta').required = metodoPago === 'Tarjeta';
        document.getElementById('nombre_tarjeta').required = metodoPago === 'Tarjeta';
        document.getElementById('fecha_expiracion').required = metodoPago === 'Tarjeta';
        document.getElementById('cvv').required = metodoPago === 'Tarjeta';
        document.getElementById('referencia_pago').required = metodoPago === 'Transferencia';
    }
    
    // Inicializar
    toggleMetodoPago();
    
    // Escuchar cambios
    document.querySelectorAll('input[name="metodo_pago"]').forEach(el => {
        el.addEventListener('change', toggleMetodoPago);
    });
    
    // Validación del formulario
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        if(!document.getElementById('aceptoTerminos').checked) {
            e.preventDefault();
            alert('Debes aceptar los términos y condiciones para continuar');
            return false;
        }
        const metodoPago = document.querySelector('input[name="metodo_pago"]:checked').value;
        if(metodoPago === 'Tarjeta') {
            const tarjeta = document.getElementById('numero_tarjeta').value;
            const nombre = document.getElementById('nombre_tarjeta').value;
            const expiracion = document.getElementById('fecha_expiracion').value;
            const cvv = document.getElementById('cvv').value;
            if(!tarjeta || !nombre || !expiracion || !cvv) {
                e.preventDefault();
                alert('Por favor complete todos los datos de la tarjeta');
                return false;
            }
        } else if(metodoPago === 'Transferencia') {
            const referencia = document.getElementById('referencia_pago').value;
            if(!referencia) {
                e.preventDefault();
                alert('Por favor ingrese el número de referencia de la transferencia');
                return false;
            }
        }
    });
});
</script>