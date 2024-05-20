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

$sentencia = $conexion->prepare("SELECT DISTINCT c.*, d.*, p.*, s.color_producto
FROM tbl_compra as c
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario AS u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_stock as s ON d.id_stock = s.id_stock
WHERE u.id_usuario = :id_usuario AND d.id_compra = :id_compra AND s.id_stock = d.id_stock");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->bindParam(":id_compra", $id_compra);
$sentencia->execute();
$lista_mi_compras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_mi_compras as $mi_producto) {
    $id_producto = $mi_producto['id_producto'];
    $estado_carrito = $mi_producto['estado_carrito'];
    $total_compra = $mi_producto['total_compra'];
    $direccion_compra = $mi_producto['direccion'];
    $costo_envio_compra = $mi_producto['costo_envio'];
    $metodo_pago_compra = $mi_producto['metodo_pago'];
    $fecha_c_compra = $mi_producto['fecha_compra'];
}

include("../../templates/header.php");

?>
<?php if ($estado_carrito == "Cancelado") { ?>
    <p class="titulo_info_compra">Compra cancelada</p>
<?php } else { ?>
    <p class="titulo_info_compra">Detalles de la Compra</p>
<?php } ?>
<div class="caja_botoncancelar_detalleP">
    <a href="index.php">
        <button class="button_retroceder_infoproducto">
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
    </a>
</div>

<div class="informacion_comprita">
    <p>Total compra: $<?php echo number_format($total_compra, 0); ?></p>
    <p>Dirección: <?php echo $direccion_compra ?></p>
    <p>Costo envio: <?php echo number_format($costo_envio_compra, 0); ?></p>
    <p>Metodo de pago: <?php echo $metodo_pago_compra ?></p>
    <p>Fecha compra: <?php echo $fecha_c_compra ?></p>
</div>

<div class="container_ver_mis_comprasss">
    <?php
    if ($estado_carrito == "Completado") { ?>
        <div class="container_proceso">
            <p class="texto_productos_proceso">El estado de su compra está <?php echo $estado_carrito ?>.</p>
            <img class="img_proceso" src="../../imagen/compra_terminada-removebg-preview.png" alt="">
        </div>
    <?php
    } else { ?>
        <div class="container_proceso">
            <p class="texto_productos_proceso">El estado de su compra está <?php echo $estado_carrito ?>.</p>
            <img class="img_proceso" src="../../imagen/imagen_proceso.png" alt="">
        </div>
    <?php } ?>
    <div class="barra-estados">
        <div class="paso" id="Proceso">
            <div class="bolita"></div>
            <div class="nombre">En proceso</div>
            <div class="linea" id="Proceso"></div>
        </div>
        <div class="paso" id="Aprobado">
            <div class="bolita"></div>
            <div class="nombre">Aprobado</div>
            <div class="linea"></div>
        </div>
        <div class="paso" id="EsperaEnvio">
            <div class="bolita"></div>
            <div class="nombre">Espera de envío</div>
            <div class="linea"></div>
        </div>
        <div class="paso" id="Transito">
            <div class="bolita"></div>
            <div class="nombre">En tránsito</div>
            <div class="linea"></div>
        </div>
        <div class="paso" id="Completado">
            <div class="bolita"></div>
            <div class="nombre">Completado</div>
            <div class="linea"></div>
        </div>
    </div>
    <?php
    if ($estado_carrito == "Cancelado") { ?>
        <div class="mensaje-cancelado">
            <p>Lo sentimos, su compra ha sido cancelada.</p>
            <p>Por favor, póngase en contacto con nuestro servicio de atención al cliente para obtener más información.</p>
        </div>
        <?php
    }
    foreach ($lista_mi_compras as $mi_producto) {
        if ($estado_carrito == "Completado") { ?>
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
                </div>
            </div>
    <?php
        }
    }
    ?>

</div>

<script>
    var variableJS = <?php echo json_encode($estado_carrito); ?>;
    var Proceso = document.getElementById("Proceso");
    var Aprobado = document.getElementById("Aprobado");
    var EsperaEnvio = document.getElementById("EsperaEnvio");
    var Transito = document.getElementById("Transito");
    var Completado = document.getElementById("Completado");

    function miFuncion(variable) {
        console.log("Variable recibida en JavaScript:", variable);
        if (variable === "En proceso") {
            Proceso.classList.add("completado")
        } else if (variable === "Aprobado") {
            Proceso.classList.add("completado")
            Aprobado.classList.add("completado")
        } else if (variable === "En espera de envío") {
            Proceso.classList.add("completado")
            Aprobado.classList.add("completado")
            EsperaEnvio.classList.add("completado")
        } else if (variable === "En tránsito") {
            Proceso.classList.add("completado")
            Aprobado.classList.add("completado")
            EsperaEnvio.classList.add("completado")
            Transito.classList.add("completado")
        } else if (variable === "Completado") {
            Proceso.classList.add("completado")
            Aprobado.classList.add("completado")
            EsperaEnvio.classList.add("completado")
            Transito.classList.add("completado")
            Completado.classList.add("completado")
        }
    }

    miFuncion(variableJS);
</script>