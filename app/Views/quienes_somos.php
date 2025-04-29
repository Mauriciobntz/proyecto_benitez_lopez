<!--
2. Quiénes Somos
La página de nombre Quiénes Somos, deberá explicar con mayor detalle los
objetivos de la empresa y su trayectoria. Además, debería contener
información sobre el Staff o equipo que conforman la misma.
-->


<section class="container my-5">
    <!-- Título principal -->
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5">Conocé más sobre nosotros</h2>
        <p class="lead text-muted">Nuestra historia, nuestro propósito, nuestro equipo.</p>
    </div>

    <!-- Quiénes somos -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 order-2 order-lg-1">
            <div class="text-center text-lg-start">
                <h3 class="fw-bold">Quiénes Somos</h3>
                <p class="text-muted">
                    Somos una empresa de comercio electrónico con sede en Corrientes Capital, expandiéndonos hacia toda la región del NEA. Nuestra pasión es conectar personas con productos de manera ágil, segura y accesible, utilizando la tecnología para potenciar el desarrollo local.
                </p>
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 text-center">
            <img src="<?php echo base_url('assets/img/nosotros.jpg'); ?>" class="img-fluid rounded-4 shadow-sm animate__animated animate__fadeInRight" alt="Imagen Quiénes Somos">
        </div>
    </div>

    <!-- Nuestra misión -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 text-center">
            <img src="<?php echo base_url('assets/img/mision.jpg'); ?>" class="img-fluid rounded-4 shadow-sm animate__animated animate__fadeInLeft" alt="Imagen Misión">
        </div>
        <div class="col-lg-6">
            <div class="text-center text-lg-start">
                <h3 class="fw-bold">Nuestra Misión</h3>
                <p class="text-muted">
                    Brindar soluciones de e-commerce adaptadas al mercado regional, garantizando calidad, confianza y promoviendo el crecimiento digital en el interior del país.
                </p>
            </div>
        </div>
    </div>

    <!-- Nuestra visión -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 order-2 order-lg-1">
            <div class="text-center text-lg-start">
                <h3 class="fw-bold">Nuestra Visión</h3>
                <p class="text-muted">
                    Convertirnos en líderes del comercio electrónico en el NEA, apostando a la innovación constante, la eficiencia logística y relaciones de largo plazo con nuestros clientes y aliados estratégicos.
                </p>
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 text-center">
            <img src="<?php echo base_url('assets/img/vision.jpg'); ?>" class="img-fluid rounded-4 shadow-sm animate__animated animate__fadeInRight" alt="Imagen Visión">
        </div>
    </div>

    <!-- Nuestro equipo -->
    <div class="py-5 container-fluid" style="background-color: #f8f9fa; border-radius: 1rem;">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Nuestro Equipo</h3>
            <p class="text-muted">Profesionales apasionados, creativos y comprometidos con el crecimiento regional.</p>
        </div>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4 animate__animated animate__pulse">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <img src="<?php echo base_url('assets/img/staff1.jpg'); ?>" class="card-img-top rounded-top" alt="Director General">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Juan Pérez</h5>
                        <div class="text-muted mb-2">Director General</div>
                        <p class="small text-muted">Visionario y líder en estrategia de expansión regional.</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 animate__animated animate__pulse">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <img src="<?php echo base_url('assets/img/staff2.jpg'); ?>" class="card-img-top rounded-top" alt="Responsable Comercial">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">María Gómez</h5>
                        <div class="text-muted mb-2">Responsable Comercial</div>
                        <p class="small text-muted">Generadora de conexiones sólidas con clientes y socios.</p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 animate__animated animate__pulse">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <img src="<?php echo base_url('assets/img/staff3.jpg'); ?>" class="card-img-top rounded-top" alt="CTO">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Lucas Fernández</h5>
                        <div class="text-muted mb-2">CTO - Jefe de Tecnología</div>
                        <p class="small text-muted">Innovador y apasionado de la transformación digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
