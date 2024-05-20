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

                // ACTUALIZAR ESTADO DE LA COMPRA
                $update_compra_producto = "UPDATE tbl_compra_producto SET estado_carrito = 'Completado' WHERE id_compra = :id_compra";
                $stmt_update = $conexion->prepare($update_compra_producto);
                $stmt_update->bindParam(':id_compra', $id_compra);
                $stmt_update->execute();

                // CONSULTA PARA BUSCAR TODO DE LA TBL_COMPRA POR EL ID_COMPRA QUE SE ESTA PASANDO
                $select_compra_producto = "SELECT * FROM `tbl_compra` WHERE id_compra = :id_compra";
                $stmt_select = $conexion->prepare($select_compra_producto);
                $stmt_select->bindParam(':id_compra', $id_compra);
                $stmt_select->execute();
                $resultado = $stmt_select->fetch();
                $id_usuario_compra = $resultado['id_usuario'];
                $metodo_pago_compra = $resultado['metodo_pago'];
                $total_compra_compra = $resultado['total_compra'];
                $costo_envio_compra = $resultado['costo_envio'];
                $fecha_compra_compra = $resultado['fecha_compra'];

                // CONSULTA PARA BUSCAR LA INFORMACION DEL USUARIO DE LA COMPRA
                $info_usuario = "SELECT * FROM `tbl_usuario` WHERE id_usuario = :id_usuario";
                $stmt_usu = $conexion->prepare($info_usuario);
                $stmt_usu->bindParam(':id_usuario', $id_usuario_compra);
                $stmt_usu->execute();
                $resultado_usuario = $stmt_usu->fetch(PDO::FETCH_ASSOC);

                $id_usuario_usuario = $resultado_usuario['id_usuario'];
                $nombres_u_usuario = $resultado_usuario['nombres_u'];
                $apellidos_u_usuario = $resultado_usuario['apellidos_u'];
                $correo_usuario = $resultado_usuario['correo'];
                $direccion_usuario = $resultado_usuario['direccion'];

                //CONSULTA PARA EL INSERT A LA TABLA VENTA CON LOS DATOS DE LA CONSULTA ANTERIOR DEL USUARIO
                $insert_venta = "INSERT INTO tbl_venta(id_venta, estado, id_compra, metodo_pago, total_compra, id_usuario, nombres_u, apellidos_u, correo, direccion, costo_envio, fecha_compra) VALUES (null, :estado, :id_compra, :metodo_pago, :total_compra, :id_usuario, :nombres_u, :apellidos_u, :correo, :direccion, :costo_envio, :fecha_compra)";
                $stmt_insert = $conexion->prepare($insert_venta);
                $stmt_insert->bindParam(':estado', $estado_carrito);
                $stmt_insert->bindParam(':id_compra', $id_compra);
                $stmt_insert->bindParam(':metodo_pago', $metodo_pago_compra);
                $stmt_insert->bindParam(':total_compra', $total_compra_compra);
                $stmt_insert->bindParam(':id_usuario', $id_usuario_usuario);
                $stmt_insert->bindParam(':nombres_u', $nombres_u_usuario);
                $stmt_insert->bindParam(':apellidos_u', $apellidos_u_usuario);
                $stmt_insert->bindParam(':correo', $correo_usuario);
                $stmt_insert->bindParam(':direccion', $direccion_usuario);
                $stmt_insert->bindParam(':costo_envio', $costo_envio_compra);
                $stmt_insert->bindParam(':fecha_compra', $fecha_compra_compra);
                $stmt_insert->execute();

                $mensaje = "Proceso de compra terminado correctamente";
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
