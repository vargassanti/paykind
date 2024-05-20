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

if (isset($_GET['compra'])) {
    $compra = $_GET['compra'];
} else {
    header("Location: ../../index.php");
    exit();
}

include("../../templates/header.php");
?>

<div class="container_ver_factura">
    <h4 class="titulo_carrito">Factura</h4>
    <p> Ya completaste el proceso de tu compra, puedes descargar en pdf tu factura, o puedes regresar al inicio.</p>
    <div class="ver_factura2">
        <a href="descargar_factura.php?id_compra=<?php echo $compra; ?>">
            <button class="button_factura">
                <span class="button_lg">
                    <span class="button_sl"></span>
                    <span class="button_text">Descargar factura</span>
                </span>
            </button>
        </a>

        <a href="../../index.php?alerta=compra_realizada">
            <button class="button_factura">
                <span class="button_lg">
                    <span class="button_sl"></span>
                    <span class="button_text">Volver al inicio</span>
                </span>
            </button>
        </a>
    </div>
</div>
