<?php
session_start();

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

$id_usuario = $_SESSION['usuario_id'];

include("../../bd.php");
require '../../config.php';

$productos_c = $conexion->prepare("SELECT p.id_producto, p.nombre, p.precio, d.cantidad, p.img_producto, p.descuento_producto, d.id_carrito, p.estado_producto, s.*, d.estado_carrito
FROM tbl_productos AS p 
INNER JOIN tbl_carrito AS d ON d.id_producto = p.id_producto 
INNER JOIN tbl_stock AS s ON p.id_producto = s.id_producto
WHERE d.id_usuario=:id_usuario AND s.id_stock = d.id_stock");
$productos_c->bindParam("id_usuario", $id_usuario);
$productos_c->execute();
$total_p = $productos_c->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT img_producto FROM `tbl_productos` WHERE id_producto=:id_producto");
$sentencia->bindParam(":id_producto", $id_usuario);
$sentencia->execute();
$registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

if (isset($registro_recuperado["img_producto"]) && $registro_recuperado["img_producto"] != "") {
    if (file_exists("./imagenes_producto/" . $registro_recuperado["img_producto"])) {
        unlink("./imagenes_producto/" . $registro_recuperado["img_producto"]);
    }
}

$usuario = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario=:id_usuario");
$usuario->bindParam(":id_usuario", $id_usuario);
$usuario->execute();
$nombre_usuario = $usuario->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM `tbl_productos` ORDER BY RAND()");
$sentencia->execute();
$lista_tbl_productos_c = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_tbl_productos_c as $registro) {
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

<h4 class="titulo_carrito">Mi carrito de compras</h4>

<?php
foreach ($total_p as $productos) {
    $estado_carrito = $productos['estado_carrito'];
}

if (isset($estado_carrito)) {
    if ($estado_carrito == "Pendiente") { ?>
        <div class="container_carrito">
            <table class="table_carrito">
                <thead>
                    <tr>
                        <th class="primer_th">Imagen</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Color</th>
                        <th>Subtotal</th>
                        <th class="ultimo_th">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($total_p as $producto) {
                        $estado_carrito = $producto['estado_carrito'];
                        $estado_producto = $productos['estado_producto'];

                        if ($estado_carrito == "Pendiente") {
                            $id_producto = $producto['id_producto'];
                            $nombre = $producto['nombre'];
                            $precio = $producto['precio'];
                            $cantidad = $producto['cantidad'];
                            $color_producto = $producto['color_producto'];
                            $descuento = $producto['descuento_producto'];
                            $img_producto = $producto['img_producto'];
                            $precio_desc = $precio - (($precio * $descuento) / 100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal;
                            $id_carrito = $producto['id_carrito'];
                            $id_stock = $producto['id_stock'];
                    ?>
                            <tr data-producto="<?php echo $id_producto; ?>">
                                <td>
                                    <img class="imagen_carrito" src="../productos/imagenes_producto/<?php echo $img_producto; ?>" alt="">
                                </td>
                                <td><strong><?php echo $nombre; ?></strong></td>
                                <td>$<?php echo number_format($precio_desc, 0, '.', ','); ?></td>
                                <td>
                                    <div class="cantidad_carrito">
                                        <div class="cantidad">
                                            <p><?php echo $cantidad ?></p>
                                        </div>
                                        <div class="sumar_restar">
                                            <a href="actualizar_compras.php?cantidad=<?php echo "sumar"; ?>&id_producto=<?php echo $id_producto ?>&id_carrito=<?php echo $id_carrito; ?>&id_stock=<?php echo $id_stock ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                                </svg>
                                            </a>
                                            <a href="actualizar_compras.php?cantidad=<?php echo "restar" ?>&id_producto=<?php echo $id_producto ?>&id_carrito=<?php echo $id_carrito; ?>&id_stock=<?php echo $id_stock ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                                    <path d="M5 11h14v2H5z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="container_color">
                                        <i class='bx bxs-color-fill' style='color: <?php echo $color_producto ?>'></i>
                                    </div>
                                </td>
                                </td>
                                <td>
                                    <div id="subtotal_<?php echo $id_producto; ?>" name="subtotal[]">
                                        $<?php echo number_format($subtotal, 0, '.', ','); ?>
                                    </div>
                                </td>
                                <td>
                                    <a onclick="eliminarProducto();" data-id="<?php echo $id_carrito; ?>">
                                        <button class="animated-button-eliminar-producto">
                                            <span>Eliminar</span>
                                            <span></span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="tr_carrito">
                <p>Total: $<?php echo number_format($total, 0, '.', ','); ?></strong></p>
            </div>

            <div class="botones_acciones_carrito">
                <div class="boton1">
                    <button class="vaciarCarrito" onclick="vaciar_carrito();">
                    </button>
                </div>
                <br>
                <div class="boton2">
                    <button class="seguirCompra" id="seguir_comprando">
                    </button>
                </div>
                <br>
                <div class="boton2">
                    <a href="finalizar_compra.php">
                        <button class="finalizarCompra">
                        </button>
                    </a>
                </div>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="container_carrito">
            <table class="table_carrito">
                <tr>
                    <td>
                        <img src="../../imagen/pngwing.com.png" style="width: 300px;"><br>
                        <div class="carrito_vacio">
                            <b>
                                <?php foreach ($nombre_usuario as $nombre_u) {
                                    echo $nombre_u["nombres_u"];
                                } ?>
                                tu carrito está actualmente vacío
                            </b>
                        </div>
                        <div class="boton_seguirComprando">
                            <button class="seguirComprando" id="seguir_comprando">
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    <?php
    }
} else { ?>
    <div class="container_carrito">
        <table class="table_carrito">
            <tr>
                <td>
                    <img src="../../imagen/pngwing.com.png" style="width: 300px;"><br>
                    <div class="carrito_vacio">
                        <b>
                            <?php foreach ($nombre_usuario as $nombre_u) {
                                echo $nombre_u["nombres_u"];
                            } ?>
                            tu carrito está actualmente vacío
                        </b>
                    </div>
                    <div class="boton_seguirComprando">
                        <button class="seguirComprando" id="seguir_comprando">
                        </button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
<?php
}
?>

<script src="../../js/carrusel_productos.js"></script>
<script src="archivos.js/redireccionarBoton.js"></script>
<script src="archivos.js/vaciar_carrito.js"></script>
<script src="archivos.js/eliminar_producto.js"></script>
<script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "no_hay_productos") {
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
            title: 'No hay más cantidades disponibles para agregar.'
        })
    }
    history.replaceState({}, document.title, window.location.pathname);
</script>