<?php

session_start();

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['query'])) {
    $search = $_POST['query'];

    // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
    $clientes = "SELECT u.id_usuario, u.usuario, u.tipo_documento_u, u.nombres_u, u.apellidos_u, u.correo, u.password, u.celular, u.direccion, u.barrio, u.fotoPerfil, u.id_rol
    FROM tbl_usuario as u
    WHERE id_rol = 'Cliente' AND (u.id_usuario LIKE :search OR u.usuario LIKE :search OR u.tipo_documento_u LIKE :search OR u.nombres_u LIKE :search OR u.apellidos_u LIKE :search OR u.correo LIKE :search OR u.celular LIKE :search OR u.direccion LIKE :search OR u.barrio LIKE :search OR u.id_rol LIKE :search)";

    $stmt = $conexion->prepare($clientes);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $rows = '';
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($resultados) {
        foreach ($resultados as $clientes) {
            $rows .= '<tr>
                <td>';
            $ruta_foto = "../miperfil/imagenes_producto/" . $clientes['fotoPerfil'];
    
            if (empty($clientes['fotoPerfil']) || !file_exists($ruta_foto)) {
                // Si no hay foto de perfil o el archivo no existe, muestra una imagen predeterminada
                $imagen_predeterminada = "../../imagen/Avatar-No-Background.png"; // Reemplaza con la ruta de tu imagen predeterminada
                $rows .= '<img src="' . $imagen_predeterminada . '" width="70px" height="70px">';
            } else {
                // Si hay foto de perfil y el archivo existe, muestra la foto de perfil
                $rows .= '<img src="' . $ruta_foto . '" width="70px" height="70px">';
            }
            $rows .= '</td>
                <td>';
            $numero = $clientes['id_usuario'];
            $limite_digitos = 7;
    
            if (strlen((string)$numero) > $limite_digitos) {
                $numero_limitado = number_format($numero, 0, '', '');
                $rows .= substr($numero_limitado, 0, $limite_digitos) . '...';
            } else {
                $rows .= $numero;
            }
            $rows .= '</td>
                <td>';
            $contenido = $clientes['usuario'];
            $limite_letras = 7;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>' . $clientes['tipo_documento_u'] . '</td>
                <td>';
            $contenido = $clientes['nombres_u'];
            $limite_letras = 7;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>';
            $contenido = $clientes['apellidos_u'];
            $limite_letras = 7;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>';
            $contenido = $clientes['correo'];
            $limite_letras = 8;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>';
            $numero = $clientes['celular'];
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
            $contenido = $clientes['direccion'];
            $limite_letras = 8;
    
            if (strlen($contenido) > $limite_letras) {
                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                $rows .= $contenido_limitado;
            } else {
                $rows .= $contenido;
            }
            $rows .= '</td>
                <td>' . $clientes['id_rol'] . '</td>
            </tr>';
        }
    } else {
        $rows = '<tr><td colspan="13">No se encontraron resultados</td></tr>';
    }    

    echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
}
