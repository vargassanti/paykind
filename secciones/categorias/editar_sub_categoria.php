<?php
session_start();

include("../../bd.php");

if (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Administrador") {
} elseif (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

if (isset($_GET['id'])) {
    $id_sub_categoria = $_GET['id'];

    $consulta = $conexion->prepare("SELECT * FROM tbl_sub_categorias WHERE id_sub_categoria = :id");
    $consulta->bindParam(":id", $id_sub_categoria);
    $consulta->execute();

    if ($consulta->rowCount() == 1) {
        $sub_categoria = $consulta->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_POST) {
    //Recolectamos los datos del método POST
    $nombre_sub_categoria = $_POST['nombre_sub_categoria'];
    $id_categoria = $_POST['id_categoria'];

    //Preparar la actualización de los datos
    $actualizar = $conexion->prepare("UPDATE tbl_sub_categorias SET nombre_sub_categoria = :nombre_sub_categoria, id_categoria = :id_categoria WHERE id_sub_categoria = :id");
    $actualizar->bindParam(":nombre_sub_categoria", $nombre_sub_categoria);
    $actualizar->bindParam(":id_categoria", $id_categoria);
    $actualizar->bindParam(":id", $id_sub_categoria);
    $actualizar->execute();
    $mensaje = "Registro actualizado";
    header("location:index.php?mensaje=" . $mensaje);
}

$usuario_id = $_SESSION['usuario_id'];

$tienda = $conexion->prepare("SELECT nit_identificacion FROM `tbl_tienda` WHERE id_usuario = :usuario_id");
$tienda->bindParam(":usuario_id", $usuario_id); // Asegúrate de que tengas un valor para $id_usuario
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
                <input type="text" value="<?php echo $sub_categoria['nombre_sub_categoria']; ?>" name="nombre_sub_categoria" id="nombre_sub_categoria" required="required">
                <span>Nombre:</span>
            </div>

            <div class="inputBox">
                <select name="id_categoria" id="id_categoria" required="required">
                    <option value=""></option>
                    <?php foreach ($lista_tbl_categorias as $categoria) { ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>" <?php if ($categoria['id_categoria'] === $sub_categoria['id_categoria']) echo 'selected'; ?>>
                            <?php echo $categoria['nombre_categoria']; ?>
                        </option>
                    <?php } ?>
                </select>
                <span>Categoria:</span>
            </div>

        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <select name="nit_identificacion" id="nit_identificacion" required="required">
                    <option value=""></option>
                    <?php foreach ($tienda as $tienda_item) { ?>
                        <option value="<?php echo $tienda_item['nit_identificacion']; ?>" <?php if ($tienda_item['nit_identificacion'] === $sub_categoria['nit_identificacion']) echo 'selected'; ?>>
                            <?php echo $tienda_item['nit_identificacion']; ?>
                        </option>
                    <?php } ?>
                </select>
                <span>Nit tienda:</span>
            </div>
        </div>

        <div class="caja_boton1">
            <button type="submit" class="btn_crear_categoria">Actualizar sub categoria</button>
        </div>
    </div>
</form>

<script src="../../js/redireccionarboton.js"></script>
