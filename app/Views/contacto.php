<!--
4. Información de Contacto
La página con información de contacto, donde se publicará el nombre del titular
de la empresa, la razón social, el domicilio legal, teléfonos, y otros medios de
contacto que se consideren necesario. Deberá facilitar un cuestionario para que
el potencial cliente se comunique con miembros de la empresa.
-->

<section class="container my-5">
    <!-- Título principal -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Contáctanos</h2>
        <p class="lead">Estamos aquí para ayudarte. Elige tu método preferido de contacto.</p>
    </div>

    <div class="row g-4">
        <!-- Columna del Formulario -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h3><i class="fas fa-paper-plane me-2"></i>Formulario de Contacto</h3>
                    <p class="mb-0">Complete el formulario y nos pondremos en contacto a la brevedad</p>
                </div>
                
                <form method="post" action="http://localhost/tercer_proyecto/enviarcontacto" class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre Completo*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empresa" class="form-label">Empresa/Organización</label>
                            <input type="text" class="form-control" id="empresa" name="empresa">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico*</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono/Celular*</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto*</label>
                        <select class="form-select" id="asunto" name="asunto" required>
                            <option value="" selected disabled>Seleccione un asunto</option>
                            <option value="cotizacion">Solicitud de Cotización</option>
                            <option value="soporte">Soporte Técnico</option>
                            <option value="facturacion">Consulta Facturación</option>
                            <option value="reclamo">Reclamo/Sugerencia</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje*</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">¿Cómo desea ser contactado?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="contacto_pref" id="contacto_email" value="email" checked>
                            <label class="form-check-label" for="contacto_email">Correo Electrónico</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="contacto_pref" id="contacto_telefono" value="telefono">
                            <label class="form-check-label" for="contacto_telefono">Llamada Telefónica</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="contacto_pref" id="contacto_whatsapp" value="whatsapp">
                            <label class="form-check-label" for="contacto_whatsapp">WhatsApp</label>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="privacidad" required>
                        <label class="form-check-label" for="privacidad">Acepto la <a href="#" data-bs-toggle="modal" data-bs-target="#politicaModal">política de privacidad</a>*</label>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-eraser me-1"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-paper-plane me-1"></i> Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información y Mapa -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h3><i class="fas fa-map-marker-alt me-2"></i> Nuestra Ubicación</h3>
                </div>
                <div class="card-body">
                    <!-- Mapa -->
                    <div class="ratio ratio-16x9 mb-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1251.6020044911695!2d-58.82686995379281!3d-27.46724296699074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sar!4v1745866409188!5m2!1ses!2sar" 
                                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded"></iframe>
                    </div>
                    
                    <!-- Información de Contacto -->
                    <div class="mb-4">
                        <h4><i class="bi bi-building text-primary me-2"></i>Datos de la empresa</h4>
                        <ul class="list-unstyled">
                            <li><strong>Nombre Comercial:</strong> Follow</li>
                            <li><strong>Razón Social:</strong> Follow S.A.</li>
                            <li><strong>CUIT:</strong> 30-12345678-9</li>
                            <li><strong>Domicilio Legal:</strong> 9 de Julio 1813</li>
                            <li><strong>Área de Cobertura:</strong> Corrientes, Chaco, Formosa y Misiones (NEA)</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h4><i class="bi bi-headset text-primary me-2"></i>Medios de contacto</h4>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-telephone me-2"></i><strong>Teléfono:</strong> <a href="tel:+543794000000" class="text-decoration-none">(+54 379) 400-0000</a></li>
                            <li><i class="bi bi-whatsapp me-2"></i><strong>WhatsApp:</strong> <a href="https://wa.me/543795000000" class="text-decoration-none">(+54 9 379) 500-0000</a></li>
                            <li><i class="bi bi-envelope me-2"></i><strong>Email:</strong> <a href="mailto:soporte@follow.com.ar" class="text-decoration-none">soporte@follow.com.ar</a></li>
                            <li><i class="bi bi-clock me-2"></i><strong>Horario:</strong> Lunes a Viernes de 9:00 a 21:00 hs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Suscripción -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h4 class="mb-1"><i class="bi bi-megaphone text-primary me-2"></i>¡Mantente informado!</h4>
                            <p class="mb-0">Recibe ofertas exclusivas y las últimas novedades directamente en tu correo.</p>
                        </div>
                        <div class="col-lg-4 mt-3 mt-lg-0">
                            <form class="input-group">
                                <input type="email" class="form-control" placeholder="Tu correo electrónico" required>
                                <button class="btn btn-primary" type="submit">Suscribirse</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Política de Privacidad -->
<div class="modal fade" id="politicaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Política de Privacidad</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Protección de Datos Personales</h5>
                <p>En cumplimiento de la Ley de Protección de Datos Personales, le informamos que los datos proporcionados serán tratados con la máxima confidencialidad y utilizados únicamente para los fines de contacto y atención de su consulta.</p>
                
                <h5 class="mt-4">Uso de la Información</h5>
                <p>La información proporcionada no será compartida con terceros sin su consentimiento expreso, excepto cuando sea requerido por autoridades competentes.</p>
                
                <h5 class="mt-4">Derechos del Usuario</h5>
                <p>Usted tiene derecho a acceder, rectificar y suprimir sus datos personales, así como otros derechos que puede ejercer enviando un correo a privacidad@solucionestecnoperu.com</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

