<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Editar Dirección</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('perfil/direcciones/actualizar/' . $direccion['id_direccion']) ?>" 
                          method="post" 
                          class="needs-validation" 
                          novalidate>
                        
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Dirección</label>
                            <select class="form-select <?= session('errors.tipo') ? 'is-invalid' : '' ?>" 
                                    id="tipo" 
                                    name="tipo" 
                                    required>
                                <option value="particular" <?= old('tipo', $direccion['tipo'] ?? '') == 'particular' ? 'selected' : '' ?>>Particular</option>
                                <option value="fiscal" <?= old('tipo', $direccion['tipo'] ?? '') == 'fiscal' ? 'selected' : '' ?>>Fiscal</option>
                                <option value="envio" <?= old('tipo', $direccion['tipo'] ?? '') == 'envio' ? 'selected' : '' ?>>Envío</option>
                                <option value="trabajo" <?= old('tipo', $direccion['tipo'] ?? '') == 'trabajo' ? 'selected' : '' ?>>Trabajo</option>
                            </select>
                            <?php if (session('errors.tipo')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.tipo') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="alias" class="form-label">Alias de la dirección</label>
                            <input type="text" 
                                   class="form-control <?= session('errors.alias') ? 'is-invalid' : '' ?>" 
                                   id="alias" 
                                   name="alias" 
                                   value="<?= old('alias', $direccion['alias'] ?? '') ?>" 
                                   required>
                            <?php if (session('errors.alias')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.alias') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" 
                                   class="form-control <?= session('errors.direccion') ? 'is-invalid' : '' ?>" 
                                   id="direccion" 
                                   name="direccion" 
                                   value="<?= old('direccion', $direccion['direccion'] ?? '') ?>" 
                                   required>
                            <?php if (session('errors.direccion')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.direccion') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" 
                                       class="form-control <?= session('errors.ciudad') ? 'is-invalid' : '' ?>" 
                                       id="ciudad" 
                                       name="ciudad" 
                                       value="<?= old('ciudad', $direccion['ciudad'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.ciudad')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.ciudad') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="provincia" class="form-label">Provincia</label>
                                <input type="text" 
                                       class="form-control <?= session('errors.provincia') ? 'is-invalid' : '' ?>" 
                                       id="provincia" 
                                       name="provincia" 
                                       value="<?= old('provincia', $direccion['provincia'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.provincia')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.provincia') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo_postal" class="form-label">Código Postal</label>
                                <input type="text" 
                                       class="form-control <?= session('errors.codigo_postal') ? 'is-invalid' : '' ?>" 
                                       id="codigo_postal" 
                                       name="codigo_postal" 
                                       value="<?= old('codigo_postal', $direccion['codigo_postal'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.codigo_postal')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.codigo_postal') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" 
                                       class="form-control <?= session('errors.pais') ? 'is-invalid' : '' ?>" 
                                       id="pais" 
                                       name="pais" 
                                       value="<?= old('pais', $direccion['pais'] ?? 'España') ?>" 
                                       required>
                                <?php if (session('errors.pais')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.pais') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="es_principal" 
                                       name="es_principal" 
                                       value="1" 
                                       <?= old('es_principal', $direccion['es_principal'] ?? false) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="es_principal">
                                    Establecer como dirección principal
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('perfil/direcciones') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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