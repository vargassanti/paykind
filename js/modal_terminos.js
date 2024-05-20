// Obtener elementos del DOM
var mostrarModalPreguntas = document.getElementById('botonMostrarModalTerminos1');
var botonMostrarModalTerminos2 = document.getElementById('botonMostrarModalTerminos2');
var botonesCerrarModal = document.querySelectorAll('.cerrarModal');
var botonesCerrarModalContenido = document.querySelectorAll('.cerrarBtn');

// Función para mostrar el modal de Términos
function mostrarModalTerminos() {
  modalTerminos.style.display = 'block';
}

// Mostrar modal de Términos al hacer clic en los botones correspondientes
botonMostrarModalTerminos1.addEventListener('click', mostrarModalTerminos);
botonMostrarModalTerminos2.addEventListener('click', mostrarModalTerminos);

// Cerrar modales al hacer clic en los botones de cierre respectivos
botonesCerrarModal.forEach(function(botonCerrar) {
  botonCerrar.addEventListener('click', function() {
    modalTerminos.style.display = 'none';
  });
});

// Cerrar modales al hacer clic en los botones de cierre dentro del contenido del modal
botonesCerrarModalContenido.forEach(function(botonCerrarContenido) {
  botonCerrarContenido.addEventListener('click', function() {
    modalTerminos.style.display = 'none';
  });
});

// Cerrar modal al hacer clic fuera del área del modal
window.addEventListener('click', function(event) {
  if (event.target == modalTerminos) {
    modalTerminos.style.display = 'none';
  }
});
