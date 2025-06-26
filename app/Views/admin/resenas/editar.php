<?php
$errors = session('errors') ?? [];
?>
<div class="container mt-4">
    <!-- Mostrar mensajes de error/success -->
    <?php if (session('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/resenas/actualizar/' . $resena['id_resena']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="card mb-4">
            <div class="card-header">Editar Reseña</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <select class="form-select <?= isset($errors['producto_id']) ? 'is-invalid' : '' ?>" 
                            id="producto_id" 
                            name="producto_id">
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id_producto'] ?>" 
                                <?= old('producto_id', $resena['producto_id']) == $producto['id_producto'] ? 'selected' : '' ?>>
                                <?= $producto['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['producto_id'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['producto_id']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="usuario_id" class="form-label">Usuario</label>
                    <select class="form-select <?= isset($errors['usuario_id']) ? 'is-invalid' : '' ?>" 
                            id="usuario_id" 
                            name="usuario_id">
                        <option value="">Seleccione un usuario</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id_usuario'] ?>" 
                                <?= old('usuario_id', $resena['usuario_id']) == $usuario['id_usuario'] ? 'selected' : '' ?>>
                                <?= $usuario['username'] ?> (<?= $usuario['email'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['usuario_id'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['usuario_id']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="calificacion" class="form-label">Calificación</label>
                    <select class="form-select <?= isset($errors['calificacion']) ? 'is-invalid' : '' ?>" 
                            id="calificacion" 
                            name="calificacion">
                        <option value="">Seleccione una calificación</option>
                        <option value="1" <?= old('calificacion', $resena['calificacion']) == '1' ? 'selected' : '' ?>>1 estrella</option>
                        <option value="2" <?= old('calificacion', $resena['calificacion']) == '2' ? 'selected' : '' ?>>2 estrellas</option>
                        <option value="3" <?= old('calificacion', $resena['calificacion']) == '3' ? 'selected' : '' ?>>3 estrellas</option>
                        <option value="4" <?= old('calificacion', $resena['calificacion']) == '4' ? 'selected' : '' ?>>4 estrellas</option>
                        <option value="5" <?= old('calificacion', $resena['calificacion']) == '5' ? 'selected' : '' ?>>5 estrellas</option>
                    </select>
                    <?php if (isset($errors['calificacion'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['calificacion']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea class="form-control <?= isset($errors['comentario']) ? 'is-invalid' : '' ?>" 
                              id="comentario" name="comentario" rows="3"><?= old('comentario', $resena['comentario']) ?></textarea>
                    <?php if (isset($errors['comentario'])): ?>
                        <div class="invalid-feedback"><?= $errors['comentario'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/resenas/listar') ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-dark">
                <i class="bi bi-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>