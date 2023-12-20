<?php
session_start();

include("../../bd.php");
include("../../config.php");

if (isset($_POST['id_stock']) && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $id_stock = $_POST['id_stock']; 

    $consulta = $conexion->prepare('SELECT cantidad_disponible, color_producto FROM tbl_stock WHERE id_producto = :id_producto AND id_stock = :id_stock');
    $consulta->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $consulta->bindParam(':id_stock', $id_stock, PDO::PARAM_INT); // Corregido a :idStock
    $consulta->execute();

    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo $resultado['cantidad_disponible'];
    } else {
        echo '0'; // Otra acción si no se encuentra la cantidad
    }
} else {
    echo 'Error: Datos insuficientes.';
}
?>
