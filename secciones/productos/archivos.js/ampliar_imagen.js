// Función para mostrar la imagen ampliada
document.getElementById('boton-ampliar').addEventListener('click', function() {
    mostrarAmpliacion();
});

function mostrarAmpliacion() {
    var imagenOriginal = document.querySelector('.imagenn_comprobante');
    var imagenAmpliada = document.getElementById('imagen-ampliada');
    var contenedorAmpliado = document.getElementById('contenedor-ampliado');

    imagenAmpliada.src = imagenOriginal.src;
    contenedorAmpliado.style.display = 'block';
}

// Función para cerrar la imagen ampliada
function cerrarAmpliacion() {
    var contenedorAmpliado = document.getElementById('contenedor-ampliado');
    contenedorAmpliado.style.display = 'none';
}