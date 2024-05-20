// Obtener el enlace y el modal por su ID
var enlaceEditarFoto = document.getElementById("enlaceEditarFoto");
var modalEditarFoto = document.getElementById("modalEditarFoto");

// Cuando se haga clic en el enlace, mostrar el modal
enlaceEditarFoto.addEventListener("click", function(event) {
  event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
  modalEditarFoto.style.display = "block"; // Mostrar el modal
});

// Obtener el botón para cerrar el modal
var cerrarModal = document.getElementsByClassName("cerrar-modal")[0];

// Cuando se haga clic en la 'X', ocultar el modal
cerrarModal.addEventListener("click", function() {
  modalEditarFoto.style.display = "none"; // Ocultar el modal
});
