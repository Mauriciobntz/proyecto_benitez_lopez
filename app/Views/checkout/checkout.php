<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dirección de Envío</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('usuario/carrito/procesar-compra') ?>" method="post" id="checkoutForm">
                        <?php if (!empty($direcciones)): ?>
                            <?php foreach ($direcciones as $direccion): ?>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="direccion_id" id="direccion<?= $direccion['id_direccion'] ?>" value="<?= $direccion['id_direccion'] ?>" <?= $direccion['es_principal'] ? 'checked' : '' ?> required>
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
                                            <div class="mb-3">
                                                <label for="alias" class="form-label">Alias (Ej: Casa, Trabajo)</label>
                                                <input type="text" class="form-control" id="alias" name="alias" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="direccion" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="codigo_postal" class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="ciudad" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="provincia" class="form-label">Provincia</label>
                                                <input type="text" class="form-control" id="provincia" name="provincia" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pais" class="form-label">País</label>
                                                <input type="text" class="form-control" id="pais" name="pais" value="España" required>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="es_principal" name="es_principal">
                                                <label class="form-check-label" for="es_principal">Establecer como dirección principal</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="guardarDireccion">Guardar Dirección</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                
                                <!-- Campos para tarjeta -->
                                <div id="tarjetaFields" class="p-3 border rounded mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="numero_tarjeta" class="form-label">Número de tarjeta</label>
                                            <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="1234 5678 9012 3456" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="nombre_tarjeta" class="form-label">Nombre en la tarjeta</label>
                                            <input type="text" class="form-control" id="nombre_tarjeta" name="nombre_tarjeta" placeholder="Juan Pérez" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="fecha_expiracion" class="form-label">Expiración</label>
                                            <input type="text" class="form-control" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/AA" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
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
                                        <input type="text" class="form-control" id="referencia_pago" name="referencia_pago" placeholder="Ingrese el número de referencia de su transferencia">
                                    </div>
                                    <div class="mb-3">
                                        <label for="comprobante" class="form-label">Comprobante de transferencia</label>
                                        <input type="file" class="form-control" id="comprobante" name="comprobante" accept="image/*,.pdf">
                                        <small class="text-muted">Formatos aceptados: JPG, PNG, PDF</small>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <i class="bi bi-paypal me-2"></i> PayPal
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="acepto_terminos" id="aceptoTerminos" required>
                            <label class="form-check-label" for="aceptoTerminos">
                                Acepto los <a href="<?= base_url('terminos') ?>" target="_blank">Términos y Condiciones</a> y la <a href="<?= base_url('privacidad') ?>" target="_blank">Política de Privacidad</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" <?= empty($direcciones) ? 'disabled' : '' ?> id="confirmarCompraBtn">Confirmar Compra</button>
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
                        <h6>Productos</h6>
                        <?php foreach ($items as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= $item['producto']['nombre'] ?> x<?= $item['cantidad'] ?></span>
                            <span>€<?= number_format($item['subtotal'], 2) ?></span>
                        </div>
                        <?php endforeach; ?>
                        
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
    }
    
    // Inicializar
    toggleMetodoPago();
    
    // Escuchar cambios
    document.querySelectorAll('input[name="metodo_pago"]').forEach(el => {
        el.addEventListener('change', toggleMetodoPago);
    });
    
    // Manejar el guardado de nueva dirección
    document.getElementById('guardarDireccion').addEventListener('click', async function() {
        try {
            const formData = new FormData();
            formData.append('alias', document.getElementById('alias').value);
            formData.append('direccion', document.getElementById('direccion').value);
            formData.append('codigo_postal', document.getElementById('codigo_postal').value);
            formData.append('ciudad', document.getElementById('ciudad').value);
            formData.append('provincia', document.getElementById('provincia').value);
            formData.append('pais', document.getElementById('pais').value);
            formData.append('es_principal', document.getElementById('es_principal').checked ? '1' : '0');
            
            const response = await fetch('<?= base_url('usuario/direcciones/crear') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if(data.success) {
                location.reload();
            } else {
                alert('Error al guardar la dirección: ' + (data.message || 'Intente nuevamente'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión al guardar la dirección');
        }
    });
    
    // Validación del formulario principal
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
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
        }
        
        // Validar que se haya seleccionado una dirección
        if(!document.querySelector('input[name="direccion_id"]:checked')) {
            e.preventDefault();
            alert('Por favor seleccione una dirección de envío');
            return false;
        }
    });
});
</script>