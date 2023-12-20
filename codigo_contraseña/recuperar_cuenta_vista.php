<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>Paykind</title>
    <link rel="stylesheet" href="../css/estilos_recuperar_c.css">
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
                    <h2>Bienvenido
                        <?php foreach ($info_usuario as $info) { ?>
                            <p><?php echo $info['nombres_u']; ?> <?php echo $info['apellidos_u']; ?></p>
                        <?php } ?>
                    </h2>
                    <form action="restablecer_contraseña.php" method="post" onsubmit="return validarContrasenas()">
                        <p class="forget">
                            Ya puedes ingresar tu nueva contraseña, asegurate de que las contraseñas coincidan
                        </p>
                        <div class="inputBox">
                            <input type="hidden" name="token" value="<?php echo $token ?>">
                            <input type="password" id="password1" name="nueva_contrasena" placeholder="Nueva contraseña" required>
                            <img class="password-toggle1" id="togglePassword1" src="../img/ocultar_contraseña.png" alt="Mostrar Contraseña">
                            <br><br>
                            <input type="password" id="password2" name="nueva_contrasena" placeholder="Repite la contraseña" required>
                            <img class="password-toggle2" id="togglePassword2" src="../img/ocultar_contraseña.png" alt="Mostrar Contraseña">
                        </div>
                        <div class="inputBox">
                            <button type="submit" name="btn_actualizar" id="btn2" class="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75">
                                    </path>
                                </svg>
                                <div class="text">
                                    Actualizar
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="../js/ver_contraseña.js"></script>
<script>
    function validarContrasenas() {
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;

        if (password1 !== password2) {
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
                icon: 'error',
                title: 'Las contraseñas que ingresaste, no coinciden.'
            })
            return false;
        }

        return true;
    }
</script>