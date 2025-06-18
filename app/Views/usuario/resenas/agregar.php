<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Agregar Reseña</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <h5><?= esc($producto['nombre']) ?></h5>
                        <?php if (!empty($producto['imagen_url'])): ?>
                            <img src="<?= base_url('public/uploads/productos/'.$producto['imagen_url']) ?>" 
                                 alt="<?= esc($producto['nombre']) ?>" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px;">
                        <?php endif; ?>
                    </div>

                    <form action="<?= base_url('perfil/resenas/guardar/' . $producto['id_producto']) ?>" 
                          method="post" 
                          class="needs-validation" 
                          novalidate>
                        
                        <div class="mb-3">
                            <label class="form-label">Calificación</label>
                            <div class="rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" 
                                           name="calificacion" 
                                           value="<?= $i ?>" 
                                           id="star<?= $i ?>" 
                                           <?= old('calificacion') == $i ? 'checked' : '' ?> 
                                           required>
                                    <label for="star<?= $i ?>">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <?php if (session('errors.calificacion')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= session('errors.calificacion') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentario</label>
                            <textarea class="form-control <?= session('errors.comentario') ? 'is-invalid' : '' ?>" 
                                      id="comentario" 
                                      name="comentario" 
                                      rows="4" 
                                      required><?= old('comentario') ?></textarea>
                            <?php if (session('errors.comentario')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.comentario') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('perfil/resenas') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Reseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    padding: 0 0.1em;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: #ffc107;
}
</style>

<script>
// Validación del formulario
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>