<?php

session_start();

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['query'])) {
    $search = $_POST['query'];

    // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
    $query = "SELECT DISTINCT c.*, u.*
    FROM tbl_compra as c 
    INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
    INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
    WHERE (c.id_compra LIKE :search OR c.total_compra LIKE :search OR p.precio LIKE :search OR u.id_usuario LIKE :search OR c.costo_envio LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR c.metodo_pago LIKE :search)";

    $stmt = $conexion->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $rows = '';
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($resultados) {
        foreach ($resultados as $compras) {
            $rows .= '<tr>
                <td>' . $compras['id_compra'] . '</td>
                <td>$' . number_format($compras['total_compra'], 0, '.', ',') . '</td>
                <td>$' . number_format($compras['costo_envio'], 0, '.', ',') . '</td>
                <td>' . $compras['usuario'] . '</td>
                <td>' . $compras['id_usuario'] . '</td>
                <td>' . $compras['correo'] . '</td>
                <td>' . $compras['metodo_pago'] . '</td>
                <td>' . $compras['fecha_compra'] . '</td>
                <td>
                    <div class="opciones_comp">
                        <a onclick="cargarVistaRapidaCompras(' . $compras['id_compra'] . ')">
                            <div class="ver_compra_lupa">
                                <i class=\'bx bx-search-alt-2\'></i>
                            </div>
                        </a>
                    </div>
                </td>
            </tr>';
        }
    } else {
        $rows = '<tr><td colspan="11">No se encontraron resultados</td></tr>';
    }

    echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
}
