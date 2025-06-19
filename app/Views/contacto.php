<!--
4. Información de Contacto
La página con información de contacto, donde se publicará el nombre del titular
de la empresa, la razón social, el domicilio legal, teléfonos, y otros medios de
contacto que se consideren necesario. Deberá facilitar un cuestionario para que
el potencial cliente se comunique con miembros de la empresa.
-->


<!-- Sección de Contacto -->
<div class="container py-5">
    <div class="row">
        <!-- Información de Contacto -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 text-dark">Información de Contacto</h3>

                    <!-- Datos de la empresa -->
                    <div class="info-section mb-4">
                        <div class="section-header d-flex align-items-center mb-3">
                            <div class="icon-box bg-dark bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-building text-dark fa-lg"></i>
                            </div>
                            <h4 class="mb-0 text-dark">Datos de la empresa</h4>
                        </div>
                        <ul class="list-unstyled ps-4">
                            <li class="mb-2">
                                <span class="text-muted">Nombre Comercial:</span>
                                <span class="fw-bold d-block"><?= esc($nombreTienda) ?></span>
                            </li>
                            <li class="mb-2">
                                <span class="text-muted">Razón Social:</span>
                                <span class="fw-bold d-block"><?= esc($razonSocial) ?></span>
                            </li>
                            <li class="mb-2">
                                <span class="text-muted">CUIT:</span>
                                <span class="fw-bold d-block"><?= esc($cuit) ?></span>
                            </li>
                            <li class="mb-2">
                                <span class="text-muted">Domicilio Legal:</span>
                                <span class="fw-bold d-block"><?= esc($direccionTienda) ?></span>
                            </li>
                            <li class="mb-2">
                                <span class="text-muted">Área de Cobertura:</span>
                                <span class="fw-bold d-block"><?= esc($areaCobertura) ?></span>
                            </li>
                        </ul>
                    </div>

                    <!-- Medios de contacto -->
                    <div class="info-section">
                        <div class="section-header d-flex align-items-center mb-3">
                            <div class="icon-box bg-dark bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-headset text-dark fa-lg"></i>
                            </div>
                            <h4 class="mb-0 text-dark">Medios de contacto</h4>
                        </div>
                        <ul class="list-unstyled ps-4">
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box-sm bg-dark bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-telephone text-dark"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Teléfono</span>
                                        <a href="tel:<?= esc($telefonoTienda) ?>" class="text-dark text-decoration-none fw-bold"><?= esc($telefonoTienda) ?></a>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box-sm bg-dark bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-whatsapp text-dark"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">WhatsApp</span>
                                        <a href="<?= esc($whatsappUrl) ?>" class="text-dark text-decoration-none fw-bold"><?= esc($whatsappTienda) ?></a>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box-sm bg-dark bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-envelope text-dark"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Email</span>
                                        <a href="mailto:<?= esc($emailTienda) ?>" class="text-dark text-decoration-none fw-bold"><?= esc($emailTienda) ?></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="icon-box-sm bg-dark bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-clock text-dark"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Horario de Atención</span>
                                        <span class="fw-bold"><?= esc($horarioAtencion) ?></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de Contacto -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 text-dark">Envíanos un Mensaje</h3>

                    <?php if (session()->has('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('contacto/procesar') ?>" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user text-dark"></i>
                                    </span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="razon_social" class="form-label">Razón Social</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-building text-dark"></i>
                                    </span>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo Electrónico *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-dark"></i>
                                    </span>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-phone text-dark"></i>
                                    </span>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="asunto" class="form-label">Asunto *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-tag text-dark"></i>
                                    </span>
                                    <select class="form-select" id="asunto" name="asunto" required>
                                        <option value="">Seleccione un asunto</option>
                                        <option value="Solicitud de Cotizacion">Solicitud de Cotización</option>
                                        <option value="Soporte Tecnico">Soporte Técnico</option>
                                        <option value="Consulta Facturacion">Consulta Facturación</option>
                                        <option value="Reclamo">Reclamo</option>
                                        <option value="Sugerencia">Sugerencia</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-comment text-dark"></i>
                                </span>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Preferencia de Contacto *</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preferencia_contacto" 
                                           id="correo" value="correo" required>
                                    <label class="form-check-label" for="correo">
                                        <i class="fas fa-envelope me-2 text-dark"></i>Correo Electrónico
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preferencia_contacto" 
                                           id="llamada" value="llamada">
                                    <label class="form-check-label" for="llamada">
                                        <i class="fas fa-phone me-2 text-dark"></i>Llamada Telefónica
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preferencia_contacto" 
                                           id="whatsapp" value="whatsapp">
                                    <label class="form-check-label" for="whatsapp">
                                        <i class="fab fa-whatsapp me-2 text-dark"></i>WhatsApp
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mapa de Ubicación -->
<div class="container-fluid px-0 mt-5">
    <div class="row g-0">
        <div class="col-12">
            <div class="ratio ratio-21x9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1251.6020044911695!2d-58.82686995379281!3d-27.46724296699074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sar!4v1745866409188!5m2!1ses!2sar" 
                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
.icon-box {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-box-sm {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-section {
    position: relative;
}

.info-section:not(:last-child)::after {
    content: '';
    position: absolute;
    bottom: -1rem;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(to right, rgba(0,0,0,0.1), rgba(0,0,0,0.05));
}

.list-unstyled li {
    transition: transform 0.2s ease;
}

.list-unstyled li:hover {
    transform: translateX(5px);
}

.list-unstyled a {
    transition: color 0.2s ease;
}

.list-unstyled a:hover {
    color: #000 !important;
}

.form-control:focus, .form-select:focus {
    border-color: #212529;
    box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.25);
}

.btn-dark {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-dark:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    background-color: #000;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
}
</style>

<!-- Script para validación del formulario -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>