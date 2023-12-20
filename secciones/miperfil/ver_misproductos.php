<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador" || $_SESSION["usuario_rol"] === "Cliente")) {
        $id_rol = $_SESSION["usuario_rol"];
    }
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['id_compra'])) {
    $id_compra = (isset($_GET['id_compra'])) ? $_GET['id_compra'] : "";
} else {
    header("location: index.php");
}

$sentencia = $conexion->prepare("SELECT c.*, d.*, p.*, s.color_producto
FROM tbl_compra as c
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario AS u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_stock as s ON d.id_stock = s.id_stock
WHERE u.id_usuario = :id_usuario AND d.estado_carrito = 'Completado' AND d.id_compra = :id_compra;");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->bindParam(":id_compra", $id_compra);
$sentencia->execute();
$lista_mi_compras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_mi_compras as $mi_producto) {
    $id_producto = $mi_producto['id_producto'];
}

include("../../templates/header.php");

?>
<p class="titulo_info_compra">Detalles de la Compra</p>
<p class="texto_coment">¿Te gustaría calificar algún producto? selecciona el que desees:</p>
<div class="container_ver_mis_comprasss">
    <?php
    foreach ($lista_mi_compras as $mi_producto) { ?>
        <div class="info-compra">
            <div class="imagen">
                <img src="../productos/imagenes_producto/<?php echo $mi_producto['img_producto'] ?>" alt="">
            </div>
            <hr>
            <div class="detalle">
                <div class="info">
                    <p class="titulo_product"><?php echo $mi_producto['nombre'] ?></p>
                    <p><strong>Cantidad: </strong><?php echo $mi_producto['cantidad'] ?></p>
                    <p><strong>Total compra: </strong><?php echo $mi_producto['total_compra'] ?></p>
                    <p><strong>Dirección: </strong><?php echo $mi_producto['direccion'] ?></p>
                    <p><strong>Color: </strong></p>
                    <span class="color-option" style="background-color: <?php echo $mi_producto['color_producto'] ?>"></span>
                </div>
                <a href="agregar_comentario.php?id_producto=<?php echo $mi_producto['id_producto'] ?>&id_compra=<?php echo $id_compra?>">
                    <button>Calificar</button>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
