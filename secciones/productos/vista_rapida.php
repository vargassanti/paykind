<?php
session_start();
include("../../bd.php");
require '../../config.php';

// Inicializa $registro como un array vacío
$registro = [];

if (isset($_GET['id_producto'])) {
    $id_producto = (isset($_GET['id_producto'])) ? $_GET['id_producto'] : "";

    //Buscar el archivo relacionado con el empleado
    $sentencia = $conexion->prepare("SELECT img_producto FROM `tbl_productos` WHERE id_producto=:id_producto");
    $sentencia->bindParam(":id_producto", $id_producto);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
}

$sentencia = $conexion->prepare("SELECT p.*, s.* FROM tbl_productos as p
INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
WHERE p.id_producto=:id_producto");
$sentencia->bindParam(":id_producto", $id_producto);
$sentencia->execute();
$lista_tbl_productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);


foreach ($lista_tbl_productos as $registro) {
    $nombre = $registro['nombre'];
    $precio = $registro['precio'];
    $descripcion = $registro['descripcion'];
    $descuento = $registro['descuento_producto'];
    // $cantidad_unidades = $registro['cantidad_unidades'];
    $img_producto = $registro['img_producto'];
    $img_producto2 = $registro['img_producto2'];
    $img_producto3 = $registro['img_producto3'];
    $img_producto4 = $registro['img_producto4'];
    $img_producto5 = $registro['img_producto5'];
    $img_producto6 = $registro['img_producto6'];
    $precio_desc = $precio - ($precio * floatval($descuento) / 100);
}
?>

<div class="container_info_producto">
    <div class="caja_informacion">
        <p><strong><?php echo $nombre; ?></p></strong>
        <br>
        <?php if ($descuento > 0) { ?>
            <span><del>$<?php echo number_format($precio, 2, '.', '.'); ?></del></span>
            <h3 style="color: #258555;">
                $<?php echo number_format($precio_desc, 2, '.', '.'); ?>
            </h3>
        <?php } else { ?>
            <span style="font-size: 20px;">
                $<?php echo number_format($precio, 2, '.', '.'); ?></del></span>
            </span>
        <?php
        }  ?>
        <br>
        <div id="texto-limite">
            <p><?php echo $descripcion; ?></p>
        </div>
        <br><br>
        <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=index.php">
            <button class="mas_informacion_P">
                Ver mas información
            </button>
        </a>
    </div>

    <div class="Carousel">
        <div class="slick-list" id="slick-list">
            <button class="slick-arrow slick-prev" id="button-prev" data-button="button-prev" onclick="app.processingButton(event)">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
                </svg>
            </button>
            <div class="slick-track" id="track">
                <div class="slick">
                    <div>
                        <picture>
                            <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" />
                        </picture>
                    </div>
                </div>
                <div class="slick">
                    <div>
                        <picture>
                            <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto2']; ?>" />
                        </picture>
                    </div>
                </div>
                <div class="slick">
                    <div>
                        <picture>
                            <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto3']; ?>" />
                        </picture>
                    </div>
                </div>
                <div class="slick">
                    <div>
                        <picture>
                            <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto4']; ?>" />
                        </picture>
                    </div>
                </div>
                <div class="slick">
                    <div>
                        <picture>
                            <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto5']; ?>" />
                        </picture>
                    </div>
                </div>
                <div class="slick">
                    <div>
                        <picture>
                            <img class="tamaño_imagen_carrusel" src="./imagenes_producto/<?php echo $registro['img_producto6']; ?>" />
                        </picture>
                    </div>
                </div>
            </div>
            <button class="slick-arrow slick-next" id="button-next" data-button="button-next" onclick="app.processingButton(event)">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
                </svg>
            </button>
        </div>
    </div>

    <script src="archivos.js/carrusel_productos.js"></script>

    <style>
        .Carousel {
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            width: 41%;
            align-items: center;
            position: absolute;
            left: -7px;
            top: 1px;
        }

        .Carousel h2 {
            font-size: 26px;
            line-height: 38px;
            padding-bottom: 24px;
            opacity: .9;
            letter-spacing: 10px;
            text-align: center;
        }

        /* images */

        .slick-list {
            position: relative;
            display: flex;
            align-items: center;
            width: fit-content;
            height: 304px;
            padding: 10px 0px;
            margin: 0px auto;
            max-width: 90vw;
            overflow: hidden;
        }

        .slick-track {
            position: relative;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            transition: .5s ease-in-out;
        }

        .slick {
            position: relative;
            width: 275px;
            padding: 0 18px;
            float: left;
            box-sizing: border-box;
            display: flex;
            height: 100%;
        }

        .slick h4 {
            position: absolute;
            z-index: 1;
            font-size: 22px;
            line-height: 23px;
            color: #fff;
            padding: 15px;
        }

        .slick h4 small {
            font-size: 15px;
            display: block;
        }

        .slick a img {
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .5);
            transition: .3s ease-in-out;
        }

        .slick .tamaño_imagen_carrusel {
            width: 250px;
            height: 275px;
            overflow: hidden;
        }

        .slick a img:hover {
            opacity: .85;
        }

        /* buttons */

        .slick-arrow {
            border-radius: 30px;
            background-color: #fff;
            position: absolute;
            z-index: 4;
            width: 45px;
            height: 45px;
            text-align: center;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .15);
            border: 0;
            cursor: pointer;
            text-decoration: none;
        }

        .slick-arrow:focus {
            outline: 0;
        }

        .slick-arrow svg {
            width: 12px;
            height: 100%;
            color: rgba(0, 0, 0, .7);
        }

        .slick-prev {
            left: 0px;
        }

        .slick-next {
            right: 0px;
        }

        #texto-limite p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 300px;
            /* Establece el ancho máximo en el que deseas que se aplique el efecto de puntos suspensivos */
        }

        a {
            text-decoration: none;
        }

        .mas_informacion_P {
            font-size: 15px;
            color: #000000;
            font-family: inherit;
            font-weight: 800;
            cursor: pointer;
            position: relative;
            border: none;
            text-transform: uppercase;
            background: none;
            transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
            transition-duration: 400ms;
            transition-property: color;
        }

        .mas_informacion_P:focus,
        .mas_informacion_P:hover {
            color: #258555;
        }

        .mas_informacion_P:focus:after,
        .mas_informacion_P:hover:after {
            width: 100%;
            left: 0%;
        }

        .mas_informacion_P:after {
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

        .container_info_producto {
            width: 700px;
            height: 300px;
            position: relative;
            left: 10px;
            top: 10px;
            border-radius: 1px;
        }

        .container_info_producto .imagenn {
            width: 250px;
            height: 250px;
            position: absolute;
            top: 24px;
            left: 40px;
        }

        .caja_informacion {
            position: relative;
            left: 300px;
            width: 350px;
            padding: 20px;
            text-align: center;
        }

        .caja_informacion p {
            font-size: 15px;
        }

        @media screen and (min-width: 1900px) {
            .Carousel {
                font-family: Arial, Helvetica, sans-serif;
                display: flex;
                width: 41%;
                align-items: center;
                position: absolute;
                left: -7px;
                top: 34px;
            }

            .slick .tamaño_imagen_carrusel {
                width: 256px;
                height: 275px;
                overflow: hidden;
            }

            .caja_informacion {
                position: relative;
                left: 300px;
                top: 35px;
                width: 350px;
                padding: 20px;
                text-align: center;
            }
        }
    </style>