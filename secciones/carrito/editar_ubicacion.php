<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    // El usuario ha iniciado sesión y su rol es "cliente", permite el acceso al contenido actual
} else {
    header("Location: ../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];
    
    $actualizar = $conexion->prepare("UPDATE tbl_usuario SET direccion =:direccion, barrio =:barrio WHERE id_usuario =:id_usuario");
    $actualizar->bindParam(":direccion", $direccion);
    $actualizar->bindParam(":barrio", $barrio);
    $actualizar->bindParam(":id_usuario", $id_usuario);
    $actualizar->execute();

    $mensaje = "Ubicación actualizada correctamente." ;
    header("location: finalizar_compra.php?mensaje= " . $mensaje);

} else {
    header("location: ../../index.php");
}
