// Llamamos el inputPrecio con el id precio
var inputPrecio = document.getElementById("precio");

// Llamamos el inputDescuento con el id descuento
var inputDescuento = document.getElementById("descuento");

// Llamamos el inputUnidades con el id unidades
var inputUnidades = document.getElementById("cantidad_unidades");

// Llamamos el inputNittienda con el id nit_identificacion
var inputTienda = document.getElementById("nit_identificacion");

// Función para eliminar los numero del campo precio
inputPrecio.addEventListener("input", function(event) {
  var inputValue = this.value;
  var newValue = inputValue.replace(/[^0-9]/g, "");
  this.value = newValue;
});

// Función para eliminar los numero del campo descuento
inputDescuento.addEventListener("input", function(event) {
  var inputValue = this.value;
  var newValue = inputValue.replace(/[^0-9]/g, "");
  this.value = newValue;
});

// Función para eliminar los numero del campo unidades
inputUnidades.addEventListener("input", function(event) {
  var inputValue = this.value;
  var newValue = inputValue.replace(/[^0-9]/g, "");
  this.value = newValue;
});

// Función para eliminar los numero del campo nit_identificacion
inputTienda.addEventListener("input", function(event) {
  var inputValue = this.value;
  var newValue = inputValue.replace(/[^0-9]/g, "");
  this.value = newValue;
});
