<div class="container mt-4">
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <?php $validation = \Config\Services::validation(); ?>
    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/categorias/guardar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="card mb-4">
            <div class="card-header">Información de la Categoría</div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control <?= $validation->hasError('nombre') ? 'is-invalid' : '' ?>" 
                           id="nombre" name="nombre" value="<?= old('nombre', $nombre ?? '') ?>">
                    <?php if ($validation->hasError('nombre')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nombre') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción *</label>
                    <textarea class="form-control <?= $validation->hasError('descripcion') ? 'is-invalid' : '' ?>" 
                              id="descripcion" name="descripcion" rows="3"><?= old('descripcion', $descripcion ?? '') ?></textarea>
                    <?php if ($validation->hasError('descripcion')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('descripcion') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen de la Categoría *</label>
                    <input type="file" class="form-control <?= $validation->hasError('imagen') ? 'is-invalid' : '' ?>" 
                           id="imagen" name="imagen" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <?php if ($validation->hasError('imagen')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('imagen') ?>
                        </div>
                    <?php endif; ?>
                    <div id="image-preview" class="mt-2" style="display: none;">
                        <img id="preview-img" src="#" alt="Vista previa" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/categorias/listar') ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-dark">
                <i class="bi bi-save"></i> Guardar Categoría
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('imagen').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (this.files && this.files[0]) {
        preview.style.display = 'block';
        previewImg.src = URL.createObjectURL(this.files[0]);
    } else {
        preview.style.display = 'none';
    }
});
</script>