<?php
session_start();
include("../../bd.php");
require '../../config.php';

// Inicializa $registro como un array vacío
$registro = [];

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['id_carrito'])) {
    $id_carrito = (isset($_GET['id_carrito'])) ? $_GET['id_carrito'] : "";

    $info_d = $conexion->prepare("SELECT d.*, p.*, t.*, v.id_usuario
    FROM tbl_carrito as d 
    INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
    WHERE v.id_usuario =:id_usuario AND d.id_carrito =:id_carrito");
    $info_d->bindParam(":id_usuario", $id_usuario);
    $info_d->bindParam(":id_carrito", $id_carrito);
    $info_d->execute();
    $informacion_detalle_compra = $info_d->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="container_detalle_compra">
        <div class="informacion_detalle_compraa">
            <?php foreach ($informacion_detalle_compra as $detalles_c) { ?>
                <h4>Información sobre el detalle:</h4>
                <img class="imagenn" src="imagenes_producto/<?php echo $detalles_c['img_producto'] ?>" alt="">
                <h3>Id detalle compra: <?php echo $detalles_c['id_carrito'] ?></h3>
                <h3>Nombre: <?php echo $detalles_c['nombre'] ?></h3>
                <h3>Precio: <?php echo number_format($detalles_c['precio'], 0, '.', ','); ?></h3>
                <h3>Cantidad: <?php echo $detalles_c['cantidad'] ?></h3>
                <h3>Estado carrito: <?php echo $detalles_c['estado_carrito'] ?></h3>
                <h3>Nit tienda: <?php echo $detalles_c['nit_identificacion'] ?></h3>
                <h3>Tienda: <?php echo $detalles_c['nombre_tienda'] ?></h3>
            <?php } ?>
        </div>
    </div>
    <?php
}

if (isset($_GET['id_compra'])) {
    $id_compra = (isset($_GET['id_compra'])) ? $_GET['id_compra'] : "";
    $c = (isset($_GET['c'])) ? $_GET['c'] : "";

    $info_c = $conexion->prepare("SELECT c.*, d.*, p.*, t.*, u.id_usuario
    FROM tbl_compra as c 
    INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
    WHERE c.id_compra =:id_compra;");
    $info_c->bindParam(":id_compra", $id_compra);
    $info_c->execute();
    $informacion_compra = $info_c->fetchAll(PDO::FETCH_ASSOC);

    switch ($c) {
        case 'aprobados':
    ?>
            <div class="container_detalle_compra">
                <div class="informacion_detalle_compraa">
                    <h4>Editar estado de la compra:</h4>
                    <?php
                    if ($informacion_compra && count($informacion_compra) > 1) { ?>
                        <h3 class="productos_agregados">Productos agregados:</h3>
                    <?php
                    } elseif ($informacion_compra && count($informacion_compra) === 1) { ?>
                        <h3 class="productos_agregados">Producto agregado:</h3>
                    <?php
                    } else {
                        echo "No hay productos disponibles";
                    }
                    foreach ($informacion_compra as $detalles) {
                        $id_compra_aprobado = $detalles['id_compra'];
                        $total_compra_aprobado = $detalles['total_compra'];
                        $costo_envio_aprobado = $detalles['costo_envio'];
                        $metodo_pago_aprobado = $detalles['metodo_pago'];
                        $cantidad_aprobado = $detalles['cantidad']; ?>
                        <h3><?php echo $detalles['nombre'] ?></h3>
                    <?php } ?>
                    <br>
                    <h3>Total compra: <?php echo number_format($total_compra_aprobado, 0, '.', ','); ?></h3>
                    <h3>Costo envio: <?php echo number_format($costo_envio_aprobado, 0, '.', ','); ?></h3>
                    <h3>Metodo pago: <?php echo $metodo_pago_aprobado ?></h3>
                    <h3>Cantidad: <?php echo $cantidad_aprobado ?></h3>
                    <form action="editar_carrito.php" method="POST">
                        <input type="hidden" name="id_compra" value="<?php echo $id_compra_aprobado ?>">
                        <div class="container-botones">
                            <div class="custom-select">
                                <select name="estado_carrito" required>
                                    <option selected hidden>Selecciona una opción: </option>
                                    <option value="espera_envio">En espera de envío</option>
                                </select>
                                <i class="bx bxs-chevron-down arrow_select"></i>
                            </div>
                            <button class="animated-button-editar" type="submit">
                                <span>Actualizar</span>
                                <span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php
            break;
        case 'proceso':
        ?>
            <div class="container_detalle_compra">
                <div class="informacion_detalle_compraa">
                    <h4>Editar estado de la compra:</h4>
                    <?php
                    if ($informacion_compra && count($informacion_compra) > 1) { ?>
                        <h3 class="productos_agregados">Productos agregados:</h3>
                    <?php
                    } elseif ($informacion_compra && count($informacion_compra) === 1) { ?>
                        <h3 class="productos_agregados">Producto agregado:</h3>
                    <?php
                    } else {
                        echo "No hay productos disponibles";
                    }
                    foreach ($informacion_compra as $detalles) {
                        $id_compra_proceso = $detalles['id_compra'];
                        $total_compra_proceso = $detalles['total_compra'];
                        $costo_envio_proceso = $detalles['costo_envio'];
                        $metodo_pago_proceso = $detalles['metodo_pago'];
                        $cantidad_proceso = $detalles['cantidad']; ?>
                        <h3><?php echo $detalles['nombre'] ?></h3>
                    <?php } ?>
                    <br>
                    <h3>Total compra: <?php echo number_format($total_compra_proceso, 0, '.', ','); ?></h3>
                    <h3>Costo envio: <?php echo number_format($costo_envio_proceso, 0, '.', ','); ?></h3>
                    <h3>Metodo pago: <?php echo $metodo_pago_proceso ?></h3>
                    <h3>Cantidad: <?php echo $cantidad_proceso ?></h3>
                    <form action="editar_carrito.php" method="POST">
                        <input type="hidden" name="id_compra" value="<?php echo $id_compra_proceso ?>">
                        <div class="container-botones">
                            <div class="custom-select">
                                <select name="estado_carrito" required>
                                    <option selected hidden>Selecciona una opción: </option>
                                    <option value="aprobado">Aprobado</option>
                                </select>
                                <i class="bx bxs-chevron-down arrow_select"></i>
                            </div>
                            <button class="animated-button-editar" type="submit">
                                <span>Actualizar</span>
                                <span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php
            break;
        case 'espera_envio':
        ?>
            <div class="container_detalle_compra">
                <div class="informacion_detalle_compraa">
                    <h4>Editar estado de la compra:</h4>
                    <?php
                    if ($informacion_compra && count($informacion_compra) > 1) { ?>
                        <h3 class="productos_agregados">Productos agregados:</h3>
                    <?php
                    } elseif ($informacion_compra && count($informacion_compra) === 1) { ?>
                        <h3 class="productos_agregados">Producto agregado:</h3>
                    <?php
                    } else {
                        echo "No hay productos disponibles";
                    }
                    foreach ($informacion_compra as $detalles) {
                        $id_compra_envio = $detalles['id_compra'];
                        $total_compra_envio = $detalles['total_compra'];
                        $costo_envio_envio = $detalles['costo_envio'];
                        $metodo_pago_envio = $detalles['metodo_pago'];
                        $cantidad_envio = $detalles['cantidad']; ?>
                        <h3><?php echo $detalles['nombre'] ?></h3>
                    <?php } ?>
                    <br>
                    <h3>Total compra: <?php echo number_format($total_compra_envio, 0, '.', ','); ?></h3>
                    <h3>Costo envio: <?php echo number_format($costo_envio_envio, 0, '.', ','); ?></h3>
                    <h3>Metodo pago: <?php echo $metodo_pago_envio ?></h3>
                    <h3>Cantidad: <?php echo $cantidad_envio ?></h3>
                    <form action="editar_carrito.php" method="POST">
                        <input type="hidden" name="id_compra" value="<?php echo $id_compra_envio ?>">
                        <div class="container-botones">
                            <div class="custom-select">
                                <select name="estado_carrito" required>
                                    <option selected hidden>Selecciona una opción: </option>
                                    <option value="transito">En tránsito</option>
                                </select>
                                <i class="bx bxs-chevron-down arrow_select"></i>
                            </div>
                            <button class="animated-button-editar" type="submit">
                                <span>Actualizar</span>
                                <span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php
            break;
        case 'en_transito':
        ?>
            <div class="container_detalle_compra">
                <div class="informacion_detalle_compraa">
                    <h4>Editar estado de la compra:</h4>
                    <?php
                    if ($informacion_compra && count($informacion_compra) > 1) { ?>
                        <h3 class="productos_agregados">Productos agregados:</h3>
                    <?php
                    } elseif ($informacion_compra && count($informacion_compra) === 1) { ?>
                        <h3 class="productos_agregados">Producto agregado:</h3>
                    <?php
                    } else {
                        echo "No hay productos disponibles";
                    }
                    foreach ($informacion_compra as $detalles) {
                        $id_compra_transito = $detalles['id_compra'];
                        $total_compra_transito = $detalles['total_compra'];
                        $costo_envio_transito  = $detalles['costo_envio'];
                        $metodo_pago_transito  = $detalles['metodo_pago'];
                        $cantidad_transito  = $detalles['cantidad']; ?>
                        <h3><?php echo $detalles['nombre'] ?></h3>
                    <?php } ?>
                    <br>
                    <h3>Total compra: <?php echo number_format($total_compra_transito , 0, '.', ','); ?></h3>
                    <h3>Costo envio: <?php echo number_format($costo_envio_transito , 0, '.', ','); ?></h3>
                    <h3>Metodo pago: <?php echo $metodo_pago_transito ?></h3>
                    <h3>Cantidad: <?php echo $cantidad_transito  ?></h3>
                    <form action="editar_carrito.php" method="POST">
                        <input type="hidden" name="id_compra" value="<?php echo $id_compra_transito ?>">
                        <div class="container-botones">
                            <div class="custom-select">
                                <select name="estado_carrito" required>
                                    <option selected hidden>Selecciona una opción: </option>
                                    <option value="completado">Completado</option>
                                </select>
                                <i class="bx bxs-chevron-down arrow_select"></i>
                            </div>
                            <button class="animated-button-editar" type="submit">
                                <span>Actualizar</span>
                                <span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php
            break;
        case 'entregado':
        ?>
            <div class="container_detalle_compra">
                <div class="informacion_detalle_compraa">
                    <?php foreach ($informacion_compra as $detalles) { ?>
                        <h4>Editar de la compra:</h4>
                        <h3>Total compra: <?php echo number_format($detalles['total_compra'], 0, '.', ','); ?></h3>
                        <h3>Costo envio: <?php echo number_format($detalles['costo_envio'], 0, '.', ','); ?></h3>
                        <h3>Metodo pago: <?php echo $detalles['metodo_pago'] ?></h3>
                        <h3>Cantidad: <?php echo $detalles['cantidad'] ?></h3>
                        <h3>Nombre: <?php echo $detalles['nombre'] ?></h3>
                        <form action="editar_carrito.php" method="POST">
                            <input type="hidden" name="id_detalle_compra" value="<?php echo $detalles['id_detalle_compra'] ?>">
                            <select name="estado_carrito" id="estado_carrito" required>
                                <option value=""><?php echo $detalles['estado_carrito'] ?></option>
                                <option value="completado">Completado</option>
                            </select>
                            <button type="submit">
                                enviar
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </div>
<?php
            break;
        default:
            echo "No se ha especificado un tipo de compra vista_rapida.";
            break;
    }
}

?>