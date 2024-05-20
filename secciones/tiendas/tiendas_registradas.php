<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");
require '../../config.php';

if (isset($_GET['nit_identificacion'])) {
    $nit_identificacion = (isset($_GET['nit_identificacion'])) ? $_GET['nit_identificacion'] : "";

    // Consulta para obtener el nombre del archivo de la imagen actual
    $consulta_imagen_actual = $conexion->prepare("SELECT logo_tienda FROM tbl_tienda WHERE nit_identificacion=:nit_identificacion");
    $consulta_imagen_actual->bindParam(":nit_identificacion", $nit_identificacion);
    $consulta_imagen_actual->execute();
    $resultado_imagen_actual = $consulta_imagen_actual->fetch(PDO::FETCH_ASSOC);

    if (is_array($resultado_imagen_actual)) {
        $imagen_actual = $resultado_imagen_actual['logo_tienda'];

        // Eliminar la imagen actual si existe
        if ($imagen_actual && file_exists('./imagenes_tienda/' . $imagen_actual)) {
            unlink('./imagenes_tienda/' . $imagen_actual);
        }
    }

    // Luego, procedes a eliminar la tienda de la base de datos
    $eliminar_tienda = $conexion->prepare("DELETE FROM tbl_tienda WHERE nit_identificacion=:nit_identificacion");
    $eliminar_tienda->bindParam(":nit_identificacion", $nit_identificacion);
    $eliminar_tienda->execute();

    $mensaje = "Registro eliminado";
    header("location:mitienda.php?mensaje=" . $mensaje);
    exit;
}

$sentencia = $conexion->prepare("SELECT * FROM tbl_tienda ");
$sentencia->execute();
$lista_tbl_tiendas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../../templates/header.php"); ?>

<h4 class="titulo_tienda">Tiendas</h4>
<div class="container23">
    <?php foreach ($lista_tbl_tiendas as $registro) { ?>
        <div class="body">
            <a class="card_t human-resources" href="mas_tienda.php?txtID=<?php echo $registro['nit_identificacion']; ?>&ruta=tiendas_registradas.php">
                <img class="imagen_tiendaa" src="./imagenes_tienda/<?php echo $registro['logo_tienda']; ?>" />
                <p>
                    <strong>
                        <?php
                        $contenido = $registro['nombre_tienda'];
                        $limite_letras = 20;

                        if (strlen($contenido) > $limite_letras) {
                            $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                            echo $contenido_limitado;
                        } else {
                            echo $contenido;
                        }
                        ?>
                    </strong>
                </p>
            </a>
        </div>
    <?php } ?>
</div>