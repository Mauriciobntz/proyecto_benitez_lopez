<section>
    <?php
    $carruselModel = new \App\Models\CarruselModel();
    $slides = $carruselModel->getSlidesActivos();
    ?>
    
    <?php if(!empty($slides)): ?>
    <div id="carouselExample" class="carousel slide mt-3 rounded-pill overflow-hidden">
        <div class="carousel-inner">
            <?php foreach($slides as $index => $slide): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <?php if($slide['enlace']): ?>
                        <a href="<?= $slide['enlace'] ?>">
                    <?php endif; ?>
                    
                    <img src="<?= base_url('public/uploads/carrusel/'.$slide['imagen']) ?>" class="d-block w-100" alt="<?= esc($slide['titulo']) ?>">
                    
                    <?php if($slide['enlace']): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var myCarousel = new bootstrap.Carousel(document.getElementById('carouselExample'), {
        interval: 3000, // Cambia cada 3 segundos (3000 ms)
        ride: 'carousel' // Para comportamiento automático
    });
});
</script>