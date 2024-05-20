<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "Administrador", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} else {
    header("Location: ../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $id_usuarioo = $_POST['id_usuario'];
    $nombres_u = $_POST['nombres_u'];
    $apellidos_u = $_POST['apellidos_u'];
    $tipo_documento_u = $_POST['tipo_documento_u'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];
    $id_rol = $_POST['id_rol'];

    if ($id_rol == 'Cliente') {
        $tabla = 'tbl_usuario';
    } elseif ($id_rol == 'Vendedor') {
        $tabla = 'tbl_vendedor';
    } elseif ($id_rol == 'Administrador') {
        $tabla = 'tbl_administrador';
    } else {
        echo "El rol seleccionado no es válido.";
        exit;
    }

    $sql = "UPDATE $tabla SET usuario = :usuario, nombres_u = :nombres_u, apellidos_u = :apellidos_u, tipo_documento_u = :tipo_documento_u, correo = :correo, celular = :celular, direccion = :direccion, barrio = :barrio WHERE id_usuario = :id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':nombres_u', $nombres_u);
    $stmt->bindParam(':apellidos_u', $apellidos_u);
    $stmt->bindParam(':tipo_documento_u', $tipo_documento_u);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':barrio', $barrio);
    $stmt->bindParam(':id_usuario', $id_usuarioo);
    $stmt->execute();
    $mensaje = "Datos actualizados correctamente.";
    header("location:index.php?mensaje=" . $mensaje);
    exit();
}
