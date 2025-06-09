<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Ventas Hoy</h6>
                            <h3 class="card-text">€1,245</h3>
                        </div>
                        <i class="bi bi-currency-euro" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Pedidos Hoy</h6>
                            <h3 class="card-text">12</h3>
                        </div>
                        <i class="bi bi-cart" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Productos</h6>
                            <h3 class="card-text">45</h3>
                        </div>
                        <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Clientes</h6>
                            <h3 class="card-text">128</h3>
                        </div>
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Últimos Pedidos</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1001</td>
                                    <td>Juan Pérez</td>
                                    <td>22/05/2025</td>
                                    <td>€599.99</td>
                                    <td><span class="badge bg-success">Entregado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#1002</td>
                                    <td>María Gómez</td>
                                    <td>23/05/2025</td>
                                    <td>€1,398.00</td>
                                    <td><span class="badge bg-info">Enviado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Productos con poco stock</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Smart TV 55"
                            <span class="badge bg-warning rounded-pill">5 unidades</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Auriculares Bluetooth
                            <span class="badge bg-warning rounded-pill">3 unidades</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Ratón Inalámbrico
                            <span class="badge bg-warning rounded-pill">2 unidades</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Últimas reseñas</div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>Smartphone X</strong>
                            <div>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                        </div>
                        <p class="small mb-1">"Excelente teléfono, muy rápido y buena cámara"</p>
                        <p class="small text-muted">Por Juan Pérez - 25/05/2025</p>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>Smart TV 55"</strong>
                            <div>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star text-warning"></i>
                            </div>
                        </div>
                        <p class="small mb-1">"Buena calidad de imagen, pero el sonido podría mejorar"</p>
                        <p class="small text-muted">Por María Gómez - 26/05/2025</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>