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


if (isset($_GET['id_stock'], $_GET['id_producto'])) {
    $id_stock = (isset($_GET['id_stock'])) ? $_GET['id_stock'] : "";
    $id_producto = (isset($_GET['id_producto'])) ? $_GET['id_producto'] : "";

    $eliminar_registro = "DELETE FROM tbl_stock WHERE id_producto = :id_producto AND id_stock =:id_stock";
    $stmt_delete = $conexion->prepare($eliminar_registro);
    $stmt_delete->bindParam(':id_producto', $id_producto);
    $stmt_delete->bindParam(':id_stock', $id_stock);
    $stmt_delete->execute();

    $mensaje = "La referencia ha sido eliminada correctamente.";
    header("Location: mis_productos.php?mensaje=" . $mensaje);
}
