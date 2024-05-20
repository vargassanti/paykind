<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_GET['id'], $_GET['ruta'])) {
    $sub_categoria_id = $_GET['id'];
    $ruta = $_GET['ruta'];

    $subcategoria_query = $conexion->prepare("SELECT * FROM tbl_productos WHERE id_sub_categoria=:id_sub_categoria AND estado_producto = 'Activo'");
    $subcategoria_query->bindParam(":id_sub_categoria", $sub_categoria_id);
    $subcategoria_query->execute();
    $registro_recuperado = $subcategoria_query->fetchAll(PDO::FETCH_ASSOC);

    if (isset($registro_recuperado["img_producto"]) && $registro_recuperado["img_producto"] != "") {
        if (file_exists("./imagenes_producto/" . $registro_recuperado["img_producto"])) {
            unlink("./imagenes_producto/" . $registro_recuperado["img_producto"]);
        }
    }

    $nombre_sub_categoria = $conexion->prepare("SELECT * FROM tbl_sub_categorias WHERE id_sub_categoria=:id_sub_categoria");
    $nombre_sub_categoria->bindParam(":id_sub_categoria", $sub_categoria_id);
    $nombre_sub_categoria->execute();
    $nombreee = $nombre_sub_categoria->fetchAll(PDO::FETCH_ASSOC);
}

?>
<?php include("../../templates/header.php"); ?>

<div class="caja_botoncancelar">
    <a href="<?php echo $ruta ?>">
        <button class="button_retrocederrr">
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

<div class="titulo_producto">
    <h4>
        <?php
        foreach ($nombreee as $sub_categoria) {
            echo $sub_categoria['nombre_sub_categoria'];
        }
        ?>
    </h4>
</div>

<div class="container_sub_categorias">
    <?php
    if (empty($registro_recuperado)) {
        echo "<p>No hay productos disponibles en esta subcategoría.</p>";
    } else {
        foreach ($registro_recuperado as $producto) {
            if ($producto['estado_producto'] == "Activo") { ?>
                <a href="../productos/info_producto.php?txtID=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>&ruta=../categorias/categorias_sub.php">
                    <div class="caja2">
                        <img class="imagenn" src="../productos/imagenes_producto/<?php echo $producto['img_producto']; ?>" class="img-fluid rounded" alt="" />
                        <div class="container_parrafos">
                            <p class="parrafos3">
                                <?php if ($producto['descuento_producto'] > 0) { ?>
                                    <span><del>$<?php echo number_format($producto['precio'], 2, '.', '.'); ?></del></span>
                                    <hr>
                            <p class="precio_descuento3">
                                En oferta
                            </p>
                            </p>
                        <?php } else { ?>
                            <span style="font-size: 16xpx;">
                                $<?php echo number_format($producto['precio'], 2, '.', '.'); ?></del></span>
                            </span>
                            <hr>
                            <p class="precio_descuento2">
                                En oferta
                            </p>
                        <?php
                                }  ?>
                        </p>
                        <p>
                            <?php
                            $contenido = $producto['nombre'];
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
                        <a href="../productos/info_producto.php?txtID=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>&ruta=../categorias/categorias_sub.php">
                            <button class="CartBtn">
                                <span class="IconContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart">
                                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c-2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                                    </svg>
                                </span>
                                <p class="text">Ver más</p>
                            </button>
                        </a>
                        <?php if ($producto['descuento_producto'] > 0) { ?>
                            <button class="Boton_oferta">
                                <p><?php echo $producto['descuento_producto']; ?>%</p>
                            </button>
                        <?php } ?>
                    </div>
                </a>
    <?php
            }
        }
    }
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtén una referencia al botón
        const redireccionarButton = document.getElementById('redireccionarButton');

        // Agrega un evento de clic al botón
        redireccionarButton.addEventListener('click', () => {
            // Especifica la URL de destino a la que deseas redirigir
            const urlDestino = 'crear.php'; // Reemplaza con tu URL de destino

            // Redirige el navegador a la URL de destino
            window.location.href = urlDestino;
        });
    });
</script>
<script>
    function borrar(id) {
        Swal.fire({
            title: '¿Desea borrar el registro?',
            showCancelButton: true,
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?txtID=" + id;
            }
        })
    }
</script>