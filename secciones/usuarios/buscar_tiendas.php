<?php

session_start();

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['query'])) {
    $search = $_POST['query'];

    // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
    $tiendas = "SELECT t.nit_identificacion, t.nombre_tienda, t.logo_tienda, t.descripcion, t.id_usuario
    FROM tbl_tienda as t
    WHERE t.nit_identificacion LIKE :search OR t.nombre_tienda LIKE :search OR t.descripcion LIKE :search OR t.id_usuario LIKE :search";

    $stmt = $conexion->prepare($tiendas);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $rows = '';
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($resultados) {
        foreach ($resultados as $tiendas) {
            $rows .= '<tr>
                <td>
                    <img src="../tiendas/imagenes_tienda/' . $tiendas['logo_tienda'] . '" width="100px" height="100px">
                </td>
                <td>' . $tiendas['nit_identificacion'] . '</td>
                <td>' . $tiendas['nombre_tienda'] . '</td>
                <td>';
    
            $contenido = $tiendas['descripcion'];
            $limite_letras = 100;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
    
            $rows .= '</td>
                <td>' . $tiendas['id_usuario'] . '</td>
            </tr>';
        }
    } else {
        $rows = '<tr><td colspan="5">No se encontraron resultados</td></tr>';
    }
    
    echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
}
