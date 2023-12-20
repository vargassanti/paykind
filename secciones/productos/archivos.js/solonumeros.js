var inputCantidadD = document.getElementById("cantidad_disponible");

inputCantidadD.addEventListener("input", function(event) {
  var inputValue = this.value;

  var newValue = inputValue.replace(/[^0-9]/g, "");

  this.value = newValue;
});
