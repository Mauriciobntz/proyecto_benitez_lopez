// Cinta Pagina Principal
document.addEventListener('DOMContentLoaded', function() {
    const marquee = document.querySelector('.js-adbar-animated');
    
    // Clona los mensajes para un efecto de bucle continuo
    marquee.innerHTML += marquee.innerHTML;
    
    // Ajusta la velocidad según el ancho del contenido
    const speed = 50; // px/seg (ajusta según necesidad)
    let position = 0;
    
    function animate() {
        position -= 1;
        if (position <= -marquee.scrollWidth / 2) {
            position = 0;
        }
        marquee.style.transform = `translateX(${position}px)`;
        requestAnimationFrame(animate);
    }
    
    animate();
});
// Fin Cinta