<div class="container mt-4">
    <?php if (session()->has('validation')) : ?>
        <div class="alert alert-danger">
            <?= session()->get('validation')->listErrors() ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->get('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session()->get('message') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('productos/guardar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Información Básica</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= old('descripcion') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" value="<?= old('marca') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="<?= old('modelo') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Especificaciones</div>
                    <div class="card-body">
                        <div id="especificaciones-container">
                            <div class="row mb-2 especificacion-item">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="especificaciones_key[]" placeholder="Nombre especificación" value="<?= old('especificaciones_key.0') ?>">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="especificaciones_value[]" placeholder="Valor" value="<?= old('especificaciones_value.0') ?>">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-especificacion">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-especificacion" class="btn btn-secondary btn-sm mt-2">
                            <i class="bi bi-plus"></i> Agregar Especificación
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Precio e Inventario</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio (€)</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= old('precio', '0') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock Disponible</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', '0') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="garantia_meses" class="form-label">Garantía (meses)</label>
                            <input type="number" class="form-control" id="garantia_meses" name="garantia_meses" value="<?= old('garantia_meses', '12') ?>">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Categoría y Estado</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                <option value="">Seleccione una categoría</option>
                                <option value="1" <?= old('categoria_id') == '1' ? 'selected' : '' ?>>Electrónicos</option>
                                <option value="2" <?= old('categoria_id') == '2' ? 'selected' : '' ?>>Hogar</option>
                                <option value="3" <?= old('categoria_id') == '3' ? 'selected' : '' ?>>Ropa</option>
                                <option value="4" <?= old('categoria_id') == '4' ? 'selected' : '' ?>>Deportes</option>
                                <option value="5" <?= old('categoria_id') == '5' ? 'selected' : '' ?>>Juguetes</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="activo" class="form-label">Estado</label>
                            <select class="form-select" id="activo" name="activo">
                                <option value="1" <?= old('activo', '1') == '1' ? 'selected' : '' ?>>Activo</option>
                                <option value="0" <?= old('activo') == '0' ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Imagen del Producto</div>
                    <div class="card-body">
                        <div id="image-preview" class="mb-3" style="display: none;">
                            <img id="preview-img" src="#" alt="Vista previa" class="img-fluid mb-2">
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Nueva Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            <small class="text-muted">Formatos: JPG, PNG, GIF. Máx. 2MB</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= base_url('productos') ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-dark">
                <i class="bi bi-save"></i> Guardar Producto
            </button>
        </div>
    </form>
</div>

<script>
// JavaScript para manejar la vista previa de la imagen y las especificaciones dinámicas
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

document.getElementById('add-especificacion').addEventListener('click', function() {
    const container = document.getElementById('especificaciones-container');
    const newItem = document.createElement('div');
    newItem.className = 'row mb-2 especificacion-item';
    newItem.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control" name="especificaciones_key[]" placeholder="Nombre especificación">
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="especificaciones_value[]" placeholder="Valor">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-especificacion">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newItem);
});

document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-especificacion')) {
        e.target.closest('.especificacion-item').remove();
    }
});
</script>