<?php

session_start();

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['query'])) {
    $search = $_POST['query'];

    // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
    $inventario = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.nit_identificacion, p.img_producto, s.id_stock, s.id_producto, s.cantidad_disponible, s.fecha_registro, s.color_producto, t.nombre_tienda,t.nit_identificacion
    FROM tbl_productos as p 
    INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    WHERE p.nombre LIKE :search OR p.nit_identificacion LIKE :search OR t.nombre_tienda LIKE :search OR s.color_producto LIKE :search OR s.fecha_registro LIKE :search";

    $stmt = $conexion->prepare($inventario);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $rows = '';
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($resultados) {
        foreach ($resultados as $productos) {
            $rows .= '<tr>
                <td>
                    <img src="../productos/imagenes_producto/' . $productos['img_producto'] . '" width="100px" height="100px">
                </td>
                <td>' . $productos['id_producto'] . '</td>
                <td>' . $productos['nombre'] . '</td>
                <td>$' . number_format($productos['precio'], 0, '.', ',') . '</td>
                <td>' . $productos['nit_identificacion'] . '</td>
                <td>' . $productos['nombre_tienda'] . '</td>
                <td>' . $productos['cantidad_disponible'] . '</td>
                <td>' . $productos['fecha_registro'] . '</td>
                <td>
                    <span class="color-option" style="background-color: ' . $productos['color_producto'] . ';"></span>
                </td>
            </tr>';
        }
    } else {
        $rows = '<tr><td colspan="9">No se encontraron resultados</td></tr>';
    }    

    echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
}
