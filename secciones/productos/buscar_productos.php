<?php
session_start();

include("../../bd.php");
require '../../config.php';

// Variable para almacenar el término de búsqueda (inicialmente vacío)
$termino_busqueda = '';

// Verifica si se envió una búsqueda
if (isset($_GET['q'])) {
    $termino_busqueda = $_GET['q'];
}

// Consulta SQL para buscar productos
$consulta = "SELECT p.*, t.* 
FROM tbl_productos as p 
INNER JOIN tbl_tienda as t ON p.nit_identificacion = t.nit_identificacion
WHERE p.nombre LIKE :termino OR t.nombre_tienda LIKE :termino";
$stmt = $conexion->prepare($consulta);
$termino_busqueda = "%$termino_busqueda%";
$stmt->bindParam(':termino', $termino_busqueda, PDO::PARAM_STR);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);


include("../../templates/header.php");
?>

<br>
<?php
if (isset($_GET['partial'])) { ?>
    <div id="resultados-en-tiempo-real">
        <?php if (isset($resultados) && count($resultados) > 0) : ?>
            <h2>Resultados de la búsqueda:</h2>
            <?php
            $conteo_productos = array();

            foreach ($resultados as $registro) {
                $nombre_tienda = $registro['nombre_tienda'];
                $logo_tienda = $registro['logo_tienda'];
                $nit_identificacion = $registro['nit_identificacion']; // Suponiendo que este es el campo para el NIT o identificación

                if (!array_key_exists($nombre_tienda, $conteo_productos)) {
                    $conteo_productos[$nombre_tienda] = [
                        'cantidad_productos' => 0,
                        'logo' => $logo_tienda, // Almacena el logo correspondiente a la tienda
                        'nit_identificacion' => $nit_identificacion // Almacena el NIT/identificación
                    ];
                }

                $conteo_productos[$nombre_tienda]['cantidad_productos']++;
            }
            ?>
            <div class="container-tiendaaas">
                <?php
                foreach ($conteo_productos as $nombre_tienda => $info_tienda) {
                ?>
                    <a href="../tiendas/mas_tienda.php?txtID=<?php echo $info_tienda['nit_identificacion']; ?>&ruta=../productos/buscar_productos.php">
                        <div class="container_tienda_busqueda">
                            <img src="../tiendas/imagenes_tienda/<?php echo $info_tienda['logo']; ?>" alt="">
                            <p class="titulo"><?php echo $nombre_tienda; ?></p>
                            <p>Número de productos encontrados: <?php echo $info_tienda['cantidad_productos']; ?></p>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
            <div class="container_producticos_buscar">
                <?php foreach ($resultados as $registro) :
                    $precio_desc = $registro['precio'] - ($registro['precio'] * floatval($registro['descuento_producto']) / 100);
                    if ($registro['estado_producto'] == "Activo") {
                ?>
                        <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=../productos/buscar_productos.php">
                            <div class="caja2">
                                <img class="imagenn" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" class="img-fluid rounded" alt="" />
                                <div class="container_parrafos">
                                    <p class="parrafos3">
                                        <?php if ($registro['descuento_producto'] > 0) { ?>
                                            <span><del>$<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
                                            <hr>
                                    <p class="precio_descuento3">
                                        $<?php echo number_format($precio_desc, 0, '.', '.'); ?>
                                    </p>
                                    </p>
                                <?php } else { ?>
                                    <span style="font-size: 16xpx;">
                                        $<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
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
                                </div>
                                <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=../productos/buscar_productos.php">
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
                <?php }
                endforeach; ?>
            </div>
        <?php else : ?>
            <p>No se encontraron resultados.</p>
        <?php endif; ?>
    </div>
<?php
    exit();
} else { ?>
    <form action="" method="GET">
        <div class="container_boton_buscar">
            <div class="input-wrapper">
                <button class="icon" type="submit"> <!-- Añade el tipo "submit" al botón -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="25px" width="25px">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#fff" d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z"></path>
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#fff" d="M22 22L20 20"></path>
                    </svg>
                </button>
                <input placeholder="Buscar.." class="input" id="search_input" name="q" type="text">
            </div>
        </div>
    </form>

    <div class="container_busqueda" id="resultados-en-tiempo-real">
        <?php if (isset($resultados) && count($resultados) > 0) : ?>
            <h2 class="titulito_tienda">Tiendas:</h2>
            <div class="container-tiendaaas2">
                <?php
                foreach ($lista_tbl_tiendas as $registro) {
                ?>
                    <a href="../tiendas/mas_tienda.php?txtID=<?php echo $registro['nit_identificacion']; ?>&ruta=../productos/buscar_productos.php">
                        <div class="container_tienda_busqueda2">
                            <img src="../tiendas/imagenes_tienda/<?php echo $registro['logo_tienda']; ?>" alt="">
                            <p class="titulo2"><?php echo $registro['nombre_tienda']; ?></p>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
            <h2 class="titulito_productos">Productos:</h2>
            <div class="container_producticos_buscar">
                <?php foreach ($resultados as $registro) :
                    $precio_desc = $registro['precio'] - ($registro['precio'] * floatval($registro['descuento_producto']) / 100);
                    if ($registro['estado_producto'] == "Activo") {
                ?>
                    <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=../productos/buscar_productos.php">
                        <div class="caja2">
                            <img class="imagenn" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" class="img-fluid rounded" alt="" />
                            <div class="container_parrafos">
                                <p class="parrafos3">
                                    <?php if ($registro['descuento_producto'] > 0) { ?>
                                        <span><del>$<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
                                        <hr>
                                <p class="precio_descuento3">
                                    $<?php echo number_format($precio_desc, 0, '.', '.'); ?>
                                </p>
                                </p>
                            <?php } else { ?>
                                <span style="font-size: 16xpx;">
                                    $<?php echo number_format($registro['precio'], 2, '.', '.'); ?></del></span>
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
                            </div>
                            <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=../productos/buscar_productos.php">
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
                <?php } 
            endforeach; ?>
            </div>
        <?php else : ?>
            <p>No se encontraron resultados.</p>
        <?php endif; ?>
    </div>
<?php
}
?>
<button class="boton_volver_arriba_p" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
    <i class='bx bx-up-arrow-alt'></i>
</button>
<script>
    // JavaScript para scroll suave hacia arriba
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<script src="archivos.js/busqueda.js"></script>
<script src="../../js/sololetras.js"></script>

<style>
    .imagen_logo {
        position: sticky;
        top: 580px;
        /* Ajusta la distancia desde el borde superior según tu preferencia */
        left: 1600px;
        z-index: 100;
        width: 155px;
        background-color: transparent;
        margin-bottom: -168px;
    }

    .imagen_logo img {
        height: 140px;
    }

    .container_busqueda {
        margin: 30px;
        width: 80%;
        position: relative;
        left: 170px;
    }

    .input-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        position: relative;
        left: 20px;
        top: -10px;
    }

    .input {
        border-style: none;
        height: 50px;
        width: 50px;
        padding: 10px;
        outline: none;
        border-radius: 50%;
        transition: .5s ease-in-out;
        box-shadow: 0px 0px 3px #f3f3f3;
        padding-right: 40px;
        color: #258555;
        background-color: transparent;
    }

    .input::placeholder,
    .input {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 17px;
    }

    .input::placeholder {
        color: #8f8f8f;
    }

    .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        right: 0px;
        cursor: pointer;
        width: 50px;
        height: 50px;
        outline: none;
        border-style: none;
        border-radius: 50%;
        pointer-events: painted;
        background-color: #258555;
        transition: .2s linear;
    }

    .icon:focus~.input,
    .input:focus {
        box-shadow: none;
        width: 250px;
        border-radius: 0px;
        border-bottom: 2px solid #050308;
        border-top: transparent;
        border-left: transparent;
        border-right: transparent;
        transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
        color: #000000;
    }
</style>
<style>
    .Btn {
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 50%;
        background-color: rgb(255 255 255);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition-duration: .3s;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.11);
    }

    .Btn:hover {
        background-color: #f27474;
        transition-duration: .3s;
    }

    @keyframes slide-in-top {
        0% {
            transform: translateY(-10px);
            opacity: 0;
        }

        100% {
            transform: translateY(0px);
            opacity: 1;
        }
    }

    .btnes {
        display: flex;
        justify-content: space-between;
        width: 235px;
        position: static;
        top: 10px;
    }


    /* ESTILOS DEL BOTON EDITAR */
    .button_editar {
        --primary-color: #258555;
        --secondary-color: #fff;
        --hover-color: #111;
        --arrow-width: 10px;
        --arrow-stroke: 2px;
        box-sizing: border-box;
        border: 0;
        border-radius: 20px;
        color: var(--secondary-color);
        padding: 11px 15px;
        background: var(--primary-color);
        display: flex;
        transition: 0.2s background;
        align-items: center;
        gap: 0.6em;
        font-weight: bold;
    }

    .button_editar .arrow-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .button_editar .arrow {
        margin-top: 1px;
        width: var(--arrow-width);
        background: var(--primary-color);
        height: var(--arrow-stroke);
        position: relative;
        transition: 0.2s;
    }

    .button_editar .arrow::before {
        content: "";
        box-sizing: border-box;
        position: absolute;
        border: solid var(--secondary-color);
        border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
        display: inline-block;
        top: -3px;
        right: 3px;
        transition: 0.2s;
        padding: 3px;
        transform: rotate(-45deg);
    }

    .button_editar:hover {
        background-color: var(--hover-color);
    }

    .button_editar:hover .arrow {
        background: var(--secondary-color);
    }

    .button_editar:hover .arrow:before {
        right: 0;
    }

    /* ESTILOS DEL BOTON ELIMINAR */
    .button_eliminar {
        --primary-color: #a10000;
        --secondary-color: #fff;
        --hover-color: #111;
        --arrow-width: 10px;
        --arrow-stroke: 2px;
        box-sizing: border-box;
        border: 0;
        border-radius: 20px;
        color: var(--secondary-color);
        padding: 11px 20px;
        background: var(--primary-color);
        display: flex;
        transition: 0.2s background;
        align-items: center;
        gap: 0.6em;
        font-weight: bold;
    }

    .button_eliminar .arrow-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .button_eliminar .arrow {
        margin-top: 1px;
        width: var(--arrow-width);
        background: var(--primary-color);
        height: var(--arrow-stroke);
        position: relative;
        transition: 0.2s;
    }

    .button_eliminar .arrow::before {
        content: "";
        box-sizing: border-box;
        position: absolute;
        border: solid var(--secondary-color);
        border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
        display: inline-block;
        top: -3px;
        right: 3px;
        transition: 0.2s;
        padding: 3px;
        transform: rotate(-45deg);
    }

    .button_eliminar:hover {
        background-color: var(--hover-color);
    }

    .button_eliminar:hover .arrow {
        background: var(--secondary-color);
    }

    .button_eliminar:hover .arrow:before {
        right: 0;
    }
</style>