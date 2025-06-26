<?php
$errors = session('errors') ?? [];
$oldData = session('_ci_old_input') ?? [];
?>
<div class="container mt-4">
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

    <form action="<?= base_url('admin/productos/guardar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Información Básica</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" 
                                   class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre') ?>">
                            <?php if (isset($errors['nombre'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['nombre']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3"><?= old('descripcion') ?></textarea>
                            <?php if (isset($errors['descripcion'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['descripcion']) ?></div>
                            <?php endif; ?>
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
                            <?php 
                            $oldKeys = old('especificaciones_key') ?? [];
                            $oldValues = old('especificaciones_value') ?? [];
                            
                            if (!empty($oldKeys)) {
                                foreach ($oldKeys as $index => $key) {
                                    $value = $oldValues[$index] ?? '';
                                    ?>
                                    <div class="row mb-2 especificacion-item">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="especificaciones_key[]" 
                                                   placeholder="Nombre especificación" value="<?= htmlspecialchars($key) ?>">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="especificaciones_value[]" 
                                                   placeholder="Valor" value="<?= htmlspecialchars($value) ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-especificacion">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="row mb-2 especificacion-item">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="especificaciones_key[]" 
                                               placeholder="Nombre especificación">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="especificaciones_value[]" 
                                               placeholder="Valor">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-especificacion">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
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
                            <label for="precio" class="form-label">Precio ($)</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control <?= isset($errors['precio']) ? 'is-invalid' : '' ?>" 
                                   id="precio" 
                                   name="precio" 
                                   value="<?= old('precio', '0') ?>">
                            <?php if (isset($errors['precio'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['precio']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock Disponible</label>
                            <input type="number" 
                                   class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>" 
                                   id="stock" 
                                   name="stock" 
                                   value="<?= old('stock', '0') ?>">
                            <?php if (isset($errors['stock'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['stock']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="garantia_meses" class="form-label">Garantía (meses)</label>
                            <input type="number" class="form-control <?= isset($errors['garantia_meses']) ? 'is-invalid' : '' ?>" 
                                   id="garantia_meses" name="garantia_meses" 
                                   value="<?= old('garantia_meses', '12') ?>">
                            <?php if (isset($errors['garantia_meses'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['garantia_meses'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Categoría y Estado</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select <?= isset($errors['categoria_id']) ? 'is-invalid' : '' ?>" 
                                    id="categoria_id" 
                                    name="categoria_id">
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id_categoria'] ?>" 
                                        <?= old('categoria_id') == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                        <?= $categoria['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['categoria_id'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['categoria_id']) ?></div>
                            <?php endif; ?>
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
                            <label for="imagen" class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control <?= isset($errors['imagen']) ? 'is-invalid' : '' ?>" 
                                   id="imagen" name="imagen" accept="image/*">
                            <small class="text-muted">Formatos: JPG, PNG, GIF. Máx. 2MB</small>
                            <?php if (isset($errors['imagen'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['imagen'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/productos/listar') ?>" class="btn btn-secondary">Cancelar</a>
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
    
    // También manejar clicks en el ícono dentro del botón
    if (e.target && e.target.closest('.remove-especificacion')) {
        e.target.closest('.especificacion-item').remove();
    }
});
</script>