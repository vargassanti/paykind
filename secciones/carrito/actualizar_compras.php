<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    // El usuario ha iniciado sesión y su rol es "cliente", permite el acceso al contenido actual
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");
require '../../config.php';

if (isset($_GET['id_carrito'], $_GET['id_producto'], $_GET['id_stock'])) {
    $id_carrito = $_GET['id_carrito'];
    $id_producto = $_GET['id_producto'];
    $id_stock = $_GET['id_stock'];

    $cantidad_p = $conexion->prepare("SELECT cantidad FROM tbl_carrito WHERE id_carrito = :id_carrito");
    $cantidad_p->bindParam(":id_carrito", $id_carrito);
    $cantidad_p->execute();
    $cantidad_nueva = $cantidad_p->fetch(PDO::FETCH_ASSOC);

    $cantidad_actual = $cantidad_nueva['cantidad'];

    if ($_GET['cantidad'] == "sumar") {
        $numero = $cantidad_actual + 1;

        $consulta = $conexion->prepare("SELECT s.cantidad_disponible 
        FROM tbl_stock AS s
        INNER JOIN tbl_productos AS p ON s.id_producto = p.id_producto
        WHERE p.id_producto=:id_producto AND s.id_stock = :id_stock");
        $consulta->bindParam(':id_producto', $id_producto);
        $consulta->bindParam(':id_stock', $id_stock);
        $consulta->execute();
        $stock_disponible = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($numero <= $stock_disponible['cantidad_disponible']) {
            // Si la cantidad a agregar no excede el stock disponible, actualiza la cantidad
            $update_suma = $conexion->prepare("UPDATE tbl_carrito SET cantidad = :cantidad WHERE id_carrito = :id_carrito");
            $update_suma->bindParam(":cantidad", $numero);
            $update_suma->bindParam(":id_carrito", $id_carrito);
            $update_suma->execute();
            header("Location:../carrito/checkout.php");
        } else {
            header("Location:../carrito/checkout.php?alerta=no_hay_productos");
        }
    } elseif ($_GET['cantidad'] == "restar") {
        // Asegurarse de que la cantidad no sea menor que 1
        if ($cantidad_actual > 1) {
            $numero = $cantidad_actual - 1;

            // No se requiere la verificación de stock al restar
            $update_restar = $conexion->prepare("UPDATE tbl_carrito SET cantidad = :cantidad WHERE id_carrito = :id_carrito");
            $update_restar->bindParam(":cantidad", $numero);
            $update_restar->bindParam(":id_carrito", $id_carrito);
            $update_restar->execute();
        }

        header("Location: ../carrito/checkout.php");
    }
} else {
    header("Location: ../carrito/checkout.php");
}
