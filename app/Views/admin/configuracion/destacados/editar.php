<div class="container mt-4">
    <?php if (session('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>
    
    <?php if (session('validation')): ?>
        <div class="alert alert-danger">
            <?= session('validation')->listErrors() ?>
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
                    <select class="form-select <?= session('validation') && session('validation')->hasError('producto_id') ? 'is-invalid' : '' ?>" 
                           id="producto_id" name="producto_id">
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id_producto'] ?>" <?= old('producto_id', $destacado['producto_id']) == $producto['id_producto'] ? 'selected' : '' ?>>
                                <?= $producto['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('validation') && session('validation')->hasError('producto_id')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('producto_id') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título *</label>
                    <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('titulo') ? 'is-invalid' : '' ?>" 
                           id="titulo" name="titulo" value="<?= old('titulo', $destacado['titulo']) ?>">
                    <?php if (session('validation') && session('validation')->hasError('titulo')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('titulo') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="subtitulo" class="form-label">Subtítulo</label>
                    <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('subtitulo') ? 'is-invalid' : '' ?>" 
                           id="subtitulo" name="subtitulo" value="<?= old('subtitulo', $destacado['subtitulo']) ?>">
                    <?php if (session('validation') && session('validation')->hasError('subtitulo')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('subtitulo') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="video_file" class="form-label">Video</label>
                    <input type="file" class="form-control <?= session('validation') && session('validation')->hasError('video_file') ? 'is-invalid' : '' ?>" 
                           id="video_file" name="video_file" accept="video/mp4,video/mov,video/avi">
                    <?php if (session('validation') && session('validation')->hasError('video_file')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('video_file') ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Formatos aceptados: MP4, MOV, AVI (máx 10MB)</small>
                    <?php if ($destacado['video_url']): ?>
                        <small class="d-block mt-1">Video actual: <a href="<?= base_url('public/uploads/destacados/'.$destacado['video_url']) ?>" target="_blank">Ver video</a></small>
                    <?php endif; ?>
                    
                    <!-- Preview del video -->
                    <div class="mt-3" id="video-preview-container" style="display: none;">
                        <h6>Vista Previa del Nuevo Video:</h6>
                        <video id="video-preview" controls style="max-width: 100%;">
                            Tu navegador no soporta la reproducción de video.
                        </video>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="url_producto" class="form-label">URL del Producto</label>
                    <input type="url" class="form-control <?= session('validation') && session('validation')->hasError('url_producto') ? 'is-invalid' : '' ?>" 
                           id="url_producto" name="url_producto" value="<?= old('url_producto', $destacado['url_producto']) ?>">
                    <?php if (session('validation') && session('validation')->hasError('url_producto')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('url_producto') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="orden" class="form-label">Orden *</label>
                        <input type="number" class="form-control <?= session('validation') && session('validation')->hasError('orden') ? 'is-invalid' : '' ?>" 
                               id="orden" name="orden" value="<?= old('orden', $destacado['orden']) ?>">
                        <?php if (session('validation') && session('validation')->hasError('orden')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('orden') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" <?= $destacado['activo'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="activo">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('admin/configuracion/destacados/listar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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