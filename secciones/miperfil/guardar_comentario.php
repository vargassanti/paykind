<?php
session_start();

if (isset($_SESSION['loggedin']) === true) {
    if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador" || $_SESSION["usuario_rol"] === "Cliente")) {
        // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
        // Coloca el código de la página actual a continuación
        $id_rol = $_SESSION["usuario_rol"]; // Obtener el rol del usuario
    }
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $texto = $_POST['texto'];
    $calificacion = $_POST['calificacion'];
    $id_producto = $_POST['id_producto'];
    $id_usuario = $_POST['id_usuario'];
}

$comen = $conexion->prepare("INSERT INTO tbl_calificacion(calificacion, texto, id_producto, id_usuario)
VALUES (:calificacion, :texto, :id_producto, :id_usuario)");
$comen->bindParam(":calificacion", $calificacion);
$comen->bindParam(":texto", $texto);
$comen->bindParam(":id_producto", $id_producto);
$comen->bindParam(":id_usuario", $id_usuario);
$comen->execute();
$mensaje = "Comentario agregado";
header("location: index.php?mensaje=" . $mensaje);
