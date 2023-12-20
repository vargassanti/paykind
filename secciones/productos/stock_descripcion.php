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

if (isset($_GET['nit_Tienda'])) {
    $nit_Tienda = (isset($_GET['nit_Tienda'])) ? $_GET['nit_Tienda'] : "";

    $tienda = $conexion->prepare("SELECT * FROM tbl_tienda WHERE nit_identificacion = :nit_identificacion");
    $tienda->bindParam(":nit_identificacion", $nit_Tienda);
    $tienda->execute();
    $registro_tbl_tienda = $tienda->fetch(PDO::FETCH_ASSOC);

    if ($registro_tbl_tienda) {
        // Accede a los valores directamente, no necesitas un bucle
        $nombre_tienda = $registro_tbl_tienda['nombre_tienda'];
        $logo_tienda = $registro_tbl_tienda['logo_tienda'];
    } else {
        // Maneja el caso en el que no se encontró ningún registro
        // Puedes mostrar un mensaje de error o redirigir a otra página, por ejemplo
    }

    $sentencia = $conexion->prepare("SELECT logo_tienda FROM `tbl_tienda` WHERE nit_identificacion =:nit_identificacion");
    $sentencia->bindParam(":nit_identificacion", $nit_Tienda);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    $registros_pro = $conexion->prepare("SELECT p.*, s.cantidad_disponible, sc.nombre_sub_categoria FROM tbl_tienda as t
    INNER JOIN tbl_productos as p on p.nit_identificacion = t.nit_identificacion
    INNER JOIN tbl_stock as s on s.id_producto = p.id_producto
    INNER JOIN tbl_sub_categorias as sc on p.id_sub_categoria = sc.id_sub_categoria
    WHERE t.nit_identificacion=:nit_identificacion");
    $registros_pro->bindParam(":nit_identificacion", $nit_Tienda);
    $registros_pro->execute();
    $registros_productos_t = $registros_pro->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?php include("../../templates/header.php"); ?>

<div class="container_info_tienda">
    <?php if ($registro_tbl_tienda) { ?>
        <img class="logo_tienda" src="../tiendas/imagenes_tienda/<?php echo $logo_tienda; ?>">
        <h4 class="titulo_inventario2"><?php echo $nombre_tienda; ?></h4>
        <div class="container_compras">
            <table class="table_categorias" id="stock_descripcion">
                <thead>
                    <?php if (empty($registros_productos_t)) { ?>
                    <?php } else { ?>
                        <tr>
                            <th class="primer_th">Id del Producto:</th>
                            <th>Nombre del Producto:</th>
                            <th>Categoria:</th>
                            <th>Precio Unitario:</th>
                            <th>Cantidad en Stock:</th>
                            <th>Estado:</th>
                            <th class="ultimo_th">Acciones:</th>
                        </tr>
                    <?php } ?>
                </thead>
                <tbody>
                    <?php if (empty($registros_productos_t)) { ?>
                        <tr>
                            <td>
                                <img src="../../imagen/inventario.png" style="width: 500px;"><br>
                                <div class="carrito_vacio">
                                    <b>El inventario de <?php echo $nombre_tienda; ?> actualmente está vacío.</b>
                                </div>
                                <div class="boton_seguirComprando">
                                    <button class="seguirComprando" id="seguir_comprando">
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php } else {
                        foreach ($registros_productos_t as $registro) { ?>
                            <tr class="">
                                <td><?php echo $registro['id_producto']; ?></td>
                                <td><?php echo $registro['nombre']; ?></td>
                                <td><?php echo $registro['nombre_sub_categoria']; ?></td>
                                <td>$<?php echo number_format($registro['precio'], 0, '.', '.'); ?></td>
                                <td><?php echo $registro['cantidad_disponible']; ?></td>
                                <td><?php echo $registro['estado_producto']; ?></td>
                                <td>
                                    <button class="animated-button-editar">
                                        <a href="editar.php?txtID=<?php echo $registro['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $registro['id_producto'], KEY_TOKEN); ?>">
                                            <span>Editar</span>
                                            <span></span>
                                        </a>
                                    </button>

                                    <button class="animated-button-eliminar">
                                        <a href="javascript:borrar(<?php echo $registro['id_producto']; ?>);">
                                            <span>Eliminar</span>
                                            <span></span>
                                        </a>
                                    </button>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>

<script src="archivos.js/borrar.js"></script>