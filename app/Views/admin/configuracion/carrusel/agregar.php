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
            <h4>Agregar Nuevo Slide</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/configuracion/carrusel/guardar') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título *</label>
                    <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('titulo') ? 'is-invalid' : '' ?>" 
                           id="titulo" name="titulo" value="<?= old('titulo') ?>">
                    <?php if (session('validation') && session('validation')->hasError('titulo')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('titulo') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control <?= session('validation') && session('validation')->hasError('descripcion') ? 'is-invalid' : '' ?>" 
                              id="descripcion" name="descripcion" rows="3"><?= old('descripcion') ?></textarea>
                    <?php if (session('validation') && session('validation')->hasError('descripcion')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('descripcion') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="enlace" class="form-label">Enlace</label>
                    <input type="url" class="form-control <?= session('validation') && session('validation')->hasError('enlace') ? 'is-invalid' : '' ?>" 
                           id="enlace" name="enlace" value="<?= old('enlace') ?>">
                    <?php if (session('validation') && session('validation')->hasError('enlace')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('enlace') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen *</label>
                    <input type="file" class="form-control <?= session('validation') && session('validation')->hasError('imagen') ? 'is-invalid' : '' ?>" 
                        id="imagen" name="imagen" accept="image/*">
                    <?php if (session('validation') && session('validation')->hasError('imagen')): ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('imagen') ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">
                        Tamaño requerido: 1200x400px a 2000x600px. Formatos: JPG, PNG, WEBP. Tamaño máximo: 2MB
                    </small>
                    <div id="image-preview" class="mt-2" style="display: none;">
                        <img id="preview-img" src="#" alt="Vista previa" class="img-thumbnail" style="max-height: 150px;">
                        <div id="image-dimensions" class="text-muted small mt-1"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="orden" class="form-label">Orden *</label>
                        <input type="number" class="form-control <?= session('validation') && session('validation')->hasError('orden') ? 'is-invalid' : '' ?>" 
                               id="orden" name="orden" value="<?= old('orden', $orden) ?>">
                        <?php if (session('validation') && session('validation')->hasError('orden')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('orden') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                            <label class="form-check-label" for="activo">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('admin/configuracion/carrusel/listar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('imagen').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const dimensionsInfo = document.getElementById('image-dimensions');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.style.display = 'block';
            previewImg.src = e.target.result;
            
            const tempImg = new Image();
            tempImg.src = e.target.result;
            tempImg.onload = function() {
                dimensionsInfo.textContent = `Dimensiones: ${this.width}×${this.height}px`;
                if (this.width < 1200 || this.height < 400) {
                    dimensionsInfo.innerHTML += ' <span class="text-danger">(El tamaño mínimo requerido es 1200×400px)</span>';
                }
                if (this.width > 2000 || this.height > 600) {
                    dimensionsInfo.innerHTML += ' <span class="text-danger">(El tamaño máximo permitido es 2000×600px)</span>';
                }
            };
        };
        
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.style.display = 'none';
    }
});
</script>