// JavaScript para abrir y cerrar el modal
const botonEditarUbicacion = document.querySelector('.editar_ubicacion');
const modalUbicacion = document.getElementById('modalUbicacion');
const botonCerrarModal = document.querySelector('.cerrar-modal');

// Función para mostrar el modal
botonEditarUbicacion.addEventListener('click', () => {
    modalUbicacion.style.display = 'block';
});

// Función para cerrar el modal
botonCerrarModal.addEventListener('click', () => {
    modalUbicacion.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modalUbicacion) {
        modalUbicacion.style.display = 'none';
    }
});