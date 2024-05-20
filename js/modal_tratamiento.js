// Obtener elementos del DOM
const botonTratamientoDatos1 = document.getElementById('botonTratamientoDatos1');
const botonTratamientoDatos2 = document.getElementById('botonTratamientoDatos2');
const modalTratamientos = document.getElementById('modalTratamientoTerminos');
var botonesCerrarModal = document.querySelectorAll('.cerrarModal');
var botonesCerrarModalContenido = document.querySelectorAll('.cerrarBtn');

// Función para mostrar el modal
function mostrarModal() {
    modalTratamientos.style.display = 'block';
}

// Mostrar modal al hacer clic en el botón 1
botonTratamientoDatos1.addEventListener('click', mostrarModal);

// Mostrar modal al hacer clic en el botón 2
botonTratamientoDatos2.addEventListener('click', mostrarModal);

// Ocultar modal al hacer clic en el botón de cerrar (×) o fuera del modal
botonesCerrarModal.forEach(function(botonCerrar) {
    botonCerrar.addEventListener('click', function() {
      modalTratamientos.style.display = 'none';
    });
});

botonesCerrarModalContenido.forEach(function(botonCerrarContenido) {
    botonCerrarContenido.addEventListener('click', function() {
      modalTratamientos.style.display = 'none';
    });
});
  
window.addEventListener('click', (event) => {
  if (event.target === modal) {
    modalTratamientos.style.display = 'none';
  }
});
