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

    $sentencia = $conexion->prepare("DELETE FROM tbl_productos WHERE id_producto=:id_producto");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();
    $mensaje = "Registro eliminado";
    header("location:index.php?mensaje=" . $mensaje);
}

$ofertas = $conexion->prepare("SELECT * FROM tbl_productos GROUP BY id_producto");
$ofertas->execute();
$lista_tbl_productos_ofertas = $ofertas->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<h4 class="titulo_producto">Ofertas</h4>

<div class="container_producticos">
    <?php
    if (empty($lista_tbl_productos_ofertas)) {
        echo "<p>No hay productos en oferta en este momento.</p>";
    } else {
        foreach ($lista_tbl_productos_ofertas as $registro) {
            if ($registro['descuento_producto'] > 0) { ?>
                <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=ofertas.php">
                    <div class="caja2">
                        <img class="imagenn" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" data-src-hover="./imagenes_producto/<?php echo $registro['img_producto2']; ?>" class="img-fluid rounded" alt="" />
                        <div class="container_parrafos">
                            <p class="parrafos3">
                                <?php if ($registro['descuento_producto'] > 0) { ?>
                                    <span><del>$<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
                                    <hr>
                            <p class="precio_descuento3">
                                En oferta
                            </p>
                        <?php } else { ?>
                            <span style="font-size: 16xpx;">
                                $<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
                            </span>
                            <hr>
                        <?php } ?>
                        </p>
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
                        <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=ofertas.php">
                            <button class="CartBtn">
                                <span class="IconContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart">
                                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                                    </svg>
                                </span>
                                <p class="text">Ver más</p>
                            </button>
                        </a>
                        <?php if ($registro['descuento_producto'] > 0) { ?>
                            <button class="Boton_oferta">
                                <p><?php echo $registro['descuento_producto']; ?>%</p>
                            </button>
                        <?php } ?>
                    </div>
                </a>
        <?php
            }
        } ?>
    <?php
    }
    ?>
</div>

<script src="archivos.js/hover_img.js"></script>