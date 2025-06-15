<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?= $titulo ?></h2>
        <a href="<?= base_url('admin/configuracion/tienda/editar') ?>" class="btn btn-dark">
            <i class="bi bi-pencil"></i> Editar Configuración
        </a>
    </div>

    <?php if (session()->has('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5>Información de la Tienda</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Nombre de la Tienda</h6>
                        <p><?= esc($config['nombre_tienda']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Razón Social</h6>
                        <p><?= esc($config['razon_social']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Email</h6>
                        <p><?= esc($config['email_tienda']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Teléfono</h6>
                        <p><?= esc($config['telefono_tienda'] ?? 'No especificado') ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>WhatsApp</h6>
                        <p><?= esc($config['whatsapp_tienda'] ?? 'No especificado') ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Dirección</h6>
                        <p><?= esc($config['direccion_tienda'] ?? 'No especificada') ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>CUIT</h6>
                        <p><?= esc($config['cuit'] ?? 'No especificado') ?></p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>CBU</h6>
                        <p><?= esc($config['cbu']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Área de Cobertura</h6>
                        <p><?= esc($config['area_cobertura'] ?? 'No especificada') ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Horario de Atención</h6>
                        <p><?= esc($config['horario_atencion'] ?? 'No especificado') ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Mensaje de Bienvenida</h6>
                        <p><?= esc($config['mensaje_bienvenida'] ?? 'No especificado') ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Logo</h6>
                        <?php if (!empty($config['logo_url'])): ?>
                            <img src="<?= base_url('public/uploads/config/' . $config['logo_url']) ?>" 
                                 class="img-thumbnail" style="max-height: 150px;">
                        <?php else: ?>
                            <p>No hay logo cargado</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Redes Sociales</h6>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-facebook me-2"></i> <?= esc($config['facebook_url'] ?? 'No especificado') ?></li>
                            <li><i class="bi bi-instagram me-2"></i> <?= esc($config['instagram_url'] ?? 'No especificado') ?></li>
                            <li><i class="bi bi-twitter me-2"></i> <?= esc($config['twitter_url'] ?? 'No especificado') ?></li>
                            <li><i class="bi bi-whatsapp me-2"></i> <?= esc($config['whatsapp_url'] ?? 'No especificado') ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>