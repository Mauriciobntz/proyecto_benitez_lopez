<?php
$nombre = $usuario['persona']['nombre'] ?? $usuario['username'] ?? '';
$apellido = $usuario['persona']['apellido'] ?? '';
$telefono = $usuario['persona']['telefono'] ?? '';
$avatar_nombre = trim(($usuario['persona']['nombre'] ?? $usuario['username'] ?? '') . ' ' . ($usuario['persona']['apellido'] ?? ''));
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($avatar_nombre) ?>&background=0D8ABC&color=fff" 
                         alt="Avatar" class="rounded-circle mb-3" width="120">
                    <h4><?= esc($nombre) ?> <?= esc($apellido) ?></h4>
                    <p class="text-muted mb-1"><?= esc($usuario['email']) ?></p>
                    <p class="text-muted"><?= esc($telefono) ?></p>
                    <div class="d-flex justify-content-center mb-2">
                        <a href="<?= base_url('perfil/editar') ?>" class="btn btn-primary me-2">Editar Perfil</a>
                        <a href="<?= base_url('perfil/cambiar-password') ?>" class="btn btn-outline-secondary">Cambiar Contraseña</a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Información Personal</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php if (isset($usuario['persona']['tipo_documento']) && isset($usuario['persona']['documento'])): ?>
                            <li class="mb-2"><strong><?= esc($usuario['persona']['tipo_documento']) ?>:</strong> <?= esc($usuario['persona']['documento']) ?></li>
                        <?php endif; ?>
                        <?php if (isset($usuario['persona']['fecha_nacimiento'])): ?>
                            <li class="mb-2"><strong>Fecha Nacimiento:</strong> <?= date('d/m/Y', strtotime($usuario['persona']['fecha_nacimiento'])) ?></li>
                        <?php endif; ?>
                        <?php if (isset($usuario['persona']['genero'])): ?>
                            <li class="mb-2"><strong>Género:</strong> 
                                <?= $usuario['persona']['genero'] == 'H' ? 'Masculino' : 
                                   ($usuario['persona']['genero'] == 'M' ? 'Femenino' : 'Otro') ?>
                            </li>
                        <?php endif; ?>
                        <li><strong>Registro:</strong> <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <a class="nav-link active" href="#pedidos" data-bs-toggle="pill">Mis Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#direcciones" data-bs-toggle="pill">Mis Direcciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#resenas" data-bs-toggle="pill">Mis Reseñas</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pedidos">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Historial de Pedidos</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($pedidos)): ?>
                                <div class="alert alert-info">No has realizado ningún pedido aún.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>N° Pedido</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pedidos as $pedido): ?>
                                                <tr>
                                                    <td>#<?= $pedido['id_venta'] ?></td>
                                                    <td><?= date('d/m/Y', strtotime($pedido['fecha_venta'])) ?></td>
                                                    <td>$<?= number_format($pedido['total'], 2) ?></td>
                                                    <td>
                                                        <?php 
                                                        $badgeClass = [
                                                            'pendiente' => 'bg-secondary',
                                                            'pagado' => 'bg-primary',
                                                            'enviado' => 'bg-info',
                                                            'entregado' => 'bg-success',
                                                            'cancelado' => 'bg-danger'
                                                        ];
                                                        ?>
                                                        <span class="badge <?= $badgeClass[strtolower($pedido['estado'])] ?>">
                                                            <?= ucfirst($pedido['estado']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('perfil/pedidos/' . $pedido['id_venta']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                        <?php if ($pedido['estado'] == 'pagado' || $pedido['estado'] == 'enviado'): ?>
                                                            <a href="<?= base_url('perfil/factura/' . $pedido['id_venta']) ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-printer"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="direcciones">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Mis Direcciones</h5>
                            <a href="<?= base_url('perfil/direcciones/agregar') ?>" class="btn btn-primary btn-sm">Agregar Dirección</a>
                        </div>
                        <div class="card-body">
                            <?php if (empty($direcciones)): ?>
                                <div class="alert alert-info">No tienes direcciones registradas.</div>
                            <?php else: ?>
                                <div class="row">
                                    <?php foreach ($direcciones as $direccion): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <h6><?= esc($direccion['alias']) ?></h6>
                                                        <?php if ($direccion['es_principal']): ?>
                                                            <span class="badge bg-primary">Principal</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="text-muted">
                                                        <?= esc($direccion['direccion']) ?><br>
                                                        <?= esc($direccion['ciudad']) ?>, <?= esc($direccion['provincia']) ?> <?= esc($direccion['codigo_postal']) ?><br>
                                                        <?= esc($direccion['pais']) ?>
                                                    </p>
                                                    <div class="d-flex">
                                                        <a href="<?= base_url('perfil/direcciones/editar/' . $direccion['id_direccion']) ?>" class="btn btn-sm btn-outline-secondary me-2">Editar</a>
                                                        <a href="<?= base_url('perfil/direcciones/eliminar/' . $direccion['id_direccion']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta dirección?')">Eliminar</a>
                                                        <?php if (!$direccion['es_principal']): ?>
                                                            <a href="<?= base_url('perfil/direcciones/principal/' . $direccion['id_direccion']) ?>" class="btn btn-sm btn-outline-primary ms-auto">Marcar como principal</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="resenas">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Mis Reseñas</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($resenas)): ?>
                                <div class="alert alert-info">No has realizado ninguna reseña.</div>
                            <?php else: ?>
                                <?php foreach ($resenas as $resena): ?>
                                    <div class="d-flex mb-4 border-bottom pb-3">
                                        <div class="flex-shrink-0">
                                            <img src="<?= base_url(!empty($resena['imagen_url']) ? 'public/uploads/productos/' . $resena['imagen_url'] : 'public/img/no-image.jpg') ?>" alt="Producto" width="80" class="rounded">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6><?= esc($resena['nombre_producto']) ?></h6>
                                            <div class="mb-2">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="bi bi-star-fill <?= $i <= $resena['calificacion'] ? 'text-warning' : 'text-secondary' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <p class="mb-2"><?= esc($resena['comentario']) ?></p>
                                            <small class="text-muted">Publicado el <?= date('d/m/Y', strtotime($resena['fecha'])) ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>