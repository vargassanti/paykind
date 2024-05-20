// function Exten() {
//   var btn_enviar = document.getElementById('imagen_tranferencia')
//   var ruta = btn_enviar.value
//   var extenciones = /(.jpg|.png|.jpeg)$/i

//   if (!extenciones.exec(ruta)) {
//     const Toast = Swal.mixin({
//       toast: true,
//       position: 'top-end',
//       showConfirmButton: false,
//       timer: 4000,
//       timerProgressBar: true,
//       didOpen: (toast) => {
//         toast.addEventListener('mouseenter', Swal.stopTimer)
//         toast.addEventListener('mouseleave', Swal.resumeTimer)
//       }
//     })
//     Toast.fire({
//       icon: 'error',
//       title: 'Debes subir solo imagenes tipo png, jpg o jpeg.'
//     })
//     btn_enviar.value = ''
//     return false
//   }
// }


document.addEventListener("DOMContentLoaded", function () {
  const fileInput = document.getElementById('imagen_tranferencia');
  const form = document.getElementById('miFormulario');

  form.addEventListener('submit', function (event) {
    if (fileInput.files.length === 0) {
      event.preventDefault();
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
        title: 'Por favor, debes subir un comprobante de pago para poder seguir.'
      })
    }
  });

  fileInput.addEventListener('change', function () {
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const filePath = this.value;

    if (!allowedExtensions.exec(filePath)) {
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
        title: 'Por favor, selecciona un archivo con formato válido: .jpg, .jpeg o .png.'
      })
      this.value = '';
      return false;
    }
  });
});
