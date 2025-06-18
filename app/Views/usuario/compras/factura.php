<?php
// Eliminamos la extensión del layout ya que usaremos la concatenación de vistas
?>
<div class="container py-5">
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= base_url('public/uploads/config/'.$configuracion['logo_url'] ?? 'Follow S.A.') ?>" alt="Logo" class="mb-3" height="50">
                    <p>
                        <strong><?= esc($configuracion['nombre_empresa'] ?? 'Follow S.A.') ?></strong><br>
                        <?= esc($configuracion['direccion'] ?? '9 de Julio 1813, Corrientes') ?><br>
                        <?= esc($configuracion['ciudad'] ?? 'Argentina') ?><br>
                        Tel: <?= esc($configuracion['telefono'] ?? '(+54 379) 400-0000') ?><br>
                        Email: <?= esc($configuracion['email'] ?? 'soporte@follow.com.ar') ?><br>
                        CUIT: <?= esc($configuracion['cuit'] ?? '30-12345678-9') ?>
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <h2 class="invoice-title">FACTURA</h2>
                    <p>
                        <strong>N°:</strong> <?= str_pad($pedido['id_venta'], 8, '0', STR_PAD_LEFT) ?><br>
                        <strong>Fecha:</strong> <?= date('d/m/Y', strtotime($pedido['fecha_venta'])) ?><br>
                        <strong>Cliente:</strong> #<?= $usuario['id_usuario'] ?? 'N/A' ?><br>
                        <?php if (isset($usuario['persona'])): ?>
                            <strong><?= esc($usuario['persona']['tipo_documento'] ?? 'DNI') ?>:</strong> <?= esc($usuario['persona']['documento'] ?? 'N/A') ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Datos del Cliente</h5>
                <p>
                    <?php if (isset($usuario['persona'])): ?>
                        <strong><?= esc($usuario['persona']['nombre'] ?? '') ?> <?= esc($usuario['persona']['apellido'] ?? '') ?></strong><br>
                        <?= esc($usuario['persona']['tipo_documento'] ?? 'DNI') ?>: <?= esc($usuario['persona']['documento'] ?? 'N/A') ?><br>
                    <?php endif; ?>
                    <?php if (isset($direccion)): ?>
                        <?= esc($direccion['direccion'] ?? '') ?><br>
                        <?= esc($direccion['ciudad'] ?? '') ?>, <?= esc($direccion['provincia'] ?? '') ?> <?= esc($direccion['codigo_postal'] ?? '') ?><br>
                        <?= esc($direccion['pais'] ?? '') ?><br>
                    <?php endif; ?>
                    <?php if (isset($usuario['persona']['telefono'])): ?>
                        Tel: <?= esc($usuario['persona']['telefono']) ?>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-md-6">
                <h5>Detalles del Pedido</h5>
                <p>
                    <strong>Pedido #<?= $pedido['id_venta'] ?></strong><br>
                    Fecha: <?= date('d/m/Y', strtotime($pedido['fecha_venta'])) ?><br>
                    <?php if (isset($pago)): ?>
                        Método de Pago: <?= esc(ucfirst(strtolower($pago['metodo_pago'] ?? 'No especificado'))) ?><br>
                        Estado del Pago: <?= ucfirst($pago['estado'] ?? 'No especificado') ?><br>
                        <?php if (isset($pago['fecha_pago'])): ?>
                            Fecha de Pago: <?= date('d/m/Y H:i', strtotime($pago['fecha_pago'])) ?><br>
                        <?php endif; ?>
                    <?php endif; ?>
                    Estado del Pedido: <?= ucfirst($pedido['estado'] ?? 'No especificado') ?>
                </p>
            </div>
        </div>
        
        <table class="table table-invoice table-bordered mb-4">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-end">Precio Unitario</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($items) && !empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['nombre'] ?? '') ?> - <?= esc($item['descripcion'] ?? '') ?></td>
                            <td class="text-end">$<?= number_format($item['precio_unitario'] ?? 0, 2) ?></td>
                            <td class="text-center"><?= $item['cantidad'] ?? 0 ?></td>
                            <td class="text-end">$<?= number_format(($item['precio_unitario'] ?? 0) * ($item['cantidad'] ?? 0), 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay productos en este pedido</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <?php 
                $subtotal = array_reduce($items ?? [], function($carry, $item) {
                    return $carry + (($item['precio_unitario'] ?? 0) * ($item['cantidad'] ?? 0));
                }, 0);
                ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                    <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                </tr>
                <tr class="table-active">
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end fw-bold">$<?= number_format($pedido['total'] ?? $subtotal, 2) ?></td>
                </tr>
            </tfoot>
        </table>
        
        <div class="text-center mt-4">
            <p>Gracias por su compra. Para cualquier consulta, contáctenos a <?= esc($configuracion['email'] ?? 'soporte@follow.com.ar') ?></p>
            <div class="d-flex justify-content-center gap-3">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Imprimir Factura
                </button>
                <a href="<?= base_url('perfil/pedidos/' . $pedido['id_venta']) ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Pedido
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .invoice-header {
        border-bottom: 2px solid #0d6efd;
        margin-bottom: 20px;
    }
    .invoice-title {
        color: #0d6efd;
    }
    .table-invoice {
        width: 100%;
    }
    .table-invoice th {
        background-color: #f8f9fa;
    }
    @media print {
        .btn {
            display: none;
        }
        .invoice-container {
            box-shadow: none;
            border: none;
        }
    }
</style> 