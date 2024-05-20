function validarFormularioRegister() {
    var nombres = document.getElementById('nombres_u').value.trim();
    var apellidos = document.getElementById('apellidos_u').value.trim();
    var correo = document.getElementById('correo2').value.trim();
    var contrasena = document.getElementById('contrasena').value.trim();
    var usuario = document.getElementById('usuario').value.trim();
    var celular = document.getElementById('celular').value.trim();
    var tipoDocumento = document.getElementById('tipo_documento_u').value;
    var identificacion = document.getElementById('id_usuario').value.trim();
    var tipoUsuario = document.getElementById('id_rol').value;
    var checkboxTerminos = document.getElementById('cbtest-19').checked;
    var checkboxDatos = document.getElementById('cbtest-20').checked;

    // Validar campos vacíos
    if (
      nombres === '' ||
      apellidos === '' ||
      correo === '' ||
      contrasena === '' ||
      usuario === '' ||
      celular === '' ||
      tipoDocumento === '' ||
      identificacion === '' ||
      tipoUsuario === '' ||
      !checkboxTerminos ||
      !checkboxDatos
    ) {
      Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Por favor, complete todos los campos y acepte los términos y condiciones.'
      })
      return false; // Evitar que se envíe el formulario
    }

    // Si todo está validado, se enviará el formulario
    return true;
}

function validarFormularioLogin() {
    var correo = document.getElementById('correo').value.trim();
    var contrasena = document.getElementById('password').value.trim();

    if (correo === '' || contrasena === '') {
        Swal.mixin({
            toast: true,
            position: 'top-end', // Cambia la posición a la izquierda
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            onOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          }).fire({
            icon: 'warning',
            title: 'Por favor, completa ambos campos.'
          })
        return false; // Evitar que se envíe el formulario
    }

    // Si todo está validado, se enviará el formulario
    return true;
}