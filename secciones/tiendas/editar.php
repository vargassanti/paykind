<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador")) {
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

include("../../bd.php");

if (isset($_GET['tienda'])) {
    $tienda = (isset($_GET['tienda'])) ? $_GET['tienda'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_tienda WHERE nit_identificacion =:nit_identificacion");
    $sentencia->bindParam(":nit_identificacion", $tienda);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $nit_identificacion = $registro["nit_identificacion"];
    $nombre_tienda = $registro["nombre_tienda"];
    $logo_tienda = $registro["logo_tienda"];
    $descripcion = $registro["descripcion"];

    if ($_POST) {
        $tienda = (isset($_GET['tienda'])) ? $_POST['tienda'] : "";
        $nombre_tienda = (isset($_POST["nombre_tienda"]) ? $_POST["nombre_tienda"] : "");
        $descripcion = (isset($_POST["descripcion"]) ? $_POST["descripcion"] : "");

        // Obtén el nombre de archivo de la imagen actual
        $consulta_imagen_actual = $conexion->prepare("SELECT logo_tienda FROM tbl_tienda WHERE nit_identificacion=:nit_identificacion");
        $consulta_imagen_actual->bindParam(":nit_identificacion", $tienda);
        $consulta_imagen_actual->execute();
        $resultado = $consulta_imagen_actual->fetch(PDO::FETCH_ASSOC);
        $imagen_actual = $resultado['logo_tienda'];

        $sentencia = $conexion->prepare("UPDATE tbl_tienda SET
        nombre_tienda=:nombre_tienda,
        descripcion=:descripcion
        WHERE nit_identificacion=:nit_identificacion");

        $sentencia->bindParam(":nombre_tienda", $nombre_tienda);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":nit_identificacion", $tienda);
        $sentencia->execute();

        $logo_tienda = (isset($_FILES['logo_tienda']['name']) ? $_FILES['logo_tienda']['name'] : "");

        if ($imagen_actual && file_exists("./imagenes_tienda/" . $imagen_actual)) {
            // Eliminar la imagen anterior
            unlink("./imagenes_tienda/" . $imagen_actual);
        }

        $fecha_ = new DateTime();

        // SUBIR LA NUEVA IMAGEN
        $nombreArchivo_logo_tienda = ($logo_tienda != '') ? $fecha_->getTimestamp() . "_" . $_FILES["logo_tienda"]["name"] : "";
        $tmp_logo_tienda = $_FILES["logo_tienda"]['tmp_name'];
        if ($tmp_logo_tienda != '') {
            move_uploaded_file($tmp_logo_tienda, "./imagenes_tienda/" . $nombreArchivo_logo_tienda);

            $sentencia = $conexion->prepare("UPDATE tbl_tienda SET logo_tienda=:logo_tienda WHERE nit_identificacion=:nit_identificacion");
            $sentencia->bindParam(":logo_tienda", $nombreArchivo_logo_tienda);
            $sentencia->bindParam(":nit_identificacion", $tienda);
            $sentencia->execute();
        }

        $mensaje = "Tienda actualizada";
        $ruta = "index.php";
        header("Location: mas_tienda.php?txtID=" . $tienda . "&mensaje=" . $mensaje . "&ruta=" . $ruta);
    }
}
?>

<?php include("../../templates/header.php"); ?>
<div class="caja_botoncancelar">
    <a href="mas_tienda.php?txtID=<?php echo $tienda ?>&ruta=index.php">
        <button class="button_retrocederrr">
            <div class="button-box">
                <span class="button-elem">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 40">
                        <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
                    </svg>
                </span>
                <span class="button-elem">
                    <svg viewBox="0 0 46 40">
                        <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
                    </svg>
                </span>
            </div>
        </button>
    </a>
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="card_editar_tiendass">
        <a class="singup">Actualiza tienda</a>
        <div class="caja_e_tiendas">
            <input type="text" value="<?php echo $tienda; ?>" id="tienda" name="tienda" required="required" hidden>
            <div class="inputBox">
                <input type="text" value="<?php echo $nombre_tienda; ?>" id="nombre_tienda" name="nombre_tienda" required="required" onkeypress="return soloLetras(event)">
                <span>Nombre tienda:</span>
            </div>
            <div class="inputBox">
                <textarea id="descripcion" name="descripcion" rows="1" required="required" onkeypress="return soloLetras(event)"><?php echo $descripcion; ?></textarea>
                <span>Descripción:</span>
            </div>
        </div>
        <div class="caja_e_tiendas">
            <img src="imagenes_tienda/<?php echo $logo_tienda ?>" class="rounded" alt="" />
            <div class="inputBox">
                <input type="file" value="<?php echo $logo_tienda ?>" id="logo_tienda" name="logo_tienda" accept="image/*">
                <span>Logo tienda:</span>
            </div>
        </div>
        <div class="caja_boton1">
            <button type="submit" class="btn_crear_categoria">Actualizar tienda</button>
        </div>
    </div>
</form>