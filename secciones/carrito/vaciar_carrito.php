<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    require '../../config.php';
    include("../../bd.php");

    $id_usuario = $_SESSION["usuario_id"];

    $delete_p = $conexion->prepare("DELETE FROM tbl_carrito where estado_carrito = 'Pendiente' AND id_usuario =:id_usuario");
    $delete_p->bindParam(":id_usuario", $id_usuario);
    $delete_p->execute();
    header("Location: ../carrito/checkout.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}
