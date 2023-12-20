<?php
session_start();

include("../../bd.php");
include("../../config.php");

$sentencia = $conexion->prepare("SELECT * FROM `tbl_productos` ORDER BY RAND()");
$sentencia->execute();
$lista_tbl_productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_tbl_productos as $registro) {
    $nombre = $registro['nombre'];
    $precio = $registro['precio'];
    $descripcion = $registro['descripcion'];
    $descuento = $registro['descuento_producto'];
    $img_producto = $registro['img_producto'];
    $img_producto2 = $registro['img_producto2'];
    $img_producto3 = $registro['img_producto3'];
    $img_producto4 = $registro['img_producto4'];
    $img_producto5 = $registro['img_producto5'];
    $img_producto6 = $registro['img_producto6'];
    $precio_desc = $precio - ($precio * floatval($descuento) / 100);
}

include("../../templates/header.php");

?>

<div class="container_no_encontrados">
    <div class="no_info">
        <h2>¡lo sentimos! </h2>
        <p>No encontramos lo que buscabas, pero aquí te damos una mano:</p>
    </div>
    <div class="imagen_error">
        <img src="../../imagen/no_encontrado.png" alt="">
    </div>
</div>

<p class="titulo_otros_c">Productos encontrados</p>

<div class="Carousel_no_encontrados">
    <div class="slick-list" id="slick-list">
        <button class="slick-arrow slick-prev" id="button-prev" data-button="button-prev" onclick="app.processingButton(event)">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
            </svg>
        </button>
        <div class="slick-track" id="track">
            <?php foreach ($lista_tbl_productos as $registro) { ?>
                <div class="slick">
                    <div>
                        <a href="info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=productos_no_encontrados.php">
                            <h4>
                                <small>
                                    <?php echo $registro['nombre']; ?>
                                </small>
                            </h4>
                            <picture>
                                <img class="tamaño_imagen_carrusel" src="imagenes_producto/<?php echo $registro['img_producto']; ?>" alt="" />
                            </picture>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="slick-arrow slick-next" id="button-next" data-button="button-next" onclick="app.processingButton(event)">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
            </svg>
        </button>
    </div>
</div>


<script src="archivos.js/carrusel_productos.js"></script>

<script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "productos_no_encontrados") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'El producto no es existente o no fue encontrado.'
      })
    }
    history.replaceState({}, document.title, window.location.pathname);
  </script>