<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT img_producto FROM `tbl_productos` WHERE id_producto=:id_producto");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_recuperado["img_producto"]) && $registro_recuperado["img_producto"] != "") {
        if (file_exists("./imagenes_producto/" . $registro_recuperado["img_producto"])) {
            unlink("./imagenes_producto/" . $registro_recuperado["img_producto"]);
        }
    }

    // Consulta para obtener los nombres de las imágenes asociadas al producto
    $sentencia = $conexion->prepare("SELECT img_producto, img_producto2, img_producto3, img_producto4, img_producto5, img_producto6 FROM tbl_productos WHERE id_producto = :id_producto");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();

    if ($sentencia->rowCount() > 0) {
        $row = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Luego, eliminar el registro de la tabla tbl_productos
        $eliminar_producto = $conexion->prepare("DELETE FROM tbl_productos WHERE id_producto = :id_producto");
        $eliminar_producto->bindParam(":id_producto", $txtID);
        $eliminar_producto->execute();

        // Eliminar todas las imágenes de la carpeta del proyecto
        $imagenes_a_eliminar = array($row['img_producto'], $row['img_producto2'], $row['img_producto3'], $row['img_producto4'], $row['img_producto5'], $row['img_producto6']);

        foreach ($imagenes_a_eliminar as $imagen) {
            if (file_exists('./imagenes_producto/' . $imagen)) {
                unlink('./imagenes_producto/' . $imagen);
            }
        }

        $mensaje = "Registro eliminado";
        header("location:mis_productos.php?mensaje=" . $mensaje);
    } else {
        // Producto no encontrado, maneja el error o redirige a otra página
    }
}

include("../../templates/header.php"); ?>


<h4 class="titulo_producto">Productos</h4>

<input type="checkbox" id="btn-modal">
<div class="container-modal" id="modal">
    <div class="content-modal">
        <div id="vista-rapida-content"></div>
        <div class="position__boton">
            <div class="fondo_boton_cerrar" onclick="cerrarModal()">
                <i class='bx bx-x'></i>
            </div>
        </div>
    </div>
    <label onclick="cerrarModal()" class="cerrar-modal"></label>
</div>

<div class="container_producticos">
    <?php foreach ($lista_tbl_productos as $registro) {
        $precio_desc = $registro['precio'] - ($registro['precio'] * floatval($registro['descuento_producto']) / 100);
        if ($registro['estado_producto'] == "Activo") {
    ?>
            <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=index.php">
                <div class="caja2">
                    <img class="imagenn" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" data-src-hover="./imagenes_producto/<?php echo $registro['img_producto2']; ?>" class="img-fluid rounded" alt="" />
                    <div class="container_parrafos">
                        <p class="parrafos3">
                            <?php if ($registro['descuento_producto'] > 0) { ?>
                                <span><del>$<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
                                <hr>
                        <p class="precio_descuento3">
                            $<?php echo number_format($precio_desc, 0, '.', '.'); ?>
                        </p>

                    <?php } else { ?>
                        <span style="font-size: 16xpx;">
                            $<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
                        </span>
                        <hr>
                        <p class="precio_descuento2">
                            En oferta
                        </p>
                    <?php
                            }  ?>
                    </p>
                    <div class="nombre_p">
                        <p>
                            <?php
                            $contenido = $registro['nombre'];
                            $limite_letras = 23;

                            if (strlen($contenido) > $limite_letras) {
                                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                echo $contenido_limitado;
                            } else {
                                echo $contenido;
                            }
                            ?>
                        </p>
                    </div>

                    </div>
                    <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=index.php">
                        <button class="CartBtn">
                            <span class="IconContainer">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart">
                                    <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                                </svg>
                            </span>
                            <p class="text">Ver más</p>
                        </button>
                    </a>
                    <a onclick="cargarVistaRapida(<?php echo $registro['id_producto']; ?>)">
                        <button class="Btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                <path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path>
                                <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path>
                            </svg>
                        </button>
                    </a>
                    <?php if ($registro['descuento_producto'] > 0) { ?>
                        <button class="Boton_oferta">
                            <p><?php echo $registro['descuento_producto']; ?>%</p>
                        </button>
                    <?php } ?>
                </div>
            </a>
    <?php }
    } ?>
</div>
<button class="boton_volver_arriba_p" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
    <i class='bx bx-up-arrow-alt'></i>
</button>
<script>
    // JavaScript para scroll suave hacia arriba
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
<script src="archivos.js/carrusel_productos.js"></script>
<script src="archivos.js/modal.js"></script>
<script src="archivos.js/hover_img.js"></script>