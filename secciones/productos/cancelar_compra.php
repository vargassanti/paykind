<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['id_compra'])) {
    $id_compra = (isset($_GET['id_compra'])) ? $_GET['id_compra'] : "";

    $update_detalle_compra = "UPDATE tbl_compra_producto SET estado_carrito = 'Cancelado' WHERE id_compra = :id_compra";
    $stmt_update = $conexion->prepare($update_detalle_compra);
    $stmt_update->bindParam(':id_compra', $id_compra);
    $stmt_update->execute();

    $mensaje = "La compra ha sido cancelada correctamente";
    header("Location: info_compras_clientes.php?c=cancelado&mensaje=" . urlencode($mensaje));
}
