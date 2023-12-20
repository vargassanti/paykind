// Obtener elementos del DOM
var botonMostrarModalTerminos = document.getElementById('mostrarModalTerminos');
var botonMostrarModalPreguntas = document.getElementById('mostrarModalPreguntas');
var modalTerminos = document.getElementById('modalTerminos');
var modalPreguntas = document.getElementById('modalPreguntas');
var botonesCerrarModal = document.querySelectorAll('.cerrarModal');
var botonesCerrarModalContenido = document.querySelectorAll('.cerrarBtn');

// Mostrar modal de Términos al hacer clic en el elemento correspondiente
botonMostrarModalTerminos.addEventListener('click', function() {
  modalTerminos.style.display = 'block';
});

// Mostrar modal de Preguntas al hacer clic en el elemento correspondiente
botonMostrarModalPreguntas.addEventListener('click', function() {
  modalPreguntas.style.display = 'block';
});

// Cerrar modales al hacer clic en los botones de cierre respectivos
botonesCerrarModal.forEach(function(botonCerrar) {
  botonCerrar.addEventListener('click', function() {
    modalTerminos.style.display = 'none';
    modalPreguntas.style.display = 'none';
  });
});

// Cerrar modales al hacer clic en los botones de cierre dentro del contenido del modal
botonesCerrarModalContenido.forEach(function(botonCerrarContenido) {
  botonCerrarContenido.addEventListener('click', function() {
    modalTerminos.style.display = 'none';
    modalPreguntas.style.display = 'none';
  });
});

// Cerrar modales al hacer clic fuera del área del modal respectivo
window.addEventListener('click', function(event) {
  if (event.target == modalTerminos) {
    modalTerminos.style.display = 'none';
  }
  if (event.target == modalPreguntas) {
    modalPreguntas.style.display = 'none';
  }
});
