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

    <form action="<?= base_url('admin/configuracion/tienda/actualizar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Información Básica</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre_tienda" class="form-label">Nombre de la Tienda</label>
                            <input type="text" class="form-control <?= session('errors.nombre_tienda') ? 'is-invalid' : '' ?>" 
                                   id="nombre_tienda" name="nombre_tienda" 
                                   value="<?= old('nombre_tienda', $config['nombre_tienda']) ?>" required>
                            <?php if (session('errors.nombre_tienda')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.nombre_tienda') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="razon_social" class="form-label">Razón Social</label>
                            <input type="text" class="form-control <?= session('errors.razon_social') ? 'is-invalid' : '' ?>" 
                                   id="razon_social" name="razon_social" 
                                   value="<?= old('razon_social', $config['razon_social']) ?>" required>
                            <?php if (session('errors.razon_social')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.razon_social') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email_tienda" class="form-label">Email</label>
                            <input type="email" class="form-control <?= session('errors.email_tienda') ? 'is-invalid' : '' ?>" 
                                   id="email_tienda" name="email_tienda" 
                                   value="<?= old('email_tienda', $config['email_tienda']) ?>" required>
                            <?php if (session('errors.email_tienda')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.email_tienda') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono_tienda" class="form-label">Teléfono</label>
                            <input type="text" class="form-control <?= session('errors.telefono_tienda') ? 'is-invalid' : '' ?>" 
                                   id="telefono_tienda" name="telefono_tienda" 
                                   value="<?= old('telefono_tienda', $config['telefono_tienda'] ?? '') ?>" required>
                            <?php if (session('errors.telefono_tienda')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.telefono_tienda') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="whatsapp_tienda" class="form-label">WhatsApp</label>
                            <input type="text" class="form-control <?= session('errors.whatsapp_tienda') ? 'is-invalid' : '' ?>" 
                                   id="whatsapp_tienda" name="whatsapp_tienda" 
                                   value="<?= old('whatsapp_tienda', $config['whatsapp_tienda'] ?? '') ?>">
                            <?php if (session('errors.whatsapp_tienda')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.whatsapp_tienda') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="direccion_tienda" class="form-label">Dirección</label>
                            <input type="text" class="form-control <?= session('errors.direccion_tienda') ? 'is-invalid' : '' ?>" 
                                   id="direccion_tienda" name="direccion_tienda" 
                                   value="<?= old('direccion_tienda', $config['direccion_tienda'] ?? '') ?>" required>
                            <?php if (session('errors.direccion_tienda')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.direccion_tienda') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cuit" class="form-label">CUIT</label>
                            <input type="text" class="form-control <?= session('errors.cuit') ? 'is-invalid' : '' ?>" 
                                   id="cuit" name="cuit" 
                                   value="<?= old('cuit', $config['cuit'] ?? '') ?>" required>
                            <?php if (session('errors.cuit')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.cuit') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cbu" class="form-label">CBU</label>
                            <input type="text" class="form-control <?= session('errors.cbu') ? 'is-invalid' : '' ?>" 
                                   id="cbu" name="cbu" 
                                   value="<?= old('cbu', $config['cbu']) ?>" required>
                            <?php if (session('errors.cbu')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.cbu') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="alias_cbu" class="form-label">Alias CBU</label>
                            <input type="text" class="form-control <?= session('errors.alias_cbu') ? 'is-invalid' : '' ?>" 
                                id="alias_cbu" name="alias_cbu" 
                                value="<?= old('alias_cbu', $config['alias_cbu'] ?? '') ?>">
                            <?php if (session('errors.alias_cbu')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.alias_cbu') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="banco" class="form-label">Banco</label>
                            <input type="text" class="form-control <?= session('errors.banco') ? 'is-invalid' : '' ?>" 
                                id="banco" name="banco" 
                                value="<?= old('banco', $config['banco'] ?? '') ?>">
                            <?php if (session('errors.banco')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.banco') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="titular_cuenta" class="form-label">Titular de la Cuenta</label>
                            <input type="text" class="form-control <?= session('errors.titular_cuenta') ? 'is-invalid' : '' ?>" 
                                id="titular_cuenta" name="titular_cuenta" 
                                value="<?= old('titular_cuenta', $config['titular_cuenta'] ?? '') ?>">
                            <?php if (session('errors.titular_cuenta')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.titular_cuenta') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_cuenta" class="form-label">Tipo de Cuenta</label>
                            <select class="form-select <?= session('errors.tipo_cuenta') ? 'is-invalid' : '' ?>" 
                                    id="tipo_cuenta" name="tipo_cuenta">
                                <option value="Caja de ahorro" <?= old('tipo_cuenta', $config['tipo_cuenta'] ?? '') == 'Caja de ahorro' ? 'selected' : '' ?>>Caja de ahorro</option>
                                <option value="Cuenta corriente" <?= old('tipo_cuenta', $config['tipo_cuenta'] ?? '') == 'Cuenta corriente' ? 'selected' : '' ?>>Cuenta corriente</option>
                            </select>
                            <?php if (session('errors.tipo_cuenta')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.tipo_cuenta') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="area_cobertura" class="form-label">Área de Cobertura</label>
                            <input type="text" class="form-control <?= session('errors.area_cobertura') ? 'is-invalid' : '' ?>" 
                                   id="area_cobertura" name="area_cobertura" 
                                   value="<?= old('area_cobertura', $config['area_cobertura'] ?? '') ?>">
                            <?php if (session('errors.area_cobertura')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.area_cobertura') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="horario_atencion" class="form-label">Horario de Atención</label>
                            <input type="text" class="form-control <?= session('errors.horario_atencion') ? 'is-invalid' : '' ?>" 
                                   id="horario_atencion" name="horario_atencion" 
                                   value="<?= old('horario_atencion', $config['horario_atencion'] ?? '') ?>" required>
                            <?php if (session('errors.horario_atencion')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.horario_atencion') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="mensaje_bienvenida" class="form-label">Mensaje de Bienvenida</label>
                    <textarea class="form-control <?= session('errors.mensaje_bienvenida') ? 'is-invalid' : '' ?>" 
                              id="mensaje_bienvenida" name="mensaje_bienvenida" rows="3" required><?= old('mensaje_bienvenida', $config['mensaje_bienvenida'] ?? '') ?></textarea>
                    <?php if (session('errors.mensaje_bienvenida')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.mensaje_bienvenida') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Redes Sociales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="url" class="form-control <?= session('errors.facebook_url') ? 'is-invalid' : '' ?>" 
                                   id="facebook_url" name="facebook_url" 
                                   value="<?= old('facebook_url', $config['facebook_url'] ?? '') ?>">
                            <?php if (session('errors.facebook_url')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.facebook_url') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">Instagram URL</label>
                            <input type="url" class="form-control <?= session('errors.instagram_url') ? 'is-invalid' : '' ?>" 
                                   id="instagram_url" name="instagram_url" 
                                   value="<?= old('instagram_url', $config['instagram_url'] ?? '') ?>">
                            <?php if (session('errors.instagram_url')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.instagram_url') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter URL</label>
                            <input type="url" class="form-control <?= session('errors.twitter_url') ? 'is-invalid' : '' ?>" 
                                   id="twitter_url" name="twitter_url" 
                                   value="<?= old('twitter_url', $config['twitter_url'] ?? '') ?>">
                            <?php if (session('errors.twitter_url')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.twitter_url') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="whatsapp_url" class="form-label">WhatsApp URL</label>
                            <input type="url" class="form-control <?= session('errors.whatsapp_url') ? 'is-invalid' : '' ?>" 
                                   id="whatsapp_url" name="whatsapp_url" 
                                   value="<?= old('whatsapp_url', $config['whatsapp_url'] ?? '') ?>">
                            <?php if (session('errors.whatsapp_url')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.whatsapp_url') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Logo de la Tienda</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($config['logo_url'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Logo Actual</label>
                        <img src="<?= base_url('public/uploads/config/' . $config['logo_url']) ?>" 
                             class="img-thumbnail d-block mb-2" style="max-height: 150px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="eliminar_logo" name="eliminar_logo" value="1">
                            <label class="form-check-label" for="eliminar_logo">
                                Eliminar logo actual
                            </label>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="logo" class="form-label">Nuevo Logo</label>
                    <input type="file" class="form-control <?= session('errors.logo') ? 'is-invalid' : '' ?>" 
                           id="logo" name="logo" accept="image/*">
                    <?php if (session('errors.logo')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.logo') ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Formatos: JPG, PNG. Máx. 2MB</small>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/configuracion/tienda/ver') ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-dark">
                <i class="bi bi-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
// Vista previa de la imagen
document.getElementById('logo').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (this.files && this.files[0]) {
        if (!preview) {
            const previewDiv = document.createElement('div');
            previewDiv.id = 'image-preview';
            previewDiv.className = 'mb-3';
            previewDiv.innerHTML = '<img id="preview-img" src="#" alt="Vista previa" class="img-thumbnail mb-2" style="max-height: 150px;">';
            this.parentNode.insertBefore(previewDiv, this.nextSibling);
        } else {
            preview.style.display = 'block';
        }
        previewImg.src = URL.createObjectURL(this.files[0]);
    } else if (preview) {
        preview.style.display = 'none';
    }
});
</script>