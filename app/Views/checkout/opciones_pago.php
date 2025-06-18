<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Método de Pago</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('checkout/procesar-pago') ?>" method="post" id="paymentForm">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                            <label class="form-check-label" for="tarjeta">
                                <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito/Débito
                            </label>
                        </div>
                        
                        <!-- Campos para tarjeta -->
                        <div id="tarjetaFields" class="p-3 border rounded mb-3">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="numero_tarjeta" class="form-label">Número de tarjeta</label>
                                    <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" 
                                           placeholder="1234 5678 9012 3456" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre_tarjeta" class="form-label">Nombre en la tarjeta</label>
                                    <input type="text" class="form-control" id="nombre_tarjeta" name="nombre_tarjeta" 
                                           placeholder="Juan Pérez" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha_expiracion" class="form-label">Expiración</label>
                                    <input type="text" class="form-control" id="fecha_expiracion" name="fecha_expiracion" 
                                           placeholder="MM/AA" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" 
                                           placeholder="123" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                            <label class="form-check-label" for="transferencia">
                                <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                            </label>
                        </div>
                        
                        <!-- Información para transferencia -->
                        <div id="transferenciaInfo" class="p-3 border rounded mb-3" style="display: none;">
                            <div class="alert alert-info">
                                <h5>Datos para transferencia</h5>
                                <p>CBU: <?= $configuracion['cbu'] ?? 'XXXXXXXXXXXXX' ?></p>
                                <p>Alias: <?= $configuracion['alias_cbu'] ?? 'TIENDA.ONLINE' ?></p>
                                <p>Razón Social: <?= $configuracion['razon_social'] ?? 'Mi Tienda Online' ?></p>
                                <p>Una vez realizada la transferencia, envíe el comprobante a <?= $configuracion['email_tienda'] ?? 'soporte@tienda.com' ?></p>
                            </div>
                            <div class="mb-3">
                                <label for="referencia_pago" class="form-label">Número de referencia de la transferencia</label>
                                <input type="text" class="form-control" id="referencia_pago" name="referencia_pago" 
                                       placeholder="Ingrese el número de referencia de su transferencia">
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                            <label class="form-check-label" for="paypal">
                                <i class="bi bi-paypal me-2"></i> PayPal
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
            <?= view('checkout/resumen_pedido', [
                'items' => $items,
                'total' => $total
            ]) ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar campos según método de pago
    function toggleMetodoPago() {
        const metodoPago = document.querySelector('input[name="metodo_pago"]:checked').value;
        
        document.getElementById('tarjetaFields').style.display = 
            metodoPago === 'tarjeta' ? 'block' : 'none';
        document.getElementById('transferenciaInfo').style.display = 
            metodoPago === 'transferencia' ? 'block' : 'none';
        
        // Actualizar campos requeridos
        document.getElementById('numero_tarjeta').required = metodoPago === 'tarjeta';
        document.getElementById('nombre_tarjeta').required = metodoPago === 'tarjeta';
        document.getElementById('fecha_expiracion').required = metodoPago === 'tarjeta';
        document.getElementById('cvv').required = metodoPago === 'tarjeta';
        document.getElementById('referencia_pago').required = metodoPago === 'transferencia';
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
        
        if(metodoPago === 'tarjeta') {
            const tarjeta = document.getElementById('numero_tarjeta').value;
            const nombre = document.getElementById('nombre_tarjeta').value;
            const expiracion = document.getElementById('fecha_expiracion').value;
            const cvv = document.getElementById('cvv').value;
            
            if(!tarjeta || !nombre || !expiracion || !cvv) {
                e.preventDefault();
                alert('Por favor complete todos los datos de la tarjeta');
                return false;
            }
        } else if(metodoPago === 'transferencia') {
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