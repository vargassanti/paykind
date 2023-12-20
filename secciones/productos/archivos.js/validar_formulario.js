function validarFormulario() {
    // Obtener todos los elementos radio con name="color_producto"
    var opcionesColor = document.getElementsByName("id_stock");

    // Verificar si al menos una opción está seleccionada
    var seleccionado = false;
    for (var i = 0; i < opcionesColor.length; i++) {
        if (opcionesColor[i].checked) {
            seleccionado = true;
            break;
        }
    }

    // Mostrar un mensaje de alerta si no hay ninguna opción seleccionada
    if (!seleccionado) {
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
            title: 'Selecciona un color antes de añadir al carrito.'
          })
        return false; // Evitar que se envíe el formulario
    }

    return true; // Permitir que se envíe el formulario
}