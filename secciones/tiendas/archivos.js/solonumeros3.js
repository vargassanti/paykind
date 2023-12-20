// Llamamos el inputNittienda con el id nit_identificacion
var inputTienda = document.getElementById("nit_identificacion");

// Función para eliminar los numero del campo nit_identificacion
inputTienda.addEventListener("input", function(event) {
  var inputValue = this.value;
  var newValue = inputValue.replace(/[^0-9]/g, "");
  this.value = newValue;
});
