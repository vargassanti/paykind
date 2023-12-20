<?php
include("../bd.php");

if (isset($_POST['btn_iniciar'])) {
    $email = $_POST['email'];
    $id_usuario = $_POST['id_usuario'];

    $r_contraseña = $conexion->prepare("SELECT * FROM tbl_usuario WHERE correo = :email AND id_usuario = :id_usuario");
    $r_contraseña->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
    $r_contraseña->bindParam(":email", $email, PDO::PARAM_STR);
    $r_contraseña->execute();
    $recuperacion = $r_contraseña->fetchAll(PDO::FETCH_ASSOC);

    if ($recuperacion) {
        // Se encontró un usuario con el correo o la identificación proporcionada
        $id_usuario = $recuperacion[0]['id_usuario']; // Acceder al primer resultado si es el único
        $correoEncontrado = $recuperacion[0]['correo'];

        // Generar un token único
        $token = md5(uniqid(rand(), true));

        // Calcular la fecha de expiración (por ejemplo, una hora en el futuro)
        $expiration_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Insertar el token en la tabla de recuperación de contraseña
        $insertQuery = $conexion->prepare("INSERT INTO tbl_restablecer_contraseña (id_usuario, token, expiration_time, used) VALUES (?, ?, ?, 0)");
        $insertQuery->execute([$id_usuario, $token, $expiration_time]);

        $nombre_usu = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario =:id_usuario");
        $nombre_usu->bindParam(":id_usuario", $id_usuario);
        $nombre_usu->execute();
        $info_usuario = $nombre_usu->fetchAll(PDO::FETCH_ASSOC);

        include("recuperar_cuenta_vista.php");
        exit; // Detiene la ejecución del script después de cargar la vista
    } else {
        header("location: olvidaste_contraseña.php?alerta=no_hay_datos");
        exit;
    }
} else {
    header("location: olvidaste_contraseña.php?alerta=ingresa_datos");
    exit;
}

?>


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
            title: 'Ingresa los datos necesarios para poder seguir.'
        })
    }

    history.replaceState({}, document.title, window.location.pathname);
</script>


<!-- HACER QUE EL VENDEDOR Y EL ADMINISTRADOR TAMBIEN PUEDAN CAMBIAR LA CONTRASEÑA
MANEJAR LAS ALERTAS 
MANEJAR QUE SOLO PUEDAN INGRESAR USUARIOS LOGUEADOS
HACER EL DISEÑO DE LAS VISTAS DE RECUPERAR CONTRASEÑA -->