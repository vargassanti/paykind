<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}
include("../../bd.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_stock = (isset($_POST["id_stock"]) ? $_POST["id_stock"] : "");
    $id_producto = (isset($_POST["id_producto"]) ? $_POST["id_producto"] : "");
    $cantidad_disponible = (isset($_POST["cantidad_disponible"]) ? $_POST["cantidad_disponible"] : "");
    $color_producto = (isset($_POST["color_producto"]) ? $_POST["color_producto"] : "");

    $editar_stock = $conexion->prepare("UPDATE tbl_stock SET cantidad_disponible =:cantidad_disponible, color_producto =:color_producto WHERE id_producto =:id_producto AND id_stock =:id_stock");
    $editar_stock->bindParam(":cantidad_disponible", $cantidad_disponible);
    $editar_stock->bindParam(":color_producto", $color_producto);
    $editar_stock->bindParam(":id_producto", $id_producto);
    $editar_stock->bindParam(":id_stock", $id_stock);
    $editar_stock->execute();

    $mensaje = "Referencia actualizada";
    header("location:mis_productos.php?mensaje=" . $mensaje);
    exit();
}
