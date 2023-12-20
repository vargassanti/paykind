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

if ($_POST) {
    $nit_identificacion = (isset($_POST["nit_identificacion"]) ? $_POST["nit_identificacion"] : "");
    $nombre_tienda = (isset($_POST["nombre_tienda"]) ? $_POST["nombre_tienda"] : "");
    $descripcion = (isset($_POST["descripcion"]) ? $_POST["descripcion"] : "");
    $id_usuario = $_SESSION["usuario_id"];
    $logo_tienda = (isset($_FILES["logo_tienda"]['name']) ? $_FILES["logo_tienda"]['name'] : "");

    // Verificar si el nit_identificacion ya existe en la tabla
    $verificarSentencia = $conexion->prepare("SELECT COUNT(*) as count FROM tbl_tienda WHERE nit_identificacion = :nit_identificacion");
    $verificarSentencia->bindParam(":nit_identificacion", $nit_identificacion);
    $verificarSentencia->execute();
    $result = $verificarSentencia->fetch();
    $count = $result['count'];

    if ($count > 0) {
        header("location:mitienda.php?alerta=nit_ya_existente");
    } else {
        // Si el nit_identificacion no existe, procede a insertar el registro.
        $sentencia = $conexion->prepare("INSERT INTO tbl_tienda(nit_identificacion, nombre_tienda, descripcion, id_usuario, logo_tienda)
             VALUES (:nit_identificacion, :nombre_tienda, :descripcion, :id_usuario, :logo_tienda)");

        $sentencia->bindParam(":nit_identificacion", $nit_identificacion);
        $sentencia->bindParam(":nombre_tienda", $nombre_tienda);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":id_usuario", $id_usuario);

        //SUBIR IMAGEN 1
        $nombreArchivo_logo_tienda = ($logo_tienda != '') ? $_FILES["logo_tienda"]["name"] : "";
        $tmp_logo_tienda = $_FILES["logo_tienda"]['tmp_name'];
        if ($tmp_logo_tienda != '') {
            move_uploaded_file($tmp_logo_tienda, "./imagenes_tienda/" . $nombreArchivo_logo_tienda);
        }
        $sentencia->bindParam(":logo_tienda", $nombreArchivo_logo_tienda);

        $sentencia->execute();
        $mensaje = "Registro agregado";
        header("location:mitienda.php?mensaje=" . $mensaje);
    }
}

$usuario = $conexion->prepare("SELECT * FROM `tbl_vendedor`");
$usuario->execute();
$lista_tbl_usuario = $usuario->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php"); ?>

<div class="caja_botoncancelar">
    <button class="button_retrocederrr" id="redireccionarButtonDevolver">
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
</div>
<form action="" method="post" enctype="multipart/form-data">
    <div class="card_crear_tiendass">
        <a class="singup">Registrar tienda</a>
        <div class="caja_productoos">
            <div class="inputBox">
                <input type="text" id="nit_identificacion" name="nit_identificacion" required="required">
                <span>Nit o identificacion:</span>
            </div>
            <div class="inputBox">
                <input type="text" id="nombre_tienda" name="nombre_tienda" required="required" onkeypress="return soloLetras(event)">
                <span>Nombre tienda:</span>
            </div>
        </div>
        <div class="caja_productoos">
            <div class="inputBox">
                <textarea id="descripcion" name="descripcion" rows="1" required="required" onkeypress="return soloLetras(event)"></textarea>
                <span>Descripción:</span>
            </div>
            <div class="inputBox">
                <input type="file" id="logo_tienda" name="logo_tienda" onchange="validarImagen('logo_tienda')" required="required">
                <span>Logo tienda:</span>
            </div>
        </div>
        <div class="caja_boton1">
            <button type="submit" class="btn_crear_categoria">Crear tienda</button>
        </div>
    </div>
    </div>
</form>
<script src="archivos.js/redireccionarboton.js"></script>
<script src="archivos.js/solonumeros3.js"></script>
<script src="../../js/sololetras.js"></script>
<script src="archivos.js/validarImagen.js"></script>

