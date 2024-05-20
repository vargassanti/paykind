<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Vendedor") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$sql = "SELECT c.*, p.nombre, p.img_producto
FROM tbl_carrito as c 
INNER JOIN tbl_productos as p ON p.id_producto = c.id_producto
ORDER BY id_carrito DESC LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$ultimoProducto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($ultimoProducto) {
    $id_producto_agregado = $ultimoProducto['id_producto'];
}

$product_r = $conexion->prepare("SELECT p.*
    FROM tbl_productos p
    WHERE p.id_sub_categoria = (
        SELECT pr.id_sub_categoria
        FROM tbl_carrito c
        INNER JOIN tbl_productos pr ON c.id_producto = pr.id_producto
        WHERE c.id_carrito = (
            SELECT MAX(id_carrito)
            FROM tbl_carrito
        )
    )
    AND p.id_producto != :id_producto_agregado 
");

$product_r->bindParam(':id_producto_agregado', $id_producto_agregado);
$product_r->execute();
$product_relacionados = $product_r->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<?php if (empty($ultimoProducto)) { ?>
    <p class="no_hay_carrito">No hay productos en el carrito</p>
<?php
} else { ?>
    <div class="productos_carrito_a">
        <div class="prodcts1">
            <div class="container_img_p">
                <?php if ($ultimoProducto) { ?>
                    <img src="./imagenes_producto/<?php echo $ultimoProducto['img_producto'] ?>" alt="">
                <?php } ?>
            </div>
            <img class="posicion_aprobado" src="../../imagen/aprobado.png" alt="">
            <div class="container_p">
                <?php if ($ultimoProducto) { ?>
                    <H3>Agregaste a tu carrito</H3>
                    <p><?php echo $ultimoProducto['nombre'] ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="prodcts2">
            <p><?php foreach ($contador as $cont) {
                    echo $cont['contador'];
                } ?>
                productos en tu carrito: </p>
            <p> Total: <?php echo number_format($total, 0, '.', ','); ?></p>
        </div>
        <div class="prodcts3">
            <a href="../carrito/checkout.php">
                <button class="ver_carrito">Ver carrito</button>
            </a>
            <a href="../carrito/finalizar_compra.php">
                <button class="ver_carrito">Finaliza compra</button>
            </a>
        </div>
    </div>
<?php } ?>

<?php if ($product_relacionados) { ?>
    <div class="ofertas">
        <h2 class="h2_oferta">Quienes compraron este producto también compraron</h2>
    </div>
    <div class="Carousel">
        <div class="slick-list" id="slick-list">
            <button class="slick-arrow slick-prev" id="button-prev" data-button="button-prev" onclick="app.processingButton(event)">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
                </svg>
            </button>
            <div class="slick-track" id="track">
                <?php foreach ($product_relacionados as $registro) {
                    if ($registro['estado_producto'] == "Activo") {
                ?>
                        <div class="slick">
                            <div>
                                <a href="info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=productos_carrito.php">
                                    <h4>
                                        <small>
                                            <?php echo $registro['nombre']; ?>
                                        </small>
                                    </h4>
                                    <picture>
                                        <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" alt="" />
                                    </picture>
                                </a>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <button class="slick-arrow slick-next" id="button-next" data-button="button-next" onclick="app.processingButton(event)">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
                </svg>
            </button>
        </div>
    </div>
<?php } ?>
<div class="ofertas2">
    <h2 class="h2_oferta2">Productos que te podrian interesar</h2>
    <a class="a_oferta2" href="index.php">Ver mas...</a>
</div>
<div class="Carousel2">
    <div class="slick-list" id="slick-list">
        <button class="slick-arrow slick-prev" id="button-prev" data-button="button-prev" onclick="app.processingButton(event)">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
            </svg>
        </button>
        <div class="slick-track" id="track">
            <?php foreach ($lista_tbl_productos as $registro) {
                if ($registro['estado_producto'] == "Activo") {
            ?>
                    <div class="slick">
                        <div>
                            <a href="info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=productos_carrito.php">
                                <h4><?php echo $registro['nombre']; ?></h4>
                                <?php if ($registro['descuento_producto'] > 0) { ?>
                                    <div class="product-text">
                                        <h5><?php echo $registro['descuento_producto']; ?>%</h5>
                                    </div>
                                <?php } ?>
                                <picture>
                                    <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" alt="" />
                                </picture>
                            </a>
                        </div>
                    </div>
            <?php
                }
            } ?>
        </div>
        <button class="slick-arrow slick-next" id="button-next" data-button="button-next" onclick="app.processingButton(event)">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
            </svg>
        </button>
    </div>
</div>


<script src="../../js/carrusel_productos.js"></script>