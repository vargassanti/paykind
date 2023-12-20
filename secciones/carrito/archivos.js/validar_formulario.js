function mostrarInformacion() {
  var selectElement = document.getElementById("metodo_pago");
  var selectedOption = selectElement.options[selectElement.selectedIndex].value;

  divTransferenciaDaviplata.style.display = "none";
  divTransferenciaAhorrosBancolombia.style.display = "none";
  divEfectivo.style.display = "none";
  divMercadopago.style.display = "none";

  // Mostrar el div correspondiente a la opción seleccionada
  if (selectedOption === "Transferencia Daviplata") {
    document.getElementById("divTransferenciaDaviplata").style.display = "block";
  } else if (selectedOption === "Transferencia Ahorros Bancolombia") {
    document.getElementById("divTransferenciaAhorrosBancolombia").style.display = "block";
  } else if (selectedOption === "Efectivo") {
    divEfectivo.style.display = "block";
  } else if (selectedOption === "Mercadopago") {
    divMercadopago.style.display = "block";
  }
}

function validarCampos() {
  var selectElement = document.getElementById("metodo_pago");
  var selectedOption = selectElement.options[selectElement.selectedIndex].value;

  if (selectedOption === "Transferencia Daviplata") {
    var fileInput = document.getElementById("imagen_transferencia_daviplata");
    if (fileInput.style.display !== "none" && fileInput.value === "") {
      Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Recuerda subir el comprobante de pago de la transferencia.'
      })
      return false; // Evita el envío del formulario
    }
  } else if (selectedOption === "Transferencia Ahorros Bancolombia") {
    var fileInput = document.getElementById("imagen_transferencia_bancolombia");
    if (fileInput.style.display !== "none" && fileInput.value === "") {
      Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Recuerda subir el comprobante de pago de la transferencia.'
      })
      return false; // Evita el envío del formulario
    }
  }
  // Agregar validación para otras opciones si es necesario

  return true; // Permite el envío del formulario si todos los campos están validados
}