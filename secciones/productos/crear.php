<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador")) {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recolectamos los datos del metodo POST
    $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
    $descripcion = (isset($_POST["descripcion"]) ? $_POST["descripcion"] : "");
    $precio = (isset($_POST["precio"]) ? $_POST["precio"] : "");
    $id_sub_categoria = (isset($_POST["id_sub_categoria"]) ? $_POST["id_sub_categoria"] : "");
    $nit_identificacion = (isset($_POST["nit_identificacion"]) ? $_POST["nit_identificacion"] : "");
    $especificaciones_p = (isset($_POST["especificaciones_p"]) ? $_POST["especificaciones_p"] : "");
    $descuento_producto = (isset($_POST["descuento_producto"]) ? $_POST["descuento_producto"] : "");

    $img_producto = (isset($_FILES["img_producto"]['name']) ? $_FILES["img_producto"]['name'] : "");
    $img_producto2 = (isset($_FILES["img_producto2"]['name']) ? $_FILES["img_producto2"]['name'] : "");
    $img_producto3 = (isset($_FILES["img_producto3"]['name']) ? $_FILES["img_producto3"]['name'] : "");
    $img_producto4 = (isset($_FILES["img_producto4"]['name']) ? $_FILES["img_producto4"]['name'] : "");
    $img_producto5 = (isset($_FILES["img_producto5"]['name']) ? $_FILES["img_producto5"]['name'] : "");
    $img_producto6 = (isset($_FILES["img_producto6"]['name']) ? $_FILES["img_producto6"]['name'] : "");

    //Preparar la insercción de los datos 
    $sentencia = $conexion->prepare("INSERT INTO tbl_productos(id_producto, nombre, descripcion, precio, id_sub_categoria,  nit_identificacion, especificaciones_p, descuento_producto, img_producto, img_producto2, img_producto3, img_producto4, img_producto5, img_producto6)
    VALUES (null, :nombre, :descripcion, :precio, :id_sub_categoria, :nit_identificacion, :especificaciones_p, :descuento_producto, :img_producto, :img_producto2, :img_producto3, :img_producto4, :img_producto5, :img_producto6)");

    //Preparar la insercción de los datos 
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":id_sub_categoria", $id_sub_categoria);
    $sentencia->bindParam(":nit_identificacion", $nit_identificacion);
    $sentencia->bindParam(":especificaciones_p", $especificaciones_p);
    $sentencia->bindParam(":descuento_producto", $descuento_producto);

    $fecha_ = new DateTime();

    //SUBIR IMAGEN 1
    $nombreArchivo_img_producto = ($img_producto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["img_producto"]["name"] : "";
    $tmp_img_producto = $_FILES["img_producto"]['tmp_name'];
    if ($tmp_img_producto != '') {
        move_uploaded_file($tmp_img_producto, "./imagenes_producto/" . $nombreArchivo_img_producto);
    }
    $sentencia->bindParam(":img_producto", $nombreArchivo_img_producto);

    //SUBIR IMAGEN 2
    $nombreArchivo_img_producto2 = ($img_producto2 != '') ? $fecha_->getTimestamp() . "_" . $_FILES["img_producto2"]["name"] : "";
    $tmp_img_producto2 = $_FILES["img_producto2"]['tmp_name'];
    if ($tmp_img_producto2 != '') {
        move_uploaded_file($tmp_img_producto2, "./imagenes_producto/" . $nombreArchivo_img_producto2);
    }
    $sentencia->bindParam(":img_producto2", $nombreArchivo_img_producto2);

    //SUBIR IMAGEN 3
    $nombreArchivo_img_producto3 = ($img_producto3 != '') ? $fecha_->getTimestamp() . "_" . $_FILES["img_producto3"]["name"] : "";
    $tmp_img_producto3 = $_FILES["img_producto3"]['tmp_name'];
    if ($tmp_img_producto3 != '') {
        move_uploaded_file($tmp_img_producto3, "./imagenes_producto/" . $nombreArchivo_img_producto3);
    }
    $sentencia->bindParam(":img_producto3", $nombreArchivo_img_producto3);

    //SUBIR IMAGEN 4
    $nombreArchivo_img_producto4 = ($img_producto4 != '') ? $fecha_->getTimestamp() . "_" . $_FILES["img_producto4"]["name"] : "";
    $tmp_img_producto4 = $_FILES["img_producto4"]['tmp_name'];
    if ($tmp_img_producto4 != '') {
        move_uploaded_file($tmp_img_producto4, "./imagenes_producto/" . $nombreArchivo_img_producto4);
    }
    $sentencia->bindParam(":img_producto4", $nombreArchivo_img_producto4);

    //SUBIR IMAGEN 5
    $nombreArchivo_img_producto5 = ($img_producto5 != '') ? $fecha_->getTimestamp() . "_" . $_FILES["img_producto5"]["name"] : "";
    $tmp_img_producto5 = $_FILES["img_producto5"]['tmp_name'];
    if ($tmp_img_producto5 != '') {
        move_uploaded_file($tmp_img_producto5, "./imagenes_producto/" . $nombreArchivo_img_producto5);
    }
    $sentencia->bindParam(":img_producto5", $nombreArchivo_img_producto5);

    //SUBIR IMAGEN 6
    $nombreArchivo_img_producto6 = ($img_producto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["img_producto6"]["name"] : "";
    $tmp_img_producto6 = $_FILES["img_producto6"]['tmp_name'];
    if ($tmp_img_producto6 != '') {
        move_uploaded_file($tmp_img_producto6, "./imagenes_producto/" . $nombreArchivo_img_producto6);
    }
    $sentencia->bindParam(":img_producto6", $nombreArchivo_img_producto6);

    $sentencia->execute();

    if ($sentencia) {
        // Obten el ID del producto recién insertado
        $id_producto = $conexion->lastInsertId();

        $cantidad_disponible = (isset($_POST["cantidad_disponible"]) ? $_POST["cantidad_disponible"] : "");
        $color_producto = (isset($_POST["color_producto"]) ? $_POST["color_producto"] : "");
        //Preparar la insercción de los datos en la tabla tbl_stock
        $sentenciaStock = $conexion->prepare("INSERT INTO tbl_stock(id_stock, id_producto, cantidad_disponible, color_producto) VALUES (null, :id_producto, :cantidad_disponible, :color_producto)");
        // Asocia el valor del ID del producto y la cantidad_disponible
        $sentenciaStock->bindParam(":id_producto", $id_producto);
        $sentenciaStock->bindParam(":cantidad_disponible", $cantidad_disponible);
        $sentenciaStock->bindParam(":color_producto", $color_producto);

        // Ejecuta la inserción en la tabla tbl_stock
        $sentenciaStock->execute();

        $mensaje = "Registro agregado";
        header("location:mis_productos.php?mensaje=" . $mensaje);
        exit;
    }
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia->execute();
$lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM `tbl_tienda`");
$sentencia->execute();
$lista_tbl_tiendas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sub_categoria = $conexion->prepare("SELECT * FROM tbl_sub_categorias");
$sub_categoria->execute();
$lista_tbl_sub_categorias = $sub_categoria->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php");


if (isset($_SESSION["loggedin"])) {
    // El usuario ha iniciado sesión, permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} else {
    // El usuario no ha iniciado sesión, redirige a la página de registro
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$tienda = $conexion->prepare("SELECT nit_identificacion, nombre_tienda FROM `tbl_tienda` WHERE id_usuario = :usuario_id");
$tienda->bindParam(":usuario_id", $usuario_id); // Asegúrate de que tengas un valor para $id_usuario
$tienda->execute();

?>

<div class="caja_botoncancelar">
    <button class="button_retrocederrr" id="redireccionarButtonDevolver_misproductos">
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
    <div class="card_crear_producto">
        <a class="singup">Registrar producto</a>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="text" id="nombre" name="nombre" required="required">
                <span>Nombre:</span>
            </div>

            <div class="inputBox">
                <textarea id="descripcion" name="descripcion" rows="1" required="required" onkeypress="return soloLetras(event)"></textarea>
                <span>Descripción:</span>
            </div>

        </div>
        <div class="caja_productoos">
            <div class="inputBox">
                <input type="text" id="precio" name="precio" step="0.01" required="required">
                <span>Precio:</span>
            </div>

            <div class="inputBox">
                <input type="text" id="descuento_producto" name="descuento_producto" required="required">
                <span>Descuento:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <select name="id_categoria" id="id_categoria" required="required">
                    <option selected hidden></option>
                    <?php foreach ($lista_tbl_categorias as $registro) { ?>
                        <option value="<?php echo $registro['id_categoria'] ?>">
                            <?php echo $registro['nombre_categoria'] ?>
                        </option>
                    <?php } ?>
                </select>
                <span>Categoria:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <select name="id_sub_categoria" id="id_sub_categoria" required="required">
                    <option value=""></option>
                </select>
                <select hidden id="id_sub_categoria2" name="id_sub_categoria2">
                    <option value=""></option>
                    <?php foreach ($lista_tbl_sub_categorias as $registro) { ?>
                        <option value="<?php echo $registro['id_sub_categoria'] ?>" data-categoria="<?php echo $registro['id_categoria'] ?>">
                            <?php echo $registro['nombre_sub_categoria'] ?>
                        </option>
                    <?php } ?>
                </select>
                <span>Sub categoria:</span>
            </div>

            <div class="inputBox">
                <select name="nit_identificacion" id="nit_identificacion" required="required">
                    <option selected hidden></option>
                    <?php foreach ($tienda as $registro) { ?>
                        <option value="<?php echo $registro['nit_identificacion'] ?>">
                            <?php echo $registro['nombre_tienda'] ?> - <?php echo $registro['nit_identificacion'] ?>
                        </option>
                    <?php } ?>
                </select>
                <span>Nit tienda:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <select name="color_producto" id="color_producto" required="required">
                    <option value="" selected hidden>Selecciona un color</option>
                    <option value="#000000">Negro</option>
                    <option value="#8a2be2">Azul violeta</option>
                    <option value="#dc143c">Rojo carmesí</option>
                    <option value="#20b2aa">Turquesa</option>
                    <option value="#9370db">Lavanda</option>
                    <option value="#32cd32">Verde lima</option>
                    <option value="#ff69b4">Rosa claro</option>
                    <option value="#1e90ff">Azul acero</option>
                    <option value="#ff4500">Rojo anaranjado</option>
                    <option value="#adff2f">Verde amarillo</option>
                    <option value="#9932cc">Púrpura oscuro</option>
                    <option value="#8b4513">Marrón silla de montar</option>
                    <option value="#228b22">Verde bosque</option>
                    <option value="#ff6347">Tomate</option>
                    <option value="#00fa9a">Verde medio mar</option>
                    <option value="#4b0082">Índigo</option>
                    <option value="#7fff00">Verde carta</option>
                    <option value="#ba55d3">Orquídea medio</option>
                    <option value="#ff7f50">Coral claro</option>
                    <option value="#40e0d0">Turquesa medio</option>
                    <option value="#800000">Marrón</option>
                    <option value="#00ced1">Azul oscuro turquesa</option>
                    <option value="#ff8c00">Naranja oscuro</option>
                    <option value="#b8860b">Dorado oscuro</option>
                    <option value="#008080">Teal</option>
                    <option value="#556b2f">Olivino</option>
                    <option value="#4682b4">Azul acero claro</option>
                    <option value="#2e8b57">Verde mar oscuro</option>
                    <option value="#87ceeb">Azul cielo</option>
                    <option value="#8b008b">Magenta oscuro</option>
                    <option value="#b0c4de">Azul acero claro</option>
                    <option value="#cd853f">Bronceado</option>
                    <option value="#cd5c5c">Rosado claro</option>
                    <option value="#008b8b">Cyan oscuro</option>
                    <option value="#d8bfd8">Lila</option>
                    <option value="#ff1493">Rosa brillante</option>
                    <option value="#dda0dd">Violeta pálido</option>
                    <option value="#6a5acd">Azul lavanda</option>
                    <option value="#7fffd4">Turquesa agua</option>
                    <option value="#c71585">Rosa medio violeta</option>
                    <option value="#f0e68c">Amarillo caña</option>
                    <option value="#ffefd5">Almendra</option>
                    <option value="#ffebcd">Blanco almendra</option>
                    <option value="#d2b48c">Marrón claro</option>
                </select>
                <span class="color">Color</span>
            </div>

            <div class="inputBox">
                <input type="text" id="cantidad_disponible" name="cantidad_disponible" required="required">
                <span class="color">Cantidad color:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="file" id="img_producto" name="img_producto" onchange="mostrarImagenPreview('img_producto', 'imagenPreview')" required="required">
                <span>Imagen 1:</span>
                <div class="previzualizar_imagen" id="imagenPreview"></div>
            </div>

            <div class="inputBox">
                <input type="file" id="img_producto2" name="img_producto2" onchange="mostrarImagenPreview('img_producto2', 'imagenPreview2')" required="required">
                <span>Imagen 2:</span>
                <div class="previzualizar_imagen" id="imagenPreview2"></div>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="file" id="img_producto3" name="img_producto3" onchange="mostrarImagenPreview('img_producto3', 'imagenPreview3')" required="required">
                <span>Imagen 3:</span>
                <div class="previzualizar_imagen" id="imagenPreview3"></div>
            </div>

            <div class="inputBox">
                <input type="file" id="img_producto4" name="img_producto4" onchange="mostrarImagenPreview('img_producto4', 'imagenPreview4')" required="required">
                <span>Imagen 4:</span>
                <div class="previzualizar_imagen" id="imagenPreview4"></div>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="file" id="img_producto5" name="img_producto5" onchange="mostrarImagenPreview('img_producto5', 'imagenPreview5')" required="required">
                <span>Imagen 5:</span>
                <div class="previzualizar_imagen" id="imagenPreview5"></div>
            </div>

            <div class="inputBox">
                <input type="file" id="img_producto6" name="img_producto6" onchange="mostrarImagenPreview('img_producto6', 'imagenPreview6')" required="required">
                <span>Imagen 6:</span>
                <div class="previzualizar_imagen" id="imagenPreview6"></div>
            </div>
        </div>

        <div class="caja_productoos">
            <!-- Campos ocultos por defecto -->
            <div class="inputBox" id="camposOcultos" style="display: none;">
                <textarea id="especificaciones_p" name="especificaciones_p" rows="2"></textarea>
                <span>Especificaciones del producto:</span>
            </div>
        </div>

        <div class="caja_botones">
            <div class="caja_boton1">
                <button type="submit" class="btn">Crear Producto</button>
            </div>
            <div class="caja_boton2">
                <button type="button" onclick="mostrarOcultarCampos()" class="agregar_campos">
                    Agregar campos
                </button>
            </div>
        </div>
    </div>

</form>


<script src="archivos.js/redireccionarboton.js"></script>
<script src="archivos.js/redireccionar_misproductos.js"></script>
<script src="archivos.js/campos_ocultos.js"></script>
<script src="archivos.js/vizualizar_imagen.js"></script>
<script src="archivos.js/categoria_sub_categoria.js"></script>
<script src="../../js/solonumeros3.js"></script>
<script src="../../js/sololetras.js"></script>
<script src="archivos.js/solo_imagenes.js"></script>
<script src="archivos.js/genero_categoria_talla.js"></script>

<style>
    .previzualizar_imagen img {
        width: 150px;
        /* Establece el ancho máximo al 100% del contenedor */
        height: 150px;
        position: relative;
        left: 40px;
        top: 70px;
        padding: 5px;
        border: 2px solid #258555;
        border-radius: 5px;
    }

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

    textarea {
        width: 100%;
        height: 100%;
        resize: vertical;
        /* Permite el ajuste vertical */
    }

    .singup {
        color: #000;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        font-weight: bold;
        font-size: x-large;
        margin-top: 1.5em;
        position: relative;
        top: -5px;
    }

    .card_crear_producto {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
        width: 630px;
        flex-direction: column;
        gap: 35px;
        border-radius: 8px;
        background: #e3e3e3;
        box-shadow: 12px 16px 32px #258555,
            -16px -16px 32px #fefefe;
        border-radius: 8px;
        position: relative;
        left: 30%;
        margin-bottom: 60px;
    }

    .inputBox {
        position: relative;
        width: 250px;
    }

    .inputBox input,
    .inputBox select,
    .inputBox textarea {
        width: 100%;
        padding: 10px;
        outline: none;
        border: none;
        color: #000;
        font-size: 1em;
        background: transparent;
        border-left: 2px solid #000;
        border-bottom: 2px solid #000;
        transition: 0.1s;
        border-bottom-left-radius: 8px;
    }

    .inputBox span {
        margin-top: -5px;
        position: absolute;
        left: 0;
        transform: translateY(-4px);
        margin-left: 10px;
        padding: 10px;
        pointer-events: none;
        font-size: 12px;
        color: #000;
        text-transform: uppercase;
        transition: 0.5s;
        letter-spacing: 3px;
        border-radius: 8px;
    }

    .inputBox input:valid~span,
    .inputBox input:focus~span,
    .inputBox select:valid~span,
    .inputBox select:focus~span,
    .inputBox textarea:valid~span,
    .inputBox textarea:focus~span {
        transform: translateX(113px) translateY(-15px);
        font-size: 12px;
        padding: 5px 10px;
        background: #258555;
        letter-spacing: 0.2em;
        color: #fff;
        border: 2px;
    }

    .inputBox input:valid,
    .inputBox input:focus,
    .inputBox select:valid,
    .inputBox select:focus,
    .inputBox textarea:valid,
    .inputBox textarea:focus {
        border: 2px solid #000;
        border-radius: 8px;
    }

    .enter {
        height: 45px;
        width: 100px;
        border-radius: 5px;
        border: 2px solid #000;
        cursor: pointer;
        background-color: transparent;
        transition: 0.5s;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: 2px;
        margin-bottom: 3em;
    }

    .enter:hover {
        background-color: rgb(0, 0, 0);
        color: white;
    }

    .caja_productoos {
        display: flex;
    }

    .caja_productoos .inputBox {
        margin: 20px;
    }

    .button_retrocederrr {
        display: block;
        position: relative;
        width: 56px;
        height: 56px;
        margin: 0;
        overflow: hidden;
        outline: none;
        background-color: transparent;
        border: 0;
    }

    .button_retrocederrr:before,
    .button_retrocederrr:after {
        content: "";
        position: absolute;
        border-radius: 50%;
        inset: 7px;
    }

    .button_retrocederrr:before {
        border: 4px solid #258555;
        transition: opacity .4s cubic-bezier(.77, 0, .175, 1) 80ms, transform .5s cubic-bezier(.455, .03, .515, .955) 80ms;
    }

    .button_retrocederrr:after {
        border: 4px solid #258555;
        transform: scale(1.3);
        transition: opacity .4s cubic-bezier(.165, .84, .44, 1), transform .5s cubic-bezier(.25, .46, .45, .94);
        opacity: 0;
    }

    .button_retrocederrr:hover:before,
    .button_retrocederrr:focus:before {
        opacity: 0;
        transform: scale(0.7);
        transition: opacity .4s cubic-bezier(.165, .84, .44, 1), transform .5s cubic-bezier(.25, .46, .45, .94);
    }

    .button_retrocederrr:hover:after,
    .button_retrocederrr:focus:after {
        opacity: 1;
        transform: scale(1);
        transition: opacity .4s cubic-bezier(.77, 0, .175, 1) 80ms, transform .5s cubic-bezier(.455, .03, .515, .955) 80ms;
    }

    .button-box {
        display: flex;
        position: absolute;
        top: 0;
        left: 0;
    }

    .button-elem {
        display: block;
        width: 20px;
        height: 20px;
        margin: 17px 18px 0 18px;
        transform: rotate(180deg);
        fill: #258555;
    }

    .button_retrocederrr:hover .button-box,
    .button_retrocederrr:focus .button-box {
        transition: .4s;
        transform: translateX(-56px);
    }

    /* estilos boton enviar formulario */
    .btn {
        padding: 10px 35px;
        cursor: pointer;
        background-color: #212121;
        border-radius: 6px;
        border: 2px solid #212121;
        box-shadow: 6px 6px 10px rgba(0, 0, 0, 1),
            1px 1px 10px rgba(255, 255, 255, 0.6);
        color: #fff;
        font-size: 15px;
        font-weight: bold;
        transition: 0.35s;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 6px 6px 10px rgba(0, 0, 0, 1),
            1px 1px 10px rgba(255, 255, 255, 0.6),
            inset 2px 2px 10px rgba(0, 0, 0, 1),
            inset -1px -1px 5px rgba(255, 255, 255, 0.6);
    }

    .btn:focus {
        transform: scale(1.05);
        box-shadow: 6px 6px 10px rgba(0, 0, 0, 1),
            1px 1px 10px rgba(255, 255, 255, 0.6),
            inset 2px 2px 10px rgba(0, 0, 0, 1),
            inset -1px -1px 5px rgba(255, 255, 255, 0.6);
    }

    /* Estilos de agregar campos */
    .agregar_campos {
        font-size: 17px;
        color: #000;
        font-family: inherit;
        font-weight: 800;
        cursor: pointer;
        position: relative;
        top: -50px;
        border: none;
        background: none;
        text-transform: uppercase;
        transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        transition-duration: 400ms;
        transition-property: color;
    }

    .agregar_campos:focus,
    .agregar_campos:hover {
        color: #258555;
    }

    .agregar_campos:focus:after,
    .agregar_campos:hover:after {
        width: 100%;
        left: 0%;
    }

    .agregar_campos:after {
        content: "";
        pointer-events: none;
        bottom: -2px;
        left: 50%;
        position: absolute;
        width: 0%;
        height: 2px;
        background-color: #258555;
        transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        transition-duration: 400ms;
        transition-property: width, left;
    }
</style>

<style>
    /* estilo de las posiciones de los botones */
    .caja_botones {
        display: flex;
    }

    .caja_boton1 {
        margin: 30px;
        position: relative;
        top: -40px;
    }

    .caja_boton2 {
        margin: 30px;
        position: relative;
        top: 15px;
    }
</style>

<!-- ESTILOS RESPONSI -->

<style>
    @media (max-width: 900px) {
        .singup {
            color: #000;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            font-weight: bold;
            font-size: x-large;
            margin-top: 1.5em;
            position: relative;
            top: -5px;
        }

        .card_crear_producto {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            width: 630px;
            flex-direction: column;
            gap: 35px;
            border-radius: 8px;
            background: #e3e3e3;
            box-shadow: 12px 16px 32px #258555,
                -16px -16px 32px #fefefe;
            border-radius: 8px;
            position: relative;
            left: 20%;
            top: -10px;
            margin-bottom: 60px;
        }

        .caja_productoos {
            display: flex;
        }

        .caja_productoos .inputBox {
            margin: 20px;
        }

        .button_retrocederrr {
            display: block;
            position: relative;
            right: 80px;
            width: 56px;
            height: 56px;
            margin: 0;
            overflow: hidden;
            outline: none;
            background-color: transparent;
            border: 0;
        }
    }
</style>