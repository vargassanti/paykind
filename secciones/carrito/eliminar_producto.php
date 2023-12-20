<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    // El usuario ha iniciado sesión y su rol es "cliente", permite el acceso al contenido actual
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

require '../../config.php';
include("../../bd.php");

$id_carrito = $_GET['id_carrito'];

if ($_GET['id_carrito']) {
    $delete_p = $conexion->prepare("DELETE FROM tbl_carrito WHERE id_carrito = :id_carrito");
    $delete_p->bindParam(":id_carrito", $id_carrito); 
    $delete_p->execute();
    header("Location: ../carrito/checkout.php");
}
