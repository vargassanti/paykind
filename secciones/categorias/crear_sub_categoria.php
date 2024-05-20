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
    $nombre_sub_categoria = (isset($_POST["nombre_sub_categoria"]) ? $_POST["nombre_sub_categoria"] : "");
    $id_categoria = (isset($_POST["id_categoria"]) ? $_POST["id_categoria"] : "");
    $sentencia = $conexion->prepare("INSERT INTO tbl_sub_categorias(id_sub_categoria, nombre_sub_categoria, id_categoria)
                 VALUES (null, :nombre_sub_categoria, :id_categoria)");
    $sentencia->bindParam(":nombre_sub_categoria", $nombre_sub_categoria);
    $sentencia->bindParam(":id_categoria", $id_categoria);
    $sentencia->execute();

    $mensaje = "Registro agregado";
    header("location:index.php?mensaje=" . $mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia->execute();
$lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$tienda = $conexion->prepare("SELECT nit_identificacion, nombre_tienda FROM `tbl_tienda`");
$tienda->execute();

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
    <div class="card_crear_nueva_categoriaa">
        <a class="singup">Registrar sub categoria</a>
        <div class="caja_productoos">
            <div class="inputBox">
                <input type="text" name="nombre_sub_categoria" id="nombre_sub_categoria" required="required">
                <span>Nombre:</span>
            </div>

            <div class="inputBox">
                <select name="id_categoria" id="id_categoria" required="required">
                <option selected hidden>Selecciona una opción: </option>
                    <?php foreach ($lista_tbl_categorias as $registro) { ?>
                        <option value="<?php echo $registro['id_categoria'] ?>">
                            <?php echo $registro['nombre_categoria'] ?>
                        </option>
                    <?php } ?>
                </select>
                <span>Categoria:</span>
            </div>
        </div>

        <div class="caja_boton1">
            <button type="submit" class="btn_crear_categoria">Crear sub categoria</button>
        </div>
    </div>
</form>

<script src="../../js/redireccionarboton.js"></script>
