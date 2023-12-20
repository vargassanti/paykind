/* FUNCION EN JAVASCRIPT PERMITE VALIDAR EL INPUT FILE , CONTROLAMOS SUBIDAS UNICAMENTE IMGANES CON ESTAS REFERENCIAS */
function validarImg(event) {
  var btn_enviar = document.getElementById('img_producto')
  var ruta = btn_enviar.value
  var extenciones = /(.jpg|.png|.jpeg)$/i

  if (!extenciones.exec(ruta)) {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    Toast.fire({
      icon: 'error',
      title: 'Debes subir solo imagenes tipo png, jpg o jpeg.'
    })
    btn_enviar.value = ''
    return false
  }
}