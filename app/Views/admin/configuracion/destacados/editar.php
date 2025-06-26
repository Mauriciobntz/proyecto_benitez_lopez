<?php
$errors = session('errors') ?? [];
$oldData = session('_ci_old_input') ?? [];
?>
<div class="container mt-4">
    <?php if (session('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h4>Editar Producto Destacado</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/configuracion/destacados/actualizar/' . $destacado['id_destacado']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto *</label>
                    <select class="form-select <?= isset($errors['producto_id']) ? 'is-invalid' : '' ?>" 
                           id="producto_id" name="producto_id">
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id_producto'] ?>" <?= old('producto_id', $destacado['producto_id']) == $producto['id_producto'] ? 'selected' : '' ?>>
                                <?= $producto['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['producto_id'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['producto_id'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título *</label>
                    <input type="text" class="form-control <?= isset($errors['titulo']) ? 'is-invalid' : '' ?>" 
                           id="titulo" name="titulo" value="<?= old('titulo', $destacado['titulo']) ?>">
                    <?php if (isset($errors['titulo'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['titulo'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="subtitulo" class="form-label">Subtítulo</label>
                    <input type="text" class="form-control <?= isset($errors['subtitulo']) ? 'is-invalid' : '' ?>" 
                           id="subtitulo" name="subtitulo" value="<?= old('subtitulo', $destacado['subtitulo']) ?>">
                    <?php if (isset($errors['subtitulo'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['subtitulo'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="video_file" class="form-label">Video</label>
                    <?php if (!empty($destacado['video_url'])): ?>
                        <div class="mb-2">
                            <video controls style="max-width: 100%; max-height: 200px;">
                                <source src="<?= base_url('public/uploads/destacados/' . $destacado['video_url']) ?>" type="video/mp4">
                                Tu navegador no soporta la reproducción de video.
                            </video>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="eliminar_video" name="eliminar_video" value="1">
                                <label class="form-check-label" for="eliminar_video">
                                    Eliminar video actual
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control <?= isset($errors['video_file']) ? 'is-invalid' : '' ?>" 
                           id="video_file" name="video_file" accept="video/mp4,video/mov,video/avi">
                    <?php if (isset($errors['video_file'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['video_file'] ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Formatos aceptados: MP4, MOV, AVI (máx 10MB)</small>
                </div>

                <div class="mb-3">
                    <label for="url_producto" class="form-label">URL del Producto</label>
                    <input type="url" class="form-control <?= isset($errors['url_producto']) ? 'is-invalid' : '' ?>" 
                           id="url_producto" name="url_producto" value="<?= old('url_producto', $destacado['url_producto']) ?>">
                    <?php if (isset($errors['url_producto'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['url_producto'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="orden" class="form-label">Orden *</label>
                        <input type="number" class="form-control <?= isset($errors['orden']) ? 'is-invalid' : '' ?>" 
                               id="orden" name="orden" value="<?= old('orden', $destacado['orden']) ?>">
                        <?php if (isset($errors['orden'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['orden'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                   <?= old('activo', $destacado['activo']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="activo">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('admin/configuracion/destacados/listar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Producto Destacado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoFileInput = document.getElementById('video_file');
    const videoPreviewContainer = document.getElementById('video-preview-container');
    const videoPreview = document.getElementById('video-preview');
    
    videoFileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const videoURL = URL.createObjectURL(file);
            videoPreview.src = videoURL;
            videoPreviewContainer.style.display = 'block';
        } else {
            videoPreview.src = '';
            videoPreviewContainer.style.display = 'none';
        }
    });
});
</script>