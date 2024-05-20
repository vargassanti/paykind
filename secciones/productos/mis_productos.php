<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

$tiendas_registro = []; // Inicializa la variable como un array vacío

$tiendas_u = $conexion->prepare("SELECT * FROM `tbl_tienda` WHERE id_usuario=:id_usuario");
$tiendas_u->bindParam(":id_usuario", $id_usuario);
$tiendas_u->execute();
$tiendas_registro = $tiendas_u->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET["txtID"])) {

    $sentencia = $conexion->prepare("SELECT img_producto FROM `tbl_productos` WHERE id_producto=:id_producto");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_recuperado["img_producto"]) && $registro_recuperado["img_producto"] != "") {
        if (file_exists("./imagenes_producto/" . $registro_recuperado["img_producto"])) {
            unlink("./imagenes_producto/" . $registro_recuperado["img_producto"]);
        }
    }
}

$opciones_r = $conexion->prepare("SELECT p.nit_identificacion, t.id_usuario, p.id_producto
FROM tbl_productos AS p
INNER JOIN tbl_tienda AS t ON p.nit_identificacion = t.nit_identificacion
WHERE t.id_usuario = :id_usuario;");
$opciones_r->bindParam(":id_usuario", $id_usuario);
$opciones_r->execute();
$opciones_vendedor = $opciones_r->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT p.*, t.id_usuario
FROM tbl_productos AS p
INNER JOIN tbl_tienda AS t ON p.nit_identificacion = t.nit_identificacion
WHERE t.id_usuario = :id_usuario");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->execute();
$lista_mis_productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_mis_productos as $registro) {
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

<h4 class="titulo_producto">Mis productos</h4>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (isset($_SESSION['usuario_rol'])) {
        $usuario_rol = $_SESSION['usuario_rol'];
        if ($usuario_rol == 'Vendedor') {
            if (count($tiendas_registro) > 0) {
?>
                <div class="caja">
                    <a href="../productos/crear.php">
                        <button class="button" type="button">
                            <span class="button__text">Añadir productos</span>
                            <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="12" x2="12" y1="5" y2="19"></line>
                                    <line x1="5" x2="19" y1="12" y2="12"></line>
                                </svg></span>
                        </button>
                    </a>
                </div>
<?php
            }
        }
    }
}
?>

<div class="container_producticos">
    <?php if (empty($lista_mis_productos)) { ?>
        <b class="no_hay_productos_r">No hay productos registrados.</b>
        <?php } else {
        foreach ($lista_mis_productos as $registro) { ?>
            <div class="caja2">
                <img class="imagenn" src="./imagenes_producto/<?php echo $registro['img_producto']; ?>" class="img-fluid rounded" alt="" />
                <?php if ($registro['estado_producto'] == "Inactivo") { ?>
                    <div class="estado_producto">
                        <p>Producto inactivo</p>
                    </div>
                <?php } ?>
                <div class="container_parrafos">
                    <span style="font-size: 16px;">
                        $<?php echo number_format($registro['precio'], 0, '.', '.'); ?></del></span>
                    </span>
                    <hr>
                    <p class="precio_descuento2">
                        En oferta
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
                <div class="dropdown">
                    <button class="dropbtn" id="dropdownBtn">Opciones</button>
                    <div class="dropdown-content" id="myDropdown">
                        <button class="animated-button-añadir">
                            <a href="añadir_referencia.php?txtID=<?php echo $registro['id_producto']; ?>">
                                <span>Añadir</span>
                                <span></span>
                            </a>
                        </button>

                        <button class="animated-button-editar_r">
                            <a href="editar.php?txtID=<?php echo $registro['id_producto']; ?>">
                                <span>Editar</span>
                                <span></span>
                            </a>
                        </button>

                        <button class="animated-button-eliminar_r">
                            <a href="javascript:borrar(<?php echo $registro['id_producto']; ?>);">
                                <span>Eliminar</span>
                                <span></span>
                            </a>
                        </button>
                    </div>
                </div>
                <a href="./info_producto.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>&ruta=mis_productos.php">
                    <button class="Btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                            <path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path>
                            <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path>
                        </svg>
                    </button>
                </a>
            </div>
    <?php }
    } ?>
</div>

<?php
if (isset($_GET['errorMensaje'])) {
    // Función para mostrar una alerta
    function mostrarAlerta($icon, $title)
    {
        echo "<script>
            mostrarAlerta('$icon', '$title');
        </script>";
    }
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Función para mostrar una alerta
        function mostrarAlerta(icon, title) {
            Toast.fire({
                icon: icon,
                title: title
            });
        }

        mostrarAlerta('error', '<?php echo $_GET['errorMensaje']; ?>');
    </script>
<?php
}
?>
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

<script src="archivos.js/borrar.js"></script>
<script src="archivos.js/dropdown-content.js"></script>