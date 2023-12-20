<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
  <title>Paykind</title>
  <link rel="stylesheet" href="../css/estilos_olvidaste_contra.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <section>
    <div class="color"></div>
    <div class="color"></div>
    <div class="color"></div>
    <div class="box">
      <div class="container">
        <div class="form">
          <h2>Recuperar contraseña</h2>
          <form action="recuperar_cuenta.php" method="post">
            <div class="inputBox">
              <input type="text" name="email" placeholder="Correo electronico" required>
              <input type="text" name="id_usuario" placeholder="Numero de identificación" required>
            </div>
            <div class="inputBox">
              <button type="submit" name="btn_iniciar" id="btn2" class="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75">
                  </path>
                </svg>
                <div class="text">
                  Siguiente
                </div>
              </button>
            </div>
            <p class="forget">
              ¿Ya tienes una cuenta? <a href="../registro.php">Iniciar sesión</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>

</html>
<script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "no_hay_datos") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Los datos que ingresaste, no se encuentran registrados.'
      })
    }
    if (alerta == "ingresa_datos") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Ingresa los datos necesarios para poder seguir.'
      })
    }
    
    history.replaceState({}, document.title, window.location.pathname);
  </script>