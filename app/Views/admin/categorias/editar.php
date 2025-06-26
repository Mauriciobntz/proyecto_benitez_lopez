<?php
$errors = session('errors') ?? [];
?>
<div class="container mt-4">
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/categorias/actualizar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="categoria_id" value="<?= $categoria['id_categoria'] ?>">

        <div class="card mb-4">
            <div class="card-header">Información de la Categoría</div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" 
                           id="nombre" name="nombre" 
                           value="<?= old('nombre', $categoria['nombre']) ?>">
                    <?php if (isset($errors['nombre'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['nombre'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción *</label>
                    <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>" 
                              id="descripcion" name="descripcion" rows="3"><?= old('descripcion', $categoria['descripcion']) ?></textarea>
                    <?php if (isset($errors['descripcion'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['descripcion'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen de la Categoría</label>
                    
                    <?php if (!empty($categoria['imagen_url'])): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('public/uploads/categorias/' . $categoria['imagen_url']) ?>" 
                                class="img-thumbnail" style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="eliminar_imagen" name="eliminar_imagen" value="1">
                                <label class="form-check-label" for="eliminar_imagen">
                                    Eliminar imagen actual
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <input type="file" class="form-control <?= isset($errors['imagen']) ? 'is-invalid' : '' ?>" 
                           id="imagen" name="imagen" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <?php if (isset($errors['imagen'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['imagen'] ?>
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
                <i class="bi bi-save"></i> Guardar Cambios
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