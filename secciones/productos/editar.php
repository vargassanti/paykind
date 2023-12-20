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

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("SELECT p.*, s.*
    FROM tbl_productos as p 
    INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
    WHERE p.id_producto =:id_producto;");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $nombre = $registro["nombre"];
    $descripcion = $registro["descripcion"];
    $precio = $registro["precio"];
    $cantidad_unidades = $registro["cantidad_unidades"];
    $descuento_producto = $registro["descuento_producto"];
    $descuento = $registro["descuento"];
    $especificaciones_p = $registro["especificaciones_p"];
    $color_producto = $registro["color_producto"];
    $img_producto = $registro['img_producto'];
    $img_producto2 = $registro['img_producto2'];
    $img_producto3 = $registro['img_producto3'];
    $img_producto4 = $registro['img_producto4'];
    $img_producto5 = $registro['img_producto5'];
    $img_producto6 = $registro['img_producto6'];
    $id_categoria = $registro['id_categoria'];
    $cantidad_disponible = $registro['cantidad_disponible'];
    $id_stock = $registro['id_stock'];
    $estado_producto = $registro['estado_producto'];

    if (isset($_GET['txtID'])) {
        $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

        $sentencia = $conexion->prepare("SELECT p.*, s.*
        FROM tbl_productos as p 
        INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
        WHERE p.id_producto =:id_producto");
        $sentencia->bindParam(":id_producto", $txtID);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Aquí obtén los valores del registro
        $nombre = $registro["nombre"];
        $descripcion = $registro["descripcion"];
        $precio = $registro["precio"];
        $cantidad_disponible = $registro["cantidad_disponible"];
        $color_producto = $registro["color_producto"];
        $especificaciones_p = $registro["especificaciones_p"];
        $descuento_producto = $registro["descuento_producto"];
    }

    $stock_producto = $conexion->prepare("SELECT s.*, p.*, t.*, v.id_usuario
    FROM tbl_stock as s
    INNER JOIN tbl_productos as p ON p.id_producto = s.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
    WHERE s.id_producto = :id_producto 
    AND v.id_usuario = :id_usuario");
    $stock_producto->bindParam(":id_producto", $txtID);
    $stock_producto->bindParam(":id_usuario", $id_usuario);
    $stock_producto->execute();
    $total_stock_p = $stock_producto->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php include("../../templates/header.php"); ?>

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
<form action="editar_producto.php" method="post" enctype="multipart/form-data">
    <div class="card_crear_producto">
        <a class="singup">Editar producto</a>

        <div class="caja_productoos">
            <div class="inputBox" style="display: none;">
                <input type="hidden" id="txtID" name="txtID" value="<?php echo $txtID; ?>">
                <span>Id producto:</span>
            </div>

            <div class="inputBox" style="display: none;">
                <input type="hidden" id="id_stock" name="id_stock" value="<?php echo $id_stock; ?>">
                <span>Id stock:</span>
            </div>

            <div class="inputBox">
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required="required">
                <span>Nombre:</span>
            </div>

            <div class="inputBox">
                <textarea id="descripcion" name="descripcion" rows="1" required="required" onkeypress="return soloLetras(event)"><?php echo $descripcion; ?></textarea>
                <span>Descripción:</span>
            </div>
        </div>
        <div class="caja_productoos">
            <div class="inputBox">
                <input type="text" id="precio" name="precio" value="<?php echo $precio; ?>" step="0.01" required="required">
                <span>Precio:</span>
            </div>

            <div class="inputBox">
                <input type="text" id="descuento" name="descuento" value="<?php echo $descuento_producto; ?>" required="required">
                <span>Descuento:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="text" id="cantidad_disponible" name="cantidad_disponible" value="<?php echo $cantidad_disponible; ?>" required="required">
                <span>Unidades:</span>
            </div>

            <div class="inputBox">
                <select id="estado_producto" name="estado_producto" required="required">
                    <option value="Activo" <?php if ($estado_producto === 'Activo') echo 'selected'; ?>>Activo</option>
                    <option value="Inactivo" <?php if ($estado_producto === 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                </select>
                <span>Estado producto:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="file" id="img_producto" name="img_producto" accept="image/*" onchange="mostrarImagenPreview('img_producto', 'imagenPreview')">
                <span>Imagen 1:</span>
                <div class="previzualizar_imagen" id="imagenPreview">
                    <img src="./imagenes_producto/<?php echo $img_producto ?>" alt="">
                </div>
            </div>

            <div class="inputBox">
                <input type="file" id="img_producto2" name="img_producto2" accept="image/*" onchange="mostrarImagenPreview('img_producto2', 'imagenPreview2')">
                <span>Imagen 2:</span>
                <div class="previzualizar_imagen" id="imagenPreview2">
                    <img src="./imagenes_producto/<?php echo $img_producto2 ?>" alt="">
                </div>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="file" id="img_producto3" name="img_producto3" accept="image/*" onchange="mostrarImagenPreview('img_producto3', 'imagenPreview3')">
                <span>Imagen 3:</span>
                <div class="previzualizar_imagen" id="imagenPreview3">
                    <img src="./imagenes_producto/<?php echo $img_producto3 ?>" alt="">
                </div>
            </div>

            <div class="inputBox">
                <input type="file" id="img_producto4" name="img_producto4" accept="image/*" onchange="mostrarImagenPreview('img_producto4', 'imagenPreview4')">
                <span>Imagen 4:</span>
                <div class="previzualizar_imagen" id="imagenPreview4">
                    <img src="./imagenes_producto/<?php echo $img_producto4 ?>" alt="">
                </div>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox">
                <input type="file" id="img_producto5" name="img_producto5" accept="image/*" onchange="mostrarImagenPreview('img_producto5', 'imagenPreview5')">
                <span>Imagen 5:</span>
                <div class="previzualizar_imagen" id="imagenPreview5">
                    <img src="./imagenes_producto/<?php echo $img_producto5 ?>" alt="">
                </div>
            </div>

            <div class="inputBox">
                <input type="file" id="img_producto6" name="img_producto6" accept="image/*" onchange="mostrarImagenPreview('img_producto6', 'imagenPreview6')">
                <span>Imagen 6:</span>
                <div class="previzualizar_imagen" id="imagenPreview6">
                    <img src="./imagenes_producto/<?php echo $img_producto6 ?>" alt="">
                </div>
            </div>
        </div>

        <div class="caja_productoos">
            <!-- Campos ocultos por defecto -->
            <div class="inputBox" id="camposOcultos" style="display: none;">
                <textarea id="especificaciones_p" name="especificaciones_p" rows="2"><?php echo $especificaciones_p; ?></textarea>
                <span>Especificaciones del producto:</span>
            </div>
        </div>

        <div class="caja_productoos">
            <div class="inputBox" id="camposOcultos" style="display: none;">
                <select name="color_producto" id="color_producto" required="required">
                    <option selected value="<?php echo $color_producto; ?>"><?php echo $color_producto; ?></option>
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
                <span>Color:</span>
            </div>
        </div>

        <p class="titulo_editar_r">Referencias: </p>
        <div class="container_referencia">
            <?php
            $contador = 1;

            foreach ($total_stock_p as $products) { ?>
                <div class="referencia_p">
                    <p><?php echo $contador . " . " . "Referencia" ?></p>
                    <?php $contador++; ?>
                    <div class="opciones_refencia">
                        <div class="boton_e">
                            <a href="editar_referencia.php?id_stock=<?php echo $products['id_stock'] ?>&id_producto=<?php echo $products['id_producto'] ?>&ruta=mis_productos.php">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                        </div>
                        <div class="boton_ed">
                            <a onclick="eliminarReferencia(<?php echo $products['id_stock']; ?>, <?php echo $products['id_producto']; ?>)">
                                <i class='bx bx-trash-alt'></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <a href="añadir_referencia.php?txtID=<?php echo $txtID ?>">
            <button type="button" class="crear_referenciass">
                Crear otra referencia
            </button>
        </a>

        <div class="caja_botones">
            <div class="caja_boton1">
                <button type="submit" class="btn">Actualizar producto</button>
            </div>
            <div class="caja_boton2">
                <button type="button" onclick="mostrarOcultarCampos()" class="agregar_campos">
                    Ver los demás campos
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
<script src="archivos.js/eliminar_referencia.js"></script>
<script src="../../js/solonumeros3.js"></script>
<script src="../../js/sololetras.js"></script>
