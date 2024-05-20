<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

$id_usuario = $_SESSION['usuario_id'];

//Buscar el archivo relacionado con el empleado
$sentencia = $conexion->prepare("SELECT logo_tienda FROM `tbl_tienda` WHERE nit_identificacion =:nit_identificacion");
$sentencia->bindParam(":nit_identificacion", $id_usuario);
$sentencia->execute();
$registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

$sentencia = $conexion->prepare("SELECT * FROM tbl_tienda WHERE id_usuario=:id_usuario");
$sentencia->bindParam(':id_usuario', $id_usuario);
$sentencia->execute();
$lista_tbl_mis_r_tiendas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php"); ?>

<h4 class="titulo_inventario">Inventario tiendas</h4>
<?php if (empty($lista_tbl_mis_r_tiendas)) {
} else { ?>
    <p class="texto_inventario">Selecciona la tienda que desees ver su inventario de productos:</p>
<?php
}
?>

<div class="container23">
    <?php if (empty($lista_tbl_mis_r_tiendas)) { ?>
        <b class="no_hay_productos_r">No hay tiendas registradas.</b>
        <?php } else {
        foreach ($lista_tbl_mis_r_tiendas as $registro) { ?>
            <div class="body">
                <a class="card_t human-resources" href="stock_descripcion.php?nit_Tienda=<?php echo $registro['nit_identificacion']; ?>">
                    <img class="imagen_tiendaa" src="../tiendas/imagenes_tienda/<?php echo $registro['logo_tienda']; ?>" />
                    <p><strong><?php echo $registro['nombre_tienda']; ?></strong></p>
                </a>
            </div>
    <?php
        }
    }
    ?>
</div>