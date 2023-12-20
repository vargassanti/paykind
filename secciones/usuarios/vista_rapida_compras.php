<?php
session_start();
include("../../bd.php");
require '../../config.php';

// Inicializa $registro como un array vacío
$registro = [];

if (isset($_GET['id_compra'])) {
    $id_compra = (isset($_GET['id_compra'])) ? $_GET['id_compra'] : "";

    $info_c = $conexion->prepare("SELECT c.*, d.*, t.*, u.*, s.*, p.*
    FROM tbl_compra as c 
	INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
    WHERE c.id_compra =:id_compra AND s.id_stock = d.id_stock;");
    $info_c->bindParam(":id_compra", $id_compra);
    $info_c->execute();
    $informacion_compra = $info_c->fetchAll(PDO::FETCH_ASSOC);
}

?>

<div class="container_detalle_compra">
    <h4>Detalles de la compra:</h4>
    <div class="informacion_detalle_c">
        <div class="contenedor-compra">
            <?php foreach ($informacion_compra as $detalles) { ?>
                <div class="informacion_del_producto">
                    <p class="titulo">Informacion producto:</p>
                    <p>Imagen producto: </p>
                    <img class="imagenn" src="../productos/imagenes_producto/<?php echo $detalles['img_producto'] ?>" alt="">
                    <p>Nombre: <?php echo $detalles['nombre'] ?></p>
                    <p>Precio: <?php echo $detalles['precio'] ?></p>
                    <p>Cantidad: <?php echo $detalles['cantidad'] ?></p>
                    <p>Color: </p>
                    <span class="color-option" style="background-color: <?php echo $detalles['color_producto'] ?>;"></span>
                </div>
            <?php } ?>
            <div class="informacion_del_pago">
                <p class="titulo">Informacion del pago:</p>
                <p>Total compra: $<?php echo number_format($detalles['total_compra'], 0, '.', ','); ?></p>
                <p>Costo envio: <?php echo number_format($detalles['costo_envio'], 0, '.', ','); ?></p>
                <p>Metodo pago: <?php echo $detalles['metodo_pago'] ?></p>
                <?php
                if ($detalles['metodo_pago'] == 'Efectivo') {
                } else { ?>
                    <p>Comprobante de la transferencia:</p>
                    <img class="imagenn_comprobante" src="../carrito/imagenes_transferencia/<?php echo $detalles['imagen_tranferencia'] ?>" alt="">
                <?php } ?>
                <p>Fecha compra: <?php echo $detalles['fecha_compra'] ?></p>
                <p>Estado carrito: <?php echo $detalles['estado_carrito'] ?></p>
            </div>
            <div class="informacion_del_usuario">
                <p class="titulo">Informacion del usuario:</p>
                <p>Id usuario: <?php echo $detalles['id_usuario'] ?></p>
                <p>Nombres: <?php echo $detalles['nombres_u'] ?></p>
                <p>Apelidos: <?php echo $detalles['apellidos_u'] ?></p>
                <p>Correo: <?php echo $detalles['correo'] ?></p>
            </div>
        </div>

    </div>
</div>