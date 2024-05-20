<?php
include("./bd.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['password'];

    // Consulta para verificar si el correo electrónico existe en tbl_usuario
    $verificar_sql_usuario = "SELECT * FROM tbl_usuario WHERE correo = :correo";
    $verificar_stmt_usuario = $conexion->prepare($verificar_sql_usuario);
    $verificar_stmt_usuario->bindParam(':correo', $correo, PDO::PARAM_STR);
    $verificar_stmt_usuario->execute();

    // Consulta para verificar si el correo electrónico existe en tbl_vendedor
    $verificar_sql_vendedor = "SELECT * FROM tbl_vendedor WHERE correo = :correo";
    $verificar_stmt_vendedor = $conexion->prepare($verificar_sql_vendedor);
    $verificar_stmt_vendedor->bindParam(':correo', $correo, PDO::PARAM_STR);
    $verificar_stmt_vendedor->execute();

    // Consulta para verificar si el correo electrónico existe en tbl_administrador
    $verificar_sql_administrador = "SELECT * FROM tbl_administrador WHERE correo = :correo";
    $verificar_stmt_administrador = $conexion->prepare($verificar_sql_administrador);
    $verificar_stmt_administrador->bindParam(':correo', $correo, PDO::PARAM_STR);
    $verificar_stmt_administrador->execute();


    if ($verificar_stmt_usuario->rowCount() > 0) {
        // El correo electrónico existe en tbl_usuario, verificar la contraseña
        $row = $verificar_stmt_usuario->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contraseña, $row['password'])) {
            // Almacenar la URL de la página anterior
            if (isset($_SESSION['pagina_anterior'])) {
                $pagina_anterior = $_SESSION['pagina_anterior'];
            } else {
                $pagina_anterior = "index.php"; // Página predeterminada si no hay una página anterior
            }

            // Iniciar sesión y almacenar información del usuario
            $_SESSION['usuario_id'] = $row['id_usuario'];
            $_SESSION['usuario_nombre'] = $row['nombres_u'];
            $_SESSION['usuario_rol'] = $row['id_rol'];
            $_SESSION['loggedin'] = true;
            $mensaje_bienvenida = "Inicio de sesión exitoso. ¡Bienvenido, " .  $_SESSION['usuario_nombre'] . "!";
            header("location:$pagina_anterior?mensaje_bienvenida=" . $mensaje_bienvenida);
            exit;
        } else {
            header("location:registro.php?alerta=contraseña_incorrecta");
        }
    } elseif ($verificar_stmt_vendedor->rowCount() > 0) {
        // El correo electrónico existe en tbl_vendedor, verificar la contraseña
        $row_vendedor = $verificar_stmt_vendedor->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contraseña, $row_vendedor['password'])) {
            // Almacenar la URL de la página anterior
            if (isset($_SESSION['pagina_anterior'])) {
                $pagina_anterior = $_SESSION['pagina_anterior'];
            } else {
                $pagina_anterior = "index.php"; // Página predeterminada si no hay una página anterior
            }

            // Iniciar sesión y almacenar información del vendedor
            $_SESSION['usuario_id'] = $row_vendedor['id_usuario'];
            $_SESSION['usuario_nombre'] = $row_vendedor['nombres_u']; // Asegúrate de que los nombres estén en la tabla correcta
            $_SESSION['usuario_rol'] = $row_vendedor['id_rol']; // Puedes personalizar el rol del vendedor
            $_SESSION['loggedin'] = true;
            $mensaje_bienvenida = "Inicio de sesión exitoso. ¡Bienvenido, " .  $_SESSION['usuario_nombre'] . "!";
            header("location:$pagina_anterior?mensaje_bienvenida=" . $mensaje_bienvenida);
            exit;
        } else {
            header("location:registro.php?alerta=contraseña_incorrecta");
        }
    } elseif ($verificar_stmt_administrador->rowCount() > 0) {
        // El correo electrónico existe en tbl_administrador, verificar la contraseña
        $row_administrador = $verificar_stmt_administrador->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contraseña, $row_administrador['password'])) {
            // Almacenar la URL de la página anterior
            if (isset($_SESSION['pagina_anterior'])) {
                $pagina_anterior = $_SESSION['pagina_anterior'];
            } else {
                $pagina_anterior = "index.php"; // Página predeterminada si no hay una página anterior
            }

            // Iniciar sesión y almacenar información del vendedor
            $_SESSION['usuario_id'] = $row_administrador['id_usuario'];
            $_SESSION['usuario_nombre'] = $row_administrador['nombres_u']; // Asegúrate de que los nombres estén en la tabla correcta
            $_SESSION['usuario_rol'] = $row_administrador['id_rol']; // Puedes personalizar el rol del vendedor
            $_SESSION['loggedin'] = true;
            $mensaje_bienvenida = "Inicio de sesión exitoso. ¡Bienvenido, " .  $_SESSION['usuario_nombre'] . "!";
            header("location:$pagina_anterior?mensaje_bienvenida=" . $mensaje_bienvenida);
            exit;
        } else {
            header("location:registro.php?alerta=contraseña_incorrecta");
        }
    } else {
        header("location:registro.php?alerta=usuario_no_encontrado");
    }
}
