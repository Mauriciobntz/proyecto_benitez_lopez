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

    <form action="<?= base_url('admin/categorias/guardar') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="card mb-4">
            <div class="card-header">Información de la Categoría</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= old('descripcion') ?></textarea>
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