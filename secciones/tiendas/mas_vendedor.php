<?php

session_start();

include("../../bd.php");

if (!isset($_GET['vendedor'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['vendedor'])) {
    $vendedor = $_GET['vendedor'];
    $ruta = (isset($_GET['ruta'])) ? $_GET['ruta'] : "";

    $id_vendedor = $conexion->prepare("SELECT * FROM `tbl_vendedor` WHERE id_usuario = :id_usuario");
    $id_vendedor->bindParam(":id_usuario", $vendedor);
    $id_vendedor->execute();

    $encontrado = false;

    foreach ($id_vendedor as $vendrr) {
        $id_usuario_vendedor = $vendrr['id_usuario'];
        $nombres_u_vendedor = $vendrr['nombres_u'];
        $apellidos_u_vendedor = $vendrr['apellidos_u'];
        $fotoPerfil_vendedor = $vendrr['fotoPerfil'];

        if ($vendedor == $id_usuario_vendedor) {
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        header("Location: tienda_no_encontrada.php?alerta=tiendas_no_encontradas");
        exit();
    }

    $tiendas_vendedor = $conexion->prepare("SELECT * FROM `tbl_tienda` WHERE id_usuario = :id_usuario");
    $tiendas_vendedor->bindParam(":id_usuario", $vendedor);
    $tiendas_vendedor->execute();
    $lista_vendedoress = $tiendas_vendedor->fetchAll(PDO::FETCH_ASSOC);

    $productos_total = $conexion->prepare("SELECT COUNT(*) FROM tbl_productos WHERE nit_identificacion = :nit_identificacion");
    $productos_total->bindParam(":nit_identificacion", $vendedor);
    $productos_total->execute();
    $total_productos = $productos_total->fetchColumn();

    // Consultar los productos de la tienda especificada por 'nit_identificacion'
    $productos = $conexion->prepare("SELECT * FROM tbl_productos WHERE nit_identificacion = :nit_identificacion");
    $productos->bindParam(":nit_identificacion", $txtID);
    $productos->execute();

    include("../../templates/header.php");
?>
    <h4 class="titulo_producto">Perfil del vendedor y sus tiendas</h4>
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

    <div class="perfil_vendedor">
        <div class="imagen_v">
            <?php
            if (!empty($fotoPerfil_vendedor)) { ?>
                <img src="../miperfil/imagenes_producto/<?php echo $fotoPerfil_vendedor ?>" alt="Foto de perfil">
            <?php
            } else {
            ?>
                <img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">
            <?php } ?>
        </div>
        <p>Nombres: <?php echo $nombres_u_vendedor ?></p>
        <p>Apellidos: <?php echo $apellidos_u_vendedor ?></p>
    </div>

    <?php if (empty($lista_vendedoress)) { ?>
        <p class="no_hay_tiendas_vdes"> No hay tiendas asociadas a este usuario.</p>
    <?php
    } else { ?>
        <div class="container23">
            <?php foreach ($lista_vendedoress as $registro) { ?>
                <div class="body">
                    <a class="card_t human-resources" href="mas_tienda.php?txtID=<?php echo $registro['nit_identificacion']; ?>&ruta=index.php">
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
<?php
    }
}
