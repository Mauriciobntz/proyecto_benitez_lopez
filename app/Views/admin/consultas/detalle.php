<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Consulta #<?= $consulta['id_consulta'] ?></h2>
        <div>
            <span class="badge <?= [
                'Sin Leer' => 'bg-secondary',
                'Leida' => 'bg-primary',
                'En proceso' => 'bg-warning',
                'Resuelta' => 'bg-success'
            ][$consulta['estado']] ?>">
                <?= $consulta['estado'] ?>
            </span>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Información de la Consulta</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6>Nombre</h6>
                    <p><?= $consulta['nombre'] ?></p>
                </div>
                <div class="col-md-6">
                    <h6>Razón Social</h6>
                    <p><?= $consulta['razon_social'] ?: 'N/A' ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6>Correo Electrónico</h6>
                    <p><?= $consulta['correo'] ?></p>
                </div>
                <div class="col-md-6">
                    <h6>Teléfono</h6>
                    <p><?= $consulta['telefono'] ?: 'N/A' ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6>Asunto</h6>
                    <p><?= $consulta['asunto'] ?></p>
                </div>
                <div class="col-md-6">
                    <h6>Preferencia de Contacto</h6>
                    <p><?= ucfirst($consulta['preferencia_contacto']) ?></p>
                </div>
            </div>

            <div class="mb-3">
                <h6>Mensaje</h6>
                <div class="border p-3 bg-light rounded">
                    <?= nl2br(htmlspecialchars($consulta['mensaje'])) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6>Fecha de Creación</h6>
                    <p><?= date('d/m/Y H:i', strtotime($consulta['fecha_creacion'])) ?></p>
                </div>
                <div class="col-md-6">
                    <h6>Última Actualización</h6>
                    <p><?= $consulta['fecha_actualizacion'] ? date('d/m/Y H:i', strtotime($consulta['fecha_actualizacion'])) : 'N/A' ?></p>
                </div>
            </div>

            <form id="status-form" action="<?= base_url('admin/consultas/actualizar-estado/'. $consulta['id_consulta']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-8">
                        <select class="form-select" name="estado" id="estado-consulta">
                            <option value="Sin Leer" <?= $consulta['estado'] == 'Sin Leer' ? 'selected' : '' ?>>Sin Leer</option>
                            <option value="Leida" <?= $consulta['estado'] == 'Leida' ? 'selected' : '' ?>>Leída</option>
                            <option value="En proceso" <?= $consulta['estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                            <option value="Resuelta" <?= $consulta['estado'] == 'Resuelta' ? 'selected' : '' ?>>Resuelta</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Actualizar Estado</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="<?= base_url('admin/consultas/listar') ?>" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusForm = document.getElementById('status-form');
    
    statusForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const consultaId = <?= $consulta['id_consulta'] ?>;
        
        fetch(`<?= base_url('admin/consultas/actualizar-estado/') ?>${consultaId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: new URLSearchParams(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Actualizar el badge de estado
                const badge = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4 .badge');
                badge.className = 'badge ' + data.badge_class;
                badge.textContent = data.estado;
                
                // Mostrar mensaje de éxito
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success mt-3';
                alertDiv.textContent = data.message;
                statusForm.parentNode.insertBefore(alertDiv, statusForm.nextSibling);
                
                // Eliminar el mensaje después de 3 segundos
                setTimeout(() => alertDiv.remove(), 3000);
            } else {
                alert(data.message || 'Error al actualizar el estado');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
    });
});
</script>