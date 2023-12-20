<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['estado_carrito'])) {
        $estado_carrito = $_POST['estado_carrito'];

        switch ($estado_carrito) {
            case 'aprobado':
                $id_compra = $_POST['id_compra'];
                $estado_carrito = $_POST['estado_carrito'];

                $update_compra_producto = "UPDATE tbl_compra_producto SET estado_carrito = 'Aprobado' WHERE id_compra = :id_compra";
                $stmt_update = $conexion->prepare($update_compra_producto);
                $stmt_update->bindParam(':id_compra', $id_compra);
                $stmt_update->execute();

                $mensaje = "Estado de compra actualizado correctamente";
                header("Location: info_compras_clientes.php?c=aprobado&mensaje=" . urlencode($mensaje));
                break;
            case 'espera_envio':
                $id_compra = $_POST['id_compra'];
                $estado_carrito = $_POST['estado_carrito'];

                $update_compra_producto = "UPDATE tbl_compra_producto SET estado_carrito = 'En espera de envío' WHERE id_compra = :id_compra";
                $stmt_update = $conexion->prepare($update_compra_producto);
                $stmt_update->bindParam(':id_compra', $id_compra);
                $stmt_update->execute();

                $mensaje = "Estado de compra actualizado correctamente";
                header("Location: info_compras_clientes.php?c=espera_envio&mensaje=" . urlencode($mensaje));
                break;
            case 'transito':
                $id_compra = $_POST['id_compra'];
                $estado_carrito = $_POST['estado_carrito'];

                $update_compra_producto = "UPDATE tbl_compra_producto SET estado_carrito = 'En tránsito' WHERE id_compra = :id_compra";
                $stmt_update = $conexion->prepare($update_compra_producto);
                $stmt_update->bindParam(':id_compra', $id_compra);
                $stmt_update->execute();

                $mensaje = "Estado de compra actualizado correctamente";
                header("Location: info_compras_clientes.php?c=en_transito&mensaje=" . urlencode($mensaje));
                break;
            case 'completado':
                $id_compra = $_POST['id_compra'];
                $estado_carrito = $_POST['estado_carrito'];

                $update_compra_producto = "UPDATE tbl_compra_producto SET estado_carrito = 'Completado' WHERE id_compra = :id_compra";
                $stmt_update = $conexion->prepare($update_compra_producto);
                $stmt_update->bindParam(':id_compra', $id_compra);
                $stmt_update->execute();

                $mensaje = "Estado de compra actualizado correctamente";
                header("Location: info_compras_clientes.php?c=completado&mensaje=" . urlencode($mensaje));
                break;
            default:
                echo "No se ha especificado un tipo de compra editar carrito.";
                break;
        }
    } else {
        echo "No se recibió el campo 'estado_carrito' correctamente";
    }
} else {
    echo "Se esperaba una solicitud POST";
}
