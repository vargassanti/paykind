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
  // Obtenemos el método de pago seleccionado
  var metodoPago = document.getElementById("metodo_pago").value;

  // Validamos el campo de imagen de transferencia basado en el método de pago seleccionado
  if (metodoPago === "Transferencia Daviplata") {
    var imagenDaviplata = document.getElementById("imagen_transferencia_daviplata").value;
    if (imagenDaviplata === "") {
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Adjunta el comprobante de la transferencia para Daviplata.'
      })
      return false; // Evita el envío del formulario si falta la imagen
    }
  } else if (metodoPago === "Transferencia Ahorros Bancolombia") {
    var imagenBancolombia = document.getElementById("imagen_transferencia_bancolombia").value;
    if (imagenBancolombia === "") {
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Adjunta el comprobante de la transferencia para Bancolombia.'
      })
      return false; 
    }
  }

  return true;
}
