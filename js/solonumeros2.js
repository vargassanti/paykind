// Obtener el elemento input con ID "celular"
var inputCelular = document.getElementById("celular");

// Obtener el elemento input con ID "id_usuario"
var inputUsuario = document.getElementById("id_usuario");

// Agregar un evento que detecte cualquier cambio en el input del campo "celular"
inputCelular.addEventListener("input", function(event) {
  // Obtener el valor del input
  var inputValue = this.value;

  // Reemplazar cualquier carácter no numérico con una cadena vacía
  var newValue = inputValue.replace(/[^0-9]/g, "");

  // Actualizar el valor del input
  this.value = newValue;
});

// Agregar un evento que detecte cualquier cambio en el input del campo "id_usuario"
inputUsuario.addEventListener("input", function(event) {
  // Obtener el valor del input
  var inputValue = this.value;

  // Reemplazar cualquier carácter no numérico con una cadena vacía
  var newValue = inputValue.replace(/[^0-9]/g, "");

  // Actualizar el valor del input
  this.value = newValue;
});
