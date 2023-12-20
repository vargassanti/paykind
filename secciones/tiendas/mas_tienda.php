<?php

session_start();

include("../../bd.php");

if (!isset($_GET['txtID'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];
    $ruta = (isset($_GET['ruta'])) ? $_GET['ruta'] : "";

    $nit_t = $conexion->prepare("SELECT nit_identificacion FROM `tbl_tienda` WHERE nit_identificacion = :nit_identificacion");
    $nit_t->bindParam(":nit_identificacion", $txtID);
    $nit_t->execute();

    $encontrado = false;

    foreach ($nit_t as $nitt) {
        $nit_identificacion = $nitt['nit_identificacion'];

        if ($txtID == $nit_identificacion) {
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        header("Location: tienda_no_encontrada.php?alerta=tiendas_no_encontradas");
        exit();
    }

    $tiendas = $conexion->prepare("SELECT * FROM `tbl_tienda` WHERE nit_identificacion = :nit_identificacion");
    $tiendas->bindParam(":nit_identificacion", $txtID);
    $tiendas->execute();

    $productos_total = $conexion->prepare("SELECT COUNT(*) FROM tbl_productos WHERE nit_identificacion = :nit_identificacion");
    $productos_total->bindParam(":nit_identificacion", $txtID);
    $productos_total->execute();
    $total_productos = $productos_total->fetchColumn();

    include("../../templates/header.php");

    // Verificar si la consulta de tiendas se ejecutó correctamente y si hay resultados
    if ($tiendas !== false && $tiendas->rowCount() > 0) {
?>

        <div class="caja_botoncancelar_mitienda">
            <a href="<?php echo $ruta ?>">
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
        <div class="container_mas_tienda">
            <?php
            foreach ($tiendas as $registro) {
            ?>
                <p class="nombre_mas_tienda"><?php echo $registro['nombre_tienda'] ?></p>
                <img class="imagen_mas_tienda" src="./imagenes_tienda/<?php echo $registro['logo_tienda']; ?>" />
                <p class="descripcion_mas_tienda"><?php echo $registro['descripcion'] ?></p>
                <?php
                if ($total_productos > 0) { ?>
                    <p class="cantidad_productos">Cantidad productos: <?php echo $total_productos ?></p>
                <?php
                }
                ?>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    if (isset($_SESSION['usuario_id'])) {
                        $usuario_id = $_SESSION['usuario_id'];
                        $id_propietario = $registro['id_usuario'];

                        if ($usuario_id == $id_propietario) {
                ?>
                            <div class="btnes">
                                <a href="editar.php?tienda=<?php echo $registro['nit_identificacion']; ?>">
                                    <button class="button_editar">
                                        Editar
                                        <div class="arrow-wrapper">
                                            <div class="arrow"></div>
                                        </div>
                                    </button>
                                </a>
                                <a href="javascript:borrar(<?php echo $registro['nit_identificacion']; ?>);">
                                    <button class="button_eliminar">
                                        Eliminar
                                        <div class="arrow-wrapper">
                                            <div class="arrow"></div>
                                        </div>
                                    </button>
                                </a>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            <?php
            }
            ?>
        </div>
    <?php
    } else {
        // Manejar el caso en el que no se encontraron tiendas
    ?>
        <div class="no_hay_tiendas">
            <?php
            echo "No hay tiendas asociadas a esta consulta.";
            ?>
        </div>
    <?php
    }

    // Consultar los productos de la tienda especificada por 'nit_identificacion'
    $productos = $conexion->prepare("SELECT * FROM tbl_productos WHERE nit_identificacion = :nit_identificacion");
    $productos->bindParam(":nit_identificacion", $txtID);
    $productos->execute();

    // Verificar si la consulta de productos se ejecutó correctamente y si hay resultados
    if ($productos !== false && $productos->rowCount() > 0) {
    ?>
        <div class="container_posicion_productos">
            <?php
            // Iterar sobre los resultados y mostrar la información de los productos
            while ($registro = $productos->fetch(PDO::FETCH_ASSOC)) {
                $precio_desc = $registro['precio'] - ($registro['precio'] * floatval($registro['descuento_producto']) / 100);
                if ($registro['estado_producto'] == "Activo") {
            ?>
                    <a href="../productos/info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=../tiendas/mas_tienda.php?txtID=<?php echo $txtID ?>">
                        <div class="caja_productos">
                            <img class="imagenn" src="../productos/imagenes_producto/<?php echo $registro['img_producto']; ?>" class="img-fluid rounded" alt="" />
                            <?php if ($registro['descuento_producto'] > 0) { ?>
                                <p class="parrafos"><strong> $<?php echo number_format($precio_desc, 0, '.', '.'); ?></strong></p>
                            <?php } else { ?>
                                <p class="parrafos"><strong> $<?php echo number_format($registro['precio'], 0, '.', '.'); ?></strong></p>
                            <?php
                            }  ?>
                            <hr>
                            <p class="text_nombre_p">
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
                            <a href="../productos/info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=../tiendas/mas_tienda.php?txtID=<?php echo $txtID ?>">
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
            }
            ?>
        </div>
        <button class="boton_volver_arriba_p" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
            <i class='bx bx-up-arrow-alt'></i>
        </button> <?php
                } else {
                    // Manejar el caso en el que no se encontraron productos
                    ?>
        <div class="no_hay_productos">
            <?php
                    echo "No hay ningún producto subido por esta tienda";
            ?>
        </div>
<?php
                }
            }
?>
<script>
    // JavaScript para scroll suave hacia arriba
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
<script src="archivos.js/borrar.js"></script>