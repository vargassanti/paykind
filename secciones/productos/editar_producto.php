<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}
include("../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txtID'])) {
    // Obtener los datos del formulario
    $id_producto = $_POST['txtID'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $color_producto = $_POST['color_producto'];
    $id_stock = $_POST['id_stock'];
    $estado_producto = $_POST['estado_producto'];

    // Obtener las imágenes anteriores desde la base de datos
    $sentencia = $conexion->prepare("SELECT img_producto, img_producto2, img_producto3, img_producto4, img_producto5, img_producto6 FROM tbl_productos WHERE id_producto = :id_producto");
    $sentencia->bindParam(':id_producto', $id_producto);
    $sentencia->execute();
    $imagenes_anteriores = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Procesar y guardar nuevas imágenes
    $carpeta_imagenes = "./imagenes_producto/";
    $nombres_imagenes = array('img_producto', 'img_producto2', 'img_producto3', 'img_producto4', 'img_producto5', 'img_producto6');

    foreach ($nombres_imagenes as $nombre_imagen) {
        if ($_FILES[$nombre_imagen]['error'] === UPLOAD_ERR_OK) {
            $nombre_imagen_actual = $imagenes_anteriores[$nombre_imagen];

            // Guardar la nueva imagen
            $nombre_archivo = basename($_FILES[$nombre_imagen]["name"]);
            $ruta_archivo = $carpeta_imagenes . $nombre_archivo;

            if (move_uploaded_file($_FILES[$nombre_imagen]["tmp_name"], $ruta_archivo)) {
                // Verificar si la imagen es diferente a la anterior antes de eliminarla
                if (!empty($nombre_imagen_actual) && $nombre_archivo !== $nombre_imagen_actual && file_exists($carpeta_imagenes . $nombre_imagen_actual)) {
                    unlink($carpeta_imagenes . $nombre_imagen_actual);
                }

                // Actualizar el nombre de la imagen en la base de datos
                $sentencia_actualizar_imagen = $conexion->prepare("UPDATE tbl_productos SET $nombre_imagen = :nombre_imagen WHERE id_producto = :id_producto");
                $sentencia_actualizar_imagen->bindParam(':nombre_imagen', $nombre_archivo);
                $sentencia_actualizar_imagen->bindParam(':id_producto', $id_producto);
                $sentencia_actualizar_imagen->execute();
            } else {
                echo "Error al cargar la imagen $nombre_imagen";
            }
        }
    }

    // Actualizar otros detalles del producto en la base de datos
    $sentencia_actualizar_producto = $conexion->prepare("UPDATE tbl_productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, descuento_producto = :descuento, estado_producto =:estado_producto WHERE id_producto = :id_producto");
    $sentencia_actualizar_producto->bindParam(':nombre', $nombre);
    $sentencia_actualizar_producto->bindParam(':descripcion', $descripcion);
    $sentencia_actualizar_producto->bindParam(':precio', $precio);
    $sentencia_actualizar_producto->bindParam(':descuento', $descuento);
    $sentencia_actualizar_producto->bindParam(':estado_producto', $estado_producto);
    $sentencia_actualizar_producto->bindParam(':id_producto', $id_producto);
    $sentencia_actualizar_producto->execute();

    $sentencia_actualizar_stock = $conexion->prepare("UPDATE tbl_stock SET cantidad_disponible = :cantidad_disponible, color_producto = :color_producto WHERE id_producto = :id_producto AND id_stock = :id_stock");
    $sentencia_actualizar_stock->bindParam(':cantidad_disponible', $cantidad_disponible);
    $sentencia_actualizar_stock->bindParam(':color_producto', $color_producto);
    $sentencia_actualizar_stock->bindParam(':id_producto', $id_producto);
    $sentencia_actualizar_stock->bindParam(':id_stock', $id_stock);
    $sentencia_actualizar_stock->execute();

    $mensaje = "Producto actualizado correctamente";
    header("location: mis_productos.php?mensaje=" . $mensaje);

} else {
    echo "No se han enviado datos válidos para actualizar el producto";
}

