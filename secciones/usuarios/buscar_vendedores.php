<?php

session_start();

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['query'])) {
    $search = $_POST['query'];

    // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
    $vendedores = "SELECT v.id_usuario, v.usuario, v.tipo_documento_u, v.nombres_u, v.apellidos_u, v.correo, v.password, v.celular, v.direccion, v.barrio, v.fotoPerfil, v.id_rol
    FROM tbl_vendedor as v
    WHERE id_rol = 'Vendedor' AND (v.id_usuario LIKE :search OR v.usuario LIKE :search OR v.tipo_documento_u LIKE :search OR v.nombres_u LIKE :search OR v.apellidos_u LIKE :search OR v.correo LIKE :search OR v.celular LIKE :search OR v.direccion LIKE :search OR v.barrio LIKE :search OR v.id_rol LIKE :search)";

    $stmt = $conexion->prepare($vendedores);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $rows = '';
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($resultados) {
        foreach ($resultados as $vendedores) {
            $rows .= '<tr>
                <td>';
            $ruta_foto = "../miperfil/imagenes_producto/" . $vendedores['fotoPerfil'];
    
            if (empty($vendedores['fotoPerfil']) || !file_exists($ruta_foto)) {
                // Si no hay foto de perfil o el archivo no existe, muestra una imagen predeterminada
                $imagen_predeterminada = "../../imagen/Avatar-No-Background.png"; // Reemplaza con la ruta de tu imagen predeterminada
                $rows .= '<img src="' . $imagen_predeterminada . '" width="70px" height="70px">';
            } else {
                // Si hay foto de perfil y el archivo existe, muestra la foto de perfil
                $rows .= '<img src="' . $ruta_foto . '" width="70px" height="70px">';
            }
            $rows .= '</td>
                <td>';
            $numero = $vendedores['id_usuario'];
            $limite_digitos = 7;
    
            if (strlen((string)$numero) > $limite_digitos) {
                $numero_limitado = number_format($numero, 0, '', '');
                $rows .= substr($numero_limitado, 0, $limite_digitos) . '...';
            } else {
                $rows .= $numero;
            }
            $rows .= '</td>
                <td>';
            $contenido = $vendedores['usuario'];
            $limite_letras = 7;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>' . $vendedores['tipo_documento_u'] . '</td>
                <td>';
            $contenido = $vendedores['nombres_u'];
            $limite_letras = 7;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>';
            $contenido = $vendedores['apellidos_u'];
            $limite_letras = 7;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>';
            $contenido = $vendedores['correo'];
            $limite_letras = 8;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>';
            $numero = $vendedores['celular'];
            $limite_digitos = 7;
    
            if (strlen((string)$numero) > $limite_digitos) {
                $numero_limitado = number_format($numero, 0, '', '');
                $rows .= substr($numero_limitado, 0, $limite_digitos) . '...';
            } else {
                $rows .= $numero;
            }
            $rows .= '</td>
                <td>Medellin</td>
                <td>Barrio</td>
                <td>Comuna</td>
                <td>';
            $contenido = $vendedores['direccion'];
            $limite_letras = 8;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>' . $vendedores['id_rol'] . '</td>
            </tr>';
        }
    } else {
        $rows = '<tr><td colspan="13">No se encontraron resultados</td></tr>';
    }    

    echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
}
