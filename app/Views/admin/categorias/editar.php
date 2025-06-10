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

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/categorias/actualizar/' . $categoria['id_categoria']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="categoria_id" value="<?= $categoria['id_categoria'] ?>">

        <div class="card mb-4">
            <div class="card-header">Información de la Categoría</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nombre') ? 'is-invalid' : '' ?>" 
                           id="nombre" name="nombre" 
                           value="<?= old('nombre', $categoria['nombre']) ?>" required>
                    <?php if (isset($validation) && $validation->hasError('nombre')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nombre') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control <?= isset($validation) && $validation->hasError('descripcion') ? 'is-invalid' : '' ?>" 
                              id="descripcion" name="descripcion" rows="3"><?= old('descripcion', $categoria['descripcion']) ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('descripcion')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('descripcion') ?>
                        </div>
                    <?php endif; ?>
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