document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggleButton');
    const ubicacionContenido = document.getElementById('ubicacionContenido');

    // Verificar si hay un estado guardado en el almacenamiento local
    const ocultarUbicacion = localStorage.getItem('ocultarUbicacion');
    if (ocultarUbicacion === 'true') {
        ubicacionContenido.style.display = 'none'; // Mantener oculto si se ha guardado en el almacenamiento local
    }

    toggleButton.addEventListener('click', function () {
        // Alternar la visibilidad del contenido
        if (ubicacionContenido.style.display === 'none') {
            ubicacionContenido.style.display = 'block';
            localStorage.removeItem('ocultarUbicacion'); // Mostrar el contenido y eliminar el estado del almacenamiento local
        } else {
            ubicacionContenido.style.display = 'none';
            localStorage.setItem('ocultarUbicacion', 'true'); // Ocultar el contenido y guardar el estado en el almacenamiento local
        }
    });
});