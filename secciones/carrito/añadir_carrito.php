<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    include("../../bd.php");
    require '../../config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_producto = $_POST['id_producto'];
        $id_stock = $_POST['id_stock'];
    }

    $id_usuario = $_SESSION['usuario_id'];

    // Buscar detalles de compra con el mismo producto y STOCK
    $detalle_compra = $conexion->prepare("SELECT d.id_carrito, d.cantidad, s.color_producto, d.estado_carrito
    FROM tbl_carrito as d
    INNER JOIN tbl_stock as s ON s.id_stock = d.id_stock
    INNER JOIN tbl_productos as p ON d.id_producto = p.id_producto
    INNER JOIN tbl_usuario as u ON d.id_usuario = u.id_usuario
    WHERE p.id_producto = :id_producto 
    AND s.id_stock = :id_stock
    AND d.id_usuario =:id_usuario
    AND d.estado_carrito = 'Pendiente'");
    $detalle_compra->bindParam(":id_producto", $id_producto);
    $detalle_compra->bindParam(":id_stock", $id_stock);
    $detalle_compra->bindParam(":id_usuario", $id_usuario);
    $detalle_compra->execute();
    $d_c = $detalle_compra->fetch(PDO::FETCH_ASSOC);

    if ($d_c) {
        // Si existe, actualiza la cantidad
        $contador = $d_c['cantidad'] + 1;
        $id_carrito = $d_c['id_carrito'];
        $cantidad = $conexion->prepare("UPDATE tbl_carrito SET cantidad = :cantidad WHERE id_carrito = :id_carrito");
        $cantidad->bindParam(":cantidad", $contador);
        $cantidad->bindParam(":id_carrito", $id_carrito);
        $cantidad->execute();
    } else {
        // Si no existe, inserta un nuevo registro
        $cantidad = 1;

        $sql = $conexion->prepare("INSERT INTO tbl_carrito(id_producto, cantidad, id_stock, id_usuario) VALUES (:id_producto, :cantidad, :id_stock, :id_usuario)");
        $sql->bindParam(":id_producto", $id_producto);
        $sql->bindParam(":cantidad", $cantidad);
        $sql->bindParam(":id_stock", $id_stock);
        $sql->bindParam(":id_usuario", $id_usuario);
        $sql->execute();
    }
    $mensaje = "Producto añadido correctamente.";
    header("Location: ../productos/productos_carrito.php?mensaje=" . $mensaje);
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

?>

