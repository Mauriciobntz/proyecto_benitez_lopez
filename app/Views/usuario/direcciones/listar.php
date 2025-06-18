<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
?>
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Mis Direcciones</h2>
                <a href="<?= base_url('perfil/direcciones/agregar') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Nueva Dirección
                </a>
            </div>

            <?php if (session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($direcciones)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No tienes direcciones guardadas. 
                    <a href="<?= base_url('perfil/direcciones/crear') ?>" class="alert-link">Agregar una dirección</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($direcciones as $direccion): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title mb-1"><?= esc($direccion['alias']) ?></h5>
                                            <span class="badge bg-<?= $direccion['tipo'] == 'particular' ? 'primary' : 
                                                                     ($direccion['tipo'] == 'fiscal' ? 'success' : 
                                                                     ($direccion['tipo'] == 'envio' ? 'info' : 'warning')) ?>">
                                                <?= ucfirst($direccion['tipo']) ?>
                                            </span>
                                            <?php if ($direccion['es_principal']): ?>
                                                <span class="badge bg-danger ms-2">Principal</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <p class="card-text mb-3">
                                        <i class="bi bi-geo-alt"></i> <?= esc($direccion['direccion']) ?><br>
                                        <?= esc($direccion['ciudad']) ?>, <?= esc($direccion['provincia']) ?><br>
                                        <?= esc($direccion['codigo_postal']) ?><br>
                                        <?= esc($direccion['pais']) ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url('perfil/direcciones/editar/' . $direccion['id_direccion']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal<?= $direccion['id_direccion'] ?>">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </div>
                                        <?php if (!$direccion['es_principal']): ?>
                                            <a href="<?= base_url('perfil/direcciones/principal/' . $direccion['id_direccion']) ?>" 
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-star"></i> Hacer principal
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de confirmación de eliminación -->
                        <div class="modal fade" id="deleteModal<?= $direccion['id_direccion'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar la dirección "<?= esc($direccion['alias']) ?>"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <a href="<?= base_url('perfil/direcciones/eliminar/' . $direccion['id_direccion']) ?>" 
                                           class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
            <div class="mt-4">
                <a href="<?= base_url('perfil') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Perfil
                </a>
            </div>
    </div>
</div> 