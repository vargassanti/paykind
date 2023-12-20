<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Administrador") {
} elseif (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}
include("../../bd.php");

if ($_POST) {
    $nombre_categoria = (isset($_POST["nombre_categoria"]) ? $_POST["nombre_categoria"] : "");
    $sentencia = $conexion->prepare("INSERT INTO tbl_categorias(id_categoria, nombre_categoria)
                 VALUES (null, :nombre_categoria)");
    $sentencia->bindParam(":nombre_categoria", $nombre_categoria);
    $sentencia->execute();
    $mensaje = "Registro agregado";
    header("location:index.php?mensaje=" . $mensaje);
}
?>

<?php include("../../templates/header.php"); ?>

<div class="caja_botoncancelar3">
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
    <!-- Campos visibles por defecto -->
    <div class="card_crear_nueva_categoriaa">
        <a class="singup">Registrar categoria</a>
        <div class="inputBox">
            <input type="text" name="nombre_categoria" id="nombre_categoria" required="required" onkeypress="return soloLetras(event)">
            <span>Nombre:</span>
        </div>
        <div class="caja_boton1">
            <button type="submit" class="btn_crear_categoria">Crear categoria</button>
        </div>
    </div>
</form>

<script src="../../js/redireccionarboton.js"></script>
<script src="../../js/sololetras.js"></script>

