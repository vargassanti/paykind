<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador")) { 
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente"){
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
}else{
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

if ($_POST) {
    $nit_identificacion = (isset($_POST["nit_identificacion"]) ? $_POST["nit_identificacion"] : "");
    $nombre_tienda = (isset($_POST["nombre_tienda"]) ? $_POST["nombre_tienda"] : "");
    $descripcion = (isset($_POST["descripcion"]) ? $_POST["descripcion"] : "");
    $id_usuario = (isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : "");
    $id_categoria_tienda = (isset($_POST["id_categoria_tienda"]) ? $_POST["id_categoria_tienda"] : "");

    $logo_tienda = (isset($_FILES["logo_tienda"]['name']) ? $_FILES["logo_tienda"]['name'] : "");

    $sentencia = $conexion->prepare("INSERT INTO tbl_tienda(nit_identificacion, nombre_tienda, descripcion, id_usuario, id_categoria_tienda, logo_tienda)
                 VALUES (:nit_identificacion, :nombre_tienda, :descripcion, :id_usuario, :id_categoria_tienda, :logo_tienda)");

    $sentencia->bindParam(":nit_identificacion", $nit_identificacion);
    $sentencia->bindParam(":nombre_tienda", $nombre_tienda);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":id_usuario", $id_usuario); 
    $sentencia->bindParam(":id_categoria_tienda", $id_categoria_tienda);
    
    //SUBIR IMAGEN 1
    $nombreArchivo_logo_tienda = ($logo_tienda != '') ? $_FILES["logo_tienda"]["name"] : "";
    $tmp_logo_tienda = $_FILES["logo_tienda"]['tmp_name'];
    if ($tmp_logo_tienda != '') {
        move_uploaded_file($tmp_logo_tienda, "./imagenes_tienda/" . $nombreArchivo_logo_tienda);
    }
    $sentencia->bindParam(":logo_tienda", $nombreArchivo_logo_tienda);

    $sentencia->execute();
    $mensaje = "Registro agregado";
    header("location:index.php?mensaje=" . $mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_categoria_tiendas`");
$sentencia->execute();
$lista_tbl_categoria_tiendas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM `tbl_vendedor`");
$sentencia->execute();
$lista_tbl_vendedor = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); 

if (isset($_SESSION['loggedin']) === true) {
    $usuario_id = $_SESSION['usuario_id'];
}
?>
<section class="home">
    <div class="container_crearproductos">
        <div class="caja_botoncancelar">
            <a class="boton_cancelar" href="index.php" role="button">
                <img class="imagen_cancelar" src="../../img/pngwing.com.png" alt="">
            </a>
        </div>
        <h1>Registrar tienda</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nit_identificacion">Nit o identificacion:</label>
                    <input type="number" id="nit_identificacion" name="nit_identificacion" required>
                </div>
                <div class="form-group">
                    <label for="nombre_tienda">Nombre de la tienda:</label>
                    <input type="text" id="nombre_tienda" name="nombre_tienda" required>
                </div>
                <div class="form-group">
                    <label for="logo_tienda">Logo de la tienda:</label>
                    <label class="file-input">
                        <span>Elegir archivo</span>
                        <input type="file" id="logo_tienda" name="logo_tienda" accept="image/*" required>
                    </label>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <div class="textarea-container">
                        <textarea id="descripcion" name="descripcion" rows="1" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_categoria_tienda" class="form-label">Vendedor:</label>
                    <input type="text" name="id_usuario" value="<?php echo $usuario_id ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="id_categoria_tienda" class="form-label">Categoria tienda:</label>
                    <select class="form-select form-select-sm" name="id_categoria_tienda" id="id_categoria_tienda">
                        <?php foreach ($lista_tbl_categoria_tiendas as $registro) { ?>
                            <option value="<?php echo $registro['id_categoria_tienda'] ?>">
                                <?php echo $registro['nombre_categoria_tienda'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit">Crear tienda</button>
        </form>
    </div>
</section>
<style>
    .container_crearproductos {
        max-width: 800px;
        margin-top: 70px;
        margin-left: 250px;
        margin-bottom: 70px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .file-input {
        position: relative;
        overflow: hidden;
        background-color: #51c67f;
        color: #000000;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        padding: 10px 20px;
    }

    .file-input input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    select {
        height: 40px;
    }

    input[type="file"] {
        padding: 10px;
    }

    button {
        background-color: #3f3f3f;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
        position: relative;
        left: 200px;
        margin: 30px;
    }

    /* Estilo para el textarea y su contenedor */
    .textarea-container {
        position: relative;
        width: 100%;
        max-height: 200px;
        /* Altura máxima */
    }

    textarea {
        width: 100%;
        height: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        resize: vertical;
        /* Permite el ajuste vertical */
    }

    h1 {
        text-align: center;
        position: relative;
        top: -20px;
    }
</style>

<?php include("../../templates/footer.php"); ?>
