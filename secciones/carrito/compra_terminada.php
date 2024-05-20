<?php
session_start();

include("../../bd.php");
require '../../config.php';

// Obtener el ID del usuario
$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_carrito']) && is_array($_POST['id_carrito'])) {
        $imagen_tranferencia = (isset($_FILES["imagen_tranferencia"]['name']) ? $_FILES["imagen_tranferencia"]['name'] : "");
        $total_compra = $_POST['total_compra'];
        $costo_envio = $_POST['costo_envio'];
        $direccion = $_POST['direccion'];
        $metodo_pago = $_POST['metodo_pago'];

        $consulta = $conexion->prepare("SELECT * FROM tbl_carrito WHERE id_usuario = :id_usuario");
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $total_p = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $tbl_compra = "INSERT INTO tbl_compra (total_compra, direccion, costo_envio, metodo_pago, id_usuario, imagen_tranferencia) VALUES (:total_compra, :direccion, :costo_envio, :metodo_pago, :id_usuario, :imagen_tranferencia)";
        $stmt = $conexion->prepare($tbl_compra);
        $stmt->bindParam(':total_compra', $total_compra);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':costo_envio', $costo_envio);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':id_usuario', $id_usuario);

        $fecha_ = new DateTime();

        $nombreArchivo_imagen_tranferencia = ($imagen_tranferencia != '') ? $fecha_->getTimestamp() . "_" . $_FILES["imagen_tranferencia"]["name"] : "";
        $tmp_imagen_tranferencia = $_FILES["imagen_tranferencia"]['tmp_name'];
        if ($tmp_imagen_tranferencia != '') {
            move_uploaded_file($tmp_imagen_tranferencia, "./imagenes_transferencia/" . $nombreArchivo_imagen_tranferencia);
        }
        $stmt->bindParam(":imagen_tranferencia", $nombreArchivo_imagen_tranferencia);
        $stmt->execute();

        $id_compra = $conexion->lastInsertId();

        foreach ($total_p as $productos_c) {
            $id_producto = $productos_c['id_producto'];
            $id_stock = $productos_c['id_stock'];
            $cantidad = $productos_c['cantidad'];

            $insert_compra_producto = $conexion->prepare("INSERT INTO tbl_compra_producto (id_compra, id_producto, id_stock, cantidad) VALUES (:id_compra, :id_producto, :id_stock, :cantidad)");
            $insert_compra_producto->bindParam(':id_compra', $id_compra);
            $insert_compra_producto->bindParam(':id_producto', $id_producto);
            $insert_compra_producto->bindParam(':id_stock', $id_stock);
            $insert_compra_producto->bindParam(':cantidad', $cantidad);
            $insert_compra_producto->execute();
        }

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
                $nuevaCantidad = $cantidad_disponible - $cantidad;

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

        $eliminar_carrito = $conexion->prepare("DELETE FROM tbl_carrito WHERE id_usuario = :id_usuario");
        $eliminar_carrito->bindParam(':id_usuario', $id_usuario);
        $eliminar_carrito->execute();

        // header("Location: ../../index.php?alerta=compra_realizada");
        $mensaje = "Compra terminada correctamente." ;
        header("Location: ver_factura.php?compra=" . urlencode($id_compra) . "&mensaje=" . urlencode($mensaje));
        exit();
    } else {
        echo "Error: El campo id_detalle_compra no está presente o no es un array válido.";
    }
} else {
    echo "Error: método de solicitud incorrecto.";
}
