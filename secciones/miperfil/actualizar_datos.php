<?php
session_start();

if (isset($_SESSION['loggedin']) === true) {
    if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador" || $_SESSION["usuario_rol"] === "Cliente")) {
        // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
        // Coloca el código de la página actual a continuación
        $id_rol = $_SESSION["usuario_rol"]; // Obtener el rol del usuario
    }
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $nombres_u = $_POST['nombres_u'];
    $apellidos_u = $_POST['apellidos_u'];
    $tipo_documento_u = $_POST['tipo_documento_u'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];
    $id_usuario = $_POST['id_usuario'];
    $id_rool = $_POST['id_rol'];

    if ($id_rool == 'Cliente') {
        $tabla = 'tbl_usuario';
    } elseif ($id_rool == 'Vendedor') {
        $tabla = 'tbl_vendedor';
    } elseif ($id_rool == 'Administrador') {
        $tabla = 'tbl_administrador';
    } else {
        // Maneja el caso en que el rol no sea válido
        echo "El rol seleccionado no es válido.";
        exit;
    }

    // Construye la consulta SQL sin la columna fotoPerfil
    $sql = "UPDATE $tabla SET usuario = :usuario, nombres_u = :nombres_u, apellidos_u = :apellidos_u, tipo_documento_u = :tipo_documento_u, correo = :correo, celular = :celular, direccion = :direccion, barrio = :barrio WHERE id_usuario = :id_usuario";

    // Prepara y ejecuta la consulta sin la columna fotoPerfil
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':nombres_u', $nombres_u);
    $stmt->bindParam(':apellidos_u', $apellidos_u);
    $stmt->bindParam(':tipo_documento_u', $tipo_documento_u);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':barrio', $barrio);
    $stmt->bindParam(':id_usuario', $id_usuario); 

    if ($stmt->execute()) {
        $fecha_ = new DateTime();
        $nombreArchivo_fotoPerfil = '';

        if (!empty($_FILES["fotoPerfil"]["name"])) {
            $nombreArchivo_fotoPerfil = $fecha_->getTimestamp() . "_" . $_FILES["fotoPerfil"]["name"];
            $tmp_img_fotoPerfil = $_FILES["fotoPerfil"]['tmp_name'];

            $ruta_destino = "./imagenes_producto/" . $nombreArchivo_fotoPerfil;

            if (move_uploaded_file($tmp_img_fotoPerfil, $ruta_destino)) {
                $sql_actualizar_fotoPerfil = "UPDATE $tabla SET fotoPerfil = :fotoPerfil WHERE id_usuario = :id_usuario";
                $stmt_actualizar_fotoPerfil = $conexion->prepare($sql_actualizar_fotoPerfil);
                $stmt_actualizar_fotoPerfil->bindParam(':fotoPerfil', $nombreArchivo_fotoPerfil);
                $stmt_actualizar_fotoPerfil->bindParam(':id_usuario', $id_usuario);

                if ($stmt_actualizar_fotoPerfil->execute()) {
                    header("location:index.php?alerta=datos_actualizados");
                    exit();
                } else {
                    header("location:index.php?alerta=error_actualizar_fotoPerfil");
                    exit();
                }
            } else {
                header("location:index.php?alerta=error_subir_imagen");
                exit();
            }
        } else {
            header("location:index.php?alerta=datos_actualizados");
            exit();
        }
    } else {
        header("location:index.php?alerta=datos_no_actualizados");
        exit();
    }
}
?>
