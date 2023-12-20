<?php
session_start();

include("../../bd.php");
include("../../config.php");


if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $token = (isset($_GET['token'])) ? $_GET['token'] : "";
    $ruta = (isset($_GET['ruta'])) ? $_GET['ruta'] : "";

    $token_producto = hash_hmac('sha1', $txtID, KEY_TOKEN);

    if ($token !== $token_producto) {
        header("Location: productos_no_encontrados.php?alerta=productos_no_encontrados");
        exit;
    }
    $sentencia = $conexion->prepare("SELECT img_producto FROM `tbl_productos` WHERE id_producto=:id_producto");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    $sentencia = $conexion->prepare("SELECT p.*, t.nombre_tienda, t.logo_tienda
    FROM tbl_productos as p
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    WHERE p.id_producto=:txtID");
    $sentencia->bindParam(":txtID", $txtID);
    $sentencia->execute();
    $lista_tbl_productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $stock = $conexion->prepare("SELECT * FROM tbl_stock WHERE id_producto=:txtID");
    $stock->bindParam(":txtID", $txtID);
    $stock->execute();
    $lista_tbl_productos_stock = $stock->fetchAll(PDO::FETCH_ASSOC);

    // Resto del código
    foreach ($lista_tbl_productos as $registro) {
        $nombre = $registro['nombre'];
        $precio = $registro['precio'];
        $descripcion = $registro['descripcion'];
        $nit_identificacion = $registro['nit_identificacion'];
        $nombre_tienda = $registro['nombre_tienda'];
        $logo_tienda = $registro['logo_tienda'];
        $img_producto = $registro['img_producto'];
        $img_producto2 = $registro['img_producto2'];
        $img_producto3 = $registro['img_producto3'];
        $img_producto4 = $registro['img_producto4'];
        $img_producto5 = $registro['img_producto5'];
        $img_producto6 = $registro['img_producto6'];
        $descuento_producto = $registro['descuento_producto'];
        $especificaciones_p = $registro['especificaciones_p'];
        $precio_desc = $precio - ($precio * floatval($descuento_producto) / 100);
    }

    // Consulta para obtener la categoría del producto actual.
    $stmt = $conexion->prepare('SELECT id_sub_categoria FROM tbl_productos WHERE id_producto = :id_producto');
    $stmt->bindParam(':id_producto', $txtID, PDO::PARAM_INT);
    $stmt->execute();
    $categoria_id = $stmt->fetchColumn();

    // Consulta para obtener los productos relacionados en la misma categoría, excluyendo el producto actual.
    $stmt = $conexion->prepare('SELECT * FROM tbl_productos WHERE id_sub_categoria = :id_sub_categoria  AND id_producto != :id_producto');
    $stmt->bindParam(':id_sub_categoria', $categoria_id, PDO::PARAM_INT);
    $stmt->bindParam(':id_producto', $txtID, PDO::PARAM_INT);
    $stmt->execute();
    $productos_relacionados = $stmt->fetchAll();

    $coment = $conexion->prepare("SELECT c.*, u.*
    FROM tbl_productos as p
    INNER JOIN tbl_calificacion as c ON p.id_producto = c.id_producto
    INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
    WHERE p.id_producto = :id_producto");
    $coment->bindParam(':id_producto', $txtID, PDO::PARAM_INT);
    $coment->execute();
    $comentarios_producto = $coment->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Productos</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <p class="titulo_infoproducto">Información sobre el producto:</p>
    </header>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        if (isset($_SESSION['usuario_rol'])) {
            $usuario_rol = $_SESSION['usuario_rol'];
            if ($usuario_rol == 'Cliente') {
    ?>
                <a href="../carrito/checkout.php">
                    <div class="boton_carrito">
                        <button class="btn-cart">
                            <svg class="icon-cart" viewBox="0 0 24.38 30.52" height="30.52" width="24.38" xmlns="http://www.w3.org/2000/svg">
                                <title>icon-cart</title>
                                <path transform="translate(-3.62 -0.85)" d="M28,27.3,26.24,7.51a.75.75,0,0,0-.76-.69h-3.7a6,6,0,0,0-12,0H6.13a.76.76,0,0,0-.76.69L3.62,27.3v.07a4.29,4.29,0,0,0,4.52,4H23.48a4.29,4.29,0,0,0,4.52-4ZM15.81,2.37a4.47,4.47,0,0,1,4.46,4.45H11.35a4.47,4.47,0,0,1,4.46-4.45Zm7.67,27.48H8.13a2.79,2.79,0,0,1-3-2.45L6.83,8.34h3V11a.76.76,0,0,0,1.52,0V8.34h8.92V11a.76.76,0,0,0,1.52,0V8.34h3L26.48,27.4a2.79,2.79,0,0,1-3,2.44Zm0,0"></path>
                            </svg>
                            <span class="cantidad_productos">
                                <?php foreach ($contador as $cont)
                                    echo $cont['contador'];
                                ?>
                            </span>
                        </button>
                    </div>
                </a>
            <?php
            } else {
            ?>
    <?php
            }
        }
    }
    ?>
    <div class="caja_botoncancelar_infoproducto">
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

    <main>
        <div class="product">
            <div class="container-img">
                <img class="tamaño_imagen" id="imagenBox" src="./imagenes_producto/<?php echo $img_producto ?>" class="img-fluid rounded" alt="" onclick="openModal()" />
            </div>

            <div id="myModal" class="modal_info_producto">
                <span class="close" onclick="closeModal()">&times;</span>
                <div class="modal-content">
                    <img class="modal-image" id="modalImage" src="" alt="" />
                </div>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>

            <div class="product-small-img">
                <img src="./imagenes_producto/<?php echo $img_producto ?>" alt="" onclick="myFuction(this)">
                <img src="./imagenes_producto/<?php echo $img_producto2 ?>" alt="" onclick="myFuction(this)">
                <img src="./imagenes_producto/<?php echo $img_producto3 ?>" alt="" onclick="myFuction(this)">
                <img src="./imagenes_producto/<?php echo $img_producto4 ?>" alt="" onclick="myFuction(this)">
                <img src="./imagenes_producto/<?php echo $img_producto5 ?>" alt="" onclick="myFuction(this)">
                <img src="./imagenes_producto/<?php echo $img_producto6 ?>" alt="" onclick="myFuction(this)">
            </div>
            <div class="container_botones_pasar">
                <div class="container-revolver">
                    <a onclick="cambiarImagen(-1)">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAaVJREFUSEuNlU1qwzAQhb85RMDdpyVnKIHcotB1odcpXRd6lyaQO3jTfcF3UJElWSNrZNmbOPqZn/fmPQv+EcDNb+V7XBCcud26Nq/HTcl/9PGYbPePYBfh180npQ+d6Yqq4/poUXq+u9zZ7MG4rCG14RICRBX8seWykZmgDMU+SANERqA+Nu2h0CUrDkqi7OmazwwOXkE+ciA9fKvuc6OdlsP2AFwRHnG8C3wleDX5OqbioExgpPPBb8AR+AWegb8knpkbY9wKDlpTARwQ7jiOAqODSw6+JrEu1FSvwvcQYTnhGIEzwrRIVau90kQIvaWkA8gV3AlCcIEpQaHVa9sMUQcN7JyHxpMKSwJgKrzL0FBzTMuNxeDsJIV49GhaHOgqKtHNmz7J3U9QJPkMMuXJKR1q7SoGyebSAHID58d0BLmAi2PaS9CyyLqzQeDHwRPwBnz3HL3WgS1J7bgPDl6Az80JjDgV34O+XffqTbouHdq4tc+KOxqK9q6EVgmn5citRnpftE2ujfG1+1zpoLLrhZwktD1w2eJJ4BhD3FoyklVL5cI/KFLHIFRUyIUAAAAASUVORK5CYII=" />
                    </a>
                </div>
                <div class="container-siguiente">
                    <a onclick="cambiarImagen(1)">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAY1JREFUSEudlVFKA0EMhr/cQdj3vvQOCvU64qvgTcR3wYMUSs9Q0AOIBa8Q6cxuN9lJdlfnqcw2fyb//ycR/nMEUB9Yrux9fyHjB0FQH9cAeYTx/z7WJrv87k+THvqr4MFcPy4wYCqw/7TIOR+2gpiz+ow/nTFdQEtB8mXXCmZTZNQtRA4iZ9gB7DPwBny5mAWdHEWxowoVjwovwIfATqdJJq/0OKGLvLEEOhWOqGxAPxFuUc6BLSYaCEYDz2nAcAccgQ1wAnYC59pcOU+VomWlh8d2AnuF7ZAEfCVTQlZU0HTvjQoH9JrkDvhpzNK6aJGiodQb4EBahe0Pp0HeDCZ1BRe2aNWhUpR1+9DJ+TQoApaRIHSo7EFz/hucS6w5mdbFpsVBxaYnhN3UprFZJgmCUTKkf0B47Wm5R/gO90EDsD7BhcwnlPcyKnLKk0Zb0wezMycnelWj2RFtZ2+gabM3XYIZkfNVakdF0G3JPljHWbzR2kU0N09HX8y+tG+1QCfXB42XZ91iQS2yHxW/rDvCJ/3ZErYAAAAASUVORK5CYII=" />
                    </a>
                </div>
            </div>
        </div>
        <div class="container-info-product">
            <div class="container-price">
                <span><?php echo $nombre; ?></span>
            </div>
            <br>
            <div class="container-price">
                <?php if ($descuento_producto > 0) { ?>
                    <span><del>$<?php echo number_format($precio, 0, '.', '.'); ?></del></span>
                    <h2 style="color: #6ba745;">
                        $<?php echo number_format($precio_desc, 0, '.', '.'); ?>
                    </h2>
                <?php } else { ?>
                    <span class="span_precio_real">
                        $<?php echo number_format($precio, 0, '.', '.'); ?></del></span>
                    </span>
                <?php
                }  ?>
            </div>

            <div class="container-details-product">
                <?php if (!empty($descuento_producto)) { ?>
                    <div class="form-group">
                        <h4>Este producto tiene un <p class="decuento_p"><?php echo $descuento_producto; ?>$</p> descuento</h4>
                    </div>
                <?php
                } ?>
                <div class="form-group">
                    <div class="form-group" id="cantidadUnidades">
                        <!-- La cantidad de unidades se mostrará aquí -->
                        <p>Selecciona un color:</p>
                    </div>
                </div>
            </div>

            <form action="../carrito/añadir_carrito.php" method="post" id="formColores" onsubmit="return validarFormulario()">
                <div class="boton_colores">
                    <?php foreach ($lista_tbl_productos_stock as $registro) {
                        if ($registro['cantidad_disponible'] > 0) { ?>
                            <input type="radio" id="color_<?php echo $registro['color_producto'] ?>" name="id_stock" value="<?php echo $registro['id_stock'] ?>" class="colorOption">
                            <label for="color_<?php echo $registro['color_producto'] ?>" class="label_color">
                                <span class="color-option" style="background-color: <?php echo $registro['color_producto'] ?>;"></span>
                            </label>
                            <input type="text" name="id_producto" hidden value="<?php echo $registro['id_producto']; ?>">
                    <?php }
                    } ?>

                </div>

                <div class="container-add-cart">
                    <?php
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        if (isset($_SESSION['usuario_rol'])) {
                            $usuario_rol = $_SESSION['usuario_rol'];
                            if ($usuario_rol == 'Cliente') {
                    ?>
                                <button class="button" type="submit">
                                    Añadir al carrito
                                    <svg class="cart" fill="white" viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                                    </svg>
                                </button>
                            <?php
                            } else {
                            ?>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </form>

            <div class="container-description">
                <div class="title-description">
                    <h4>Detalle del producto</h4>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="text-description">
                    <p><strong class="color_strong">Descripción: </strong><?php echo $descripcion; ?></p>
                </div>
            </div>

            <div class="container-additional-information">
                <div class="title-additional-information">
                    <h4>Información sobre la tienda </h4>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="text-additional-information hidden">
                    <div class="info_tienda">
                        <a href="../tiendas/mas_tienda.php?txtID=<?php echo $nit_identificacion ?>&ruta=../productos/index.php">
                            <p><?php echo $nombre_tienda; ?></p>
                            <img class="imagen_tiendaa" src="../tiendas/imagenes_tienda/<?php echo $logo_tienda; ?>" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php if (!empty($productos_relacionados)) { ?>
        <button type="button" id="mostrarProductos" class="ver_productosR">
            Ver productos relacionados
        </button>
    <?php } ?>

    <div id="productosRelacionados" style="display: none;">
        <?php if (empty($productos_relacionados)) : ?>
            <p class="no_hay_relacionados">No hay productos relacionados disponibles.</p>
        <?php else : ?>
            <div class="Carousel">
                <div class="slick-list" id="slick-list">
                    <button class="slick-arrow slick-prev" id="button-prev" data-button="button-prev" onclick="app.processingButton(event)">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
                        </svg>
                    </button>
                    <div class="slick-track" id="track">
                        <?php foreach ($productos_relacionados as $producto) {
                            if ($producto['estado_producto'] == "Activo") { ?>
                                <div class="slick">
                                    <div>
                                        <a href="info_producto.php?txtID=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>&ruta=index.php">
                                            <h4>
                                                <small>
                                                    <?php echo $producto['nombre']; ?>
                                                </small>
                                            </h4>
                                            <picture>
                                                <img class="tamaño_imagen_carrusel" src="imagenes_producto/<?php echo $producto['img_producto']; ?>" alt="" />
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
        <?php endif; ?>
    </div>

    <?php if (!empty($comentarios_producto)) { ?>
        <div class="comentarios">
            <p class="titulo_comentario">Reseñas sobre este producto:</p>
            <?php foreach ($comentarios_producto as $comen) { ?>
                <div class="comentario">
                    <div class="usuario">
                        <?php if (!empty($comen['fotoPerfil'])) { ?>
                            <img src="../miperfil/imagenes_producto/<?php echo $comen['fotoPerfil'] ?>" class="foto-perfil">
                        <?php } else { ?>
                            <img src="../../imagen/Avatar-No-Background.png" class="foto-perfil">
                        <?php } ?>
                        <div class="info-usuario">
                            <div class="nombre"><?php echo $comen['usuario'] ?></div>
                        </div>
                    </div>
                    <div class="texto">
                        <p><?php echo $comen['texto'] ?></p>
                    </div>

                    <?php
                    for ($i = 0; $i < 5; $i++) {
                        if ($comen['calificacion'] > $i) {
                            echo '<span class="star filled">&#9733;</span>'; // Estrella llena
                        } else {
                            echo '<span class="star">&#9733;</span>'; // Estrella vacía
                        }
                    } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <script>
        var imagenActual = 0; // Índice de la imagen actual

        function myFunction(element) {
            var imagenSeleccionada = element.src;
            document.getElementById("imagenBox").src = imagenSeleccionada;
            // También puedes agregar lógica para actualizar la variable imagenActual si es necesario
        }

        function cambiarImagen(delta) {
            var imagenes = [
                "./imagenes_producto/<?php echo $img_producto ?>",
                "./imagenes_producto/<?php echo $img_producto2 ?>",
                "./imagenes_producto/<?php echo $img_producto3 ?>",
                "./imagenes_producto/<?php echo $img_producto4 ?>",
                "./imagenes_producto/<?php echo $img_producto5 ?>",
                "./imagenes_producto/<?php echo $img_producto6 ?>",
            ];

            imagenActual += delta;

            // Manejo de límites
            if (imagenActual < 0) {
                imagenActual = imagenes.length - 1;
            } else if (imagenActual >= imagenes.length) {
                imagenActual = 0;
            }

            document.getElementById("imagenBox").src = imagenes[imagenActual];
        }
    </script>


    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <script src="archivos.js/informacion.js"></script>
    <script src="archivos.js/mostrar_boton.js"></script>
    <script src="../../js/imagen.js"></script>
    <script src="../../js/index.js"></script>
    <script src="archivos.js/informacion.js"></script>
    <script src="archivos.js/zoom_img.js"></script>
    <script src="archivos.js/redireccionarboton.js"></script>
    <script src="archivos.js/redireccionarboton_crear.js"></script>
    <script src="../../js/carrusel_productos.js"></script>
    <script src="../../js/jquery-3.7.1.min.js"></script>
    <script src="archivos.js/validar_formulario.js"></script>
    <script src="archivos.js/modal_recomendacion.js"></script>
    <script>
        $(document).ready(function() {
            $('.colorOption').change(function() {
                var id_stock = $(this).val();
                var id_producto = $(this).siblings('[name="id_producto"]').val();

                $.ajax({
                    url: 'obtener_cantidad.php',
                    type: 'POST',
                    data: {
                        id_stock: id_stock,
                        id_producto: id_producto
                    },
                    success: function(response) {
                        $('#cantidadUnidades').html('Cantidad del color: ' + response);
                    }
                });
            });
        });
    </script>
    <?php if (isset($_GET['mensaje'])) { ?>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '<?php echo $_GET['mensaje']; ?>'
            })
        </script>
    <?php } ?>

</body>

</html>