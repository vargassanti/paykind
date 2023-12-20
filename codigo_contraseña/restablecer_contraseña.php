<?php
include("../bd.php");

if (isset($_POST['btn_actualizar'])) {
    $token = $_POST['token'];
    $nueva_contrasena = $_POST['nueva_contrasena'];

    // Validar el token y comprobar si ha expirado
    $resetQuery = $conexion->prepare("SELECT id_usuario FROM tbl_restablecer_contraseña WHERE token = :token AND expiration_time > NOW() AND used = 0");
    $resetQuery->bindParam(":token", $token, PDO::PARAM_STR);
    $resetQuery->execute();
    $resetData = $resetQuery->fetch();

    if ($resetData) {
        // El token es válido y no ha expirado
        $id_usuario = $resetData['id_usuario'];

        // Aplicar la misma encriptación a la nueva contraseña
        $nueva_contrasena_encriptada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        // Actualiza la contraseña en la base de datos
        $actualizarQuery = $conexion->prepare("UPDATE tbl_usuario SET password=:password WHERE id_usuario = :id_usuario");
        $actualizarQuery->bindParam(":password", $nueva_contrasena_encriptada, PDO::PARAM_STR);
        $actualizarQuery->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $actualizarQuery->execute();

        // Marca el token como utilizado
        $marcarUtilizadoQuery = $conexion->prepare("UPDATE tbl_restablecer_contraseña SET used = 1 WHERE token = :token");
        $marcarUtilizadoQuery->bindParam(":token", $token, PDO::PARAM_STR);
        $marcarUtilizadoQuery->execute();

        header("location: ../registro.php?alerta=contraseña_actualizada");
    } else {
        echo 'El enlace de restablecimiento de contraseña es inválido o ha expirado.';
    }
}else{
    header("location: recuperar_cuenta.php?alerta=no_hay_datos");
}