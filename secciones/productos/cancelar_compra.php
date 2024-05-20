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

    $consultas_c = "SELECT c.*, p.*, s.*
    FROM tbl_compra as c
    INNER JOIN tbl_compra_producto as p ON p.id_compra = c.id_compra
    INNER JOIN tbl_stock as s ON s.id_stock = p.id_stock
    WHERE c.id_compra = :id_compra";           
    $consultas_cantidad_st = $conexion->prepare($consultas_c);
    $consultas_cantidad_st->bindParam(':id_compra', $id_compra);
    $consultas_cantidad_st->execute();
    $productos_c = $consultas_cantidad_st->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productos_c as $cantidad_s) {
        $id_producto = $cantidad_s['id_producto'];
        $cantidad = $cantidad_s['cantidad'];
        $cantidad_disponible = $cantidad_s['cantidad_disponible'];
        $id_stock = $cantidad_s['id_stock'];

        if ($cantidad_disponible >= $cantidad) {
            // Restar la cantidad comprada a la cantidad disponible
            $nuevaCantidad = $cantidad_disponible + $cantidad;

            // Actualizar la cantidad disponible en la base de datos
            $updateStock = $conexion->prepare("UPDATE tbl_stock SET cantidad_disponible = :nuevaCantidad WHERE id_producto = :id_producto AND id_stock = :id_stock");
            $updateStock->bindParam(':nuevaCantidad', $nuevaCantidad);
            $updateStock->bindParam(':id_producto', $id_producto);
            $updateStock->bindParam(':id_stock', $id_stock);
            $updateStock->execute();
        } else {
            echo "No hay suficiente cantidad disponible para realizar la compra.";
        }
    }

    $mensaje = "La compra ha sido cancelada correctamente";
    header("Location: info_compras_clientes.php?c=cancelado&mensaje=" . urlencode($mensaje));
}
