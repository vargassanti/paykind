// Obtener todas las imágenes con la clase 'imagenn'
const imagenes = document.querySelectorAll('.imagenn');

// Función para cambiar la imagen al pasar el mouse sobre ella
function cambiarImagen(event) {
    const imagen = event.target;
    const dataSrcHover = imagen.getAttribute('data-src-hover');
    if (dataSrcHover) {
        imagen.setAttribute('data-src-original', imagen.src);
        imagen.src = dataSrcHover;
    }
}

// Función para volver a la imagen original cuando se retira el mouse
function restaurarImagen(event) {
    const imagen = event.target;
    const originalSrc = imagen.getAttribute('data-src-original');
    if (originalSrc) {
        imagen.src = originalSrc;
    }
}

// Asignar eventos a cada imagen
imagenes.forEach(imagen => {
    imagen.addEventListener('mouseover', cambiarImagen);
    imagen.addEventListener('mouseout', restaurarImagen);
});