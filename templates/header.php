<?php

include("../../bd.php");
require '../../config.php';

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    //Buscar el archivo relacionado con el empleado
    $sentencia = $conexion->prepare("SELECT img_producto FROM `tbl_productos` WHERE id_producto=:id_producto");
    $sentencia->bindParam(":id_producto", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_recuperado["img_producto"]) && $registro_recuperado["img_producto"] != "") {
        if (file_exists("./secciones/productos/" . $registro_recuperado["img_producto"])) {
            unlink("./secciones/productos/" . $registro_recuperado["img_producto"]);
        }
    }
}

$sentencia = $conexion->prepare("SELECT * FROM tbl_productos GROUP BY id_producto");
$sentencia->execute();
$lista_tbl_productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM `tbl_tienda`");
$sentencia->execute();
$lista_tbl_tiendas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$productos_c = $conexion->prepare("SELECT p.id_producto, p.nombre, p.precio, d.cantidad, p.img_producto, p.descuento_producto, d.id_carrito, p.estado_producto, s.*, d.estado_carrito
FROM tbl_productos AS p 
INNER JOIN tbl_carrito AS d ON d.id_producto = p.id_producto 
INNER JOIN tbl_stock AS s ON p.id_producto = s.id_producto
WHERE d.id_usuario=:id_usuario AND s.id_stock = d.id_stock");
$productos_c->bindParam("id_usuario", $id_usuario);
$productos_c->execute();
$total_c_flotante = $productos_c->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/estilos_empleado.css">
    <link rel="stylesheet" href="../../css/estilos_productos.css">
    <link rel="stylesheet" href="../../css/estilos_tiendas.css">
    <link rel="stylesheet" href="../../css/menu_desplegable.css">
    <link rel="stylesheet" href="../../css/estilos_categorias.css">
    <link rel="stylesheet" href="../../css/estilos_carrito.css">
    <link rel="stylesheet" href="./estilos_productos.css">
    <link rel="stylesheet" href="./estilos_categorias.css">
    <link rel="stylesheet" href="./estilos_carrito.css">
    <link rel="stylesheet" href="./estilos_tabla.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <title>Paykind</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <a href="../../index.php">
                        <img src="../../img/logo.png">
                    </a>
                </span>
                <div class="text header-text">
                    <span class="name">Paykind</span>
                    <span class="profession">Mensajeria</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <ul class="nav-links">
            <li>
                <a href="../../index.php">
                    <i class='bx bxs-home'></i>
                    <span class="link-name">Inicio</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link-name" href="../../index.php">Inicio</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <a href="../../secciones/productos/buscar_productos.php">
                        <i class='bx bx-search-alt'></i>
                        <span class="link-name">Buscar</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/productos/buscar_productos.php">Buscar</a></li>
                    </ul>
                </a>
            </li>
            <li>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    if (isset($_SESSION['usuario_rol'])) {
                        $usuario_rol = $_SESSION['usuario_rol'];
                        if ($usuario_rol == 'Administrador') {
                ?>
                            <div class="iocn-link">
                                <a href="../../secciones/categorias/index.php">
                                    <i class='bx bxs-widget'></i>
                                    <span class="link-name">Categorias</span>
                                </a>
                                <i class='bx bxs-chevron-down arrow'></i>
                            </div>

                            <ul class="sub-menu">
                                <li><a class="link-name" href="../../secciones/categorias/index.php">Categorias</a></li>
                                <?php
                                $sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
                                $sentencia->execute();
                                $lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($lista_tbl_categorias as $registro) { ?>
                                    <li>
                                        <a href="../../secciones/categorias/categoria.php?txtID=<?php echo $registro['id_categoria']; ?>">
                                            <?php
                                            $contenido = $registro['nombre_categoria'];
                                            $limite_letras = 20;

                                            if (strlen($contenido) > $limite_letras) {
                                                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                                echo $contenido_limitado;
                                            } else {
                                                echo $contenido;
                                            }
                                            ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="../../secciones/categorias/categorias_sub.php">
                                        Ver todas las categorias
                                    </a>
                                </li>
                            </ul>
                        <?php
                        } elseif ($usuario_rol == 'Cliente' || $usuario_rol == 'Vendedor') {
                        ?>
                            <div class="iocn-link">
                                <a href="../../secciones/categorias/categorias_sub.php">
                                    <i class='bx bxs-widget'></i>
                                    <span class="link-name">Categorias</span>
                                </a>
                                <i class='bx bxs-chevron-down arrow'></i>
                            </div>

                            <ul class="sub-menu">
                                <li><a class="link-name">Categorias</a></li>
                                <?php
                                $sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
                                $sentencia->execute();
                                $lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($lista_tbl_categorias as $registro) { ?>
                                    <li>
                                        <a href="../../secciones/categorias/categoria.php?txtID=<?php echo $registro['id_categoria']; ?>">
                                            <?php
                                            $contenido = $registro['nombre_categoria'];
                                            $limite_letras = 20;

                                            if (strlen($contenido) > $limite_letras) {
                                                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                                echo $contenido_limitado;
                                            } else {
                                                echo $contenido;
                                            }
                                            ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="../../secciones/categorias/categorias_sub.php">
                                        Ver todas las categorias
                                    </a>
                                </li>
                            </ul>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <div class="iocn-link">
                        <a href="../../secciones/categorias/categorias_sub.php">
                            <i class='bx bxs-widget'></i>
                            <span class="link-name">Categorias</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>

                    <ul class="sub-menu">
                        <li><a class="link-name" href="../../secciones/categorias/categorias_sub.php">Categorias</a></li>
                        <?php
                        $sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
                        $sentencia->execute();
                        $lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($lista_tbl_categorias as $registro) { ?>
                            <li>
                                <a href="../../secciones/categorias/categoria.php?txtID=<?php echo $registro['id_categoria']; ?>">
                                    <?php
                                    $contenido = $registro['nombre_categoria'];
                                    $limite_letras = 20;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="../../secciones/categorias/categorias_sub.php">
                                Ver todas las categorias
                            </a>
                        </li>
                    </ul>
                <?php
                }
                ?>
            </li>
            <?php
            if (isset($_SESSION['usuario_rol'])) {
                $usuario_rol = $_SESSION['usuario_rol'];
                $usuario_id = $_SESSION['usuario_id'];
                if ($usuario_rol !== 'Administrador') {
            ?>
                    <li>
                        <a href="../../secciones/tiendas/index.php">
                            <i class='bx bxl-shopify'></i>
                            <span class="link-name">Tiendas</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link-name" href="../../secciones/tiendas/index.php">Tiendas</a></li>
                        </ul>
                    </li>
                <?php
                }
            } else {
                ?>
                <li>
                    <a href="../../secciones/tiendas/index.php">
                        <i class='bx bxl-shopify'></i>
                        <span class="link-name">Tiendas</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/tiendas/index.php">Tiendas</a></li>
                    </ul>
                </li>
            <?php
            }
            ?>
            <li>
                <a href="../../secciones/productos/index.php">
                    <i class='bx bxs-t-shirt'></i>
                    <span class="link-name">Productos</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link-name" href="../../secciones/productos/index.php">Productos</a></li>
                </ul>
            </li>
            <li>
                <a href="../../secciones/tiendas/vendedores.php">
                    <i class='bx bxs-user-pin'></i>
                    <span class="link-name">Vendedores</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link-name" href="../../secciones/tiendas/vendedores.php">Vendedores</a></li>
                </ul>
            </li>
            <?php
            if (isset($_SESSION['usuario_rol'])) {
                $usuario_rol = $_SESSION['usuario_rol'];
                $usuario_id = $_SESSION['usuario_id'];
                if ($usuario_rol !== 'Vendedor' && $usuario_rol !== 'Administrador') { ?>
                    <li>
                        <a href="../../secciones/productos/ofertas.php">
                            <i class='bx bx-gift'></i>
                            <span class="link-name">Ofertas</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link-name" href="../../secciones/productos/ofertas.php">Ofertas</a></li>
                        </ul>
                    </li>
                <?php
                }
            } else {
                ?>
                <li>
                    <a href="../../secciones/productos/ofertas.php">
                        <i class='bx bx-gift'></i>
                        <span class="link-name">Ofertas</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/productos/ofertas.php">Ofertas</a></li>
                    </ul>
                </li>
            <?php
            }
            // var_dump($_SESSION);
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            ?>
                <li>
                    <?php
                    if (isset($_SESSION['usuario_rol'])) {
                    }
                    $usuario_rol = $_SESSION['usuario_rol'];
                    $usuario_id = $_SESSION['usuario_id'];
                    if ($usuario_rol == 'Cliente') {
                    ?>
                <li>
                    <a id="abrir_modal_flotante">
                        <i class='bx bxs-cart'></i>
                        <?php
                        if (!empty($contador) && $contador[0]['contador'] > 0) {
                        ?>
                            <div class="count-products">
                                <span class="cantidad_productos">
                                    <?php
                                    foreach ($contador as $cont) {
                                        echo $cont['contador'];
                                    }
                                    ?>
                                </span>
                            </div>
                        <?php
                        }
                        ?>
                        <span class="link-name">Carrito
                        </span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/carrito/checkout.php">Carrito</a></li>
                    </ul>
                </li>
            <?php
                    } elseif ($usuario_rol == 'Administrador') {
            ?>
                <li>
                    <a href="../../secciones/usuarios/index.php">
                        <i class='bx bxs-user-account'></i>
                        <span class="link-name">Usuarios</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/usuarios/index.php">Usuarios registrados</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../../secciones/tiendas/tiendas_registradas.php">
                        <i class='bx bxs-store'></i>
                        <span class="link-name">Tiendas</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/tiendas/tiendas_registradas.php">Tiendas registradas</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../../secciones/usuarios/reportes.php">
                        <i class='bx bxs-report'></i>
                        <span class="link-name">Reportes</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/usuarios/reportes.php">Reportes</a></li>
                    </ul>
                </li>
            <?php
                    } elseif ($usuario_rol == 'Vendedor') {
            ?>
                <li>
                    <div class="iocn-link">
                        <a href="../../secciones/productos/compras_clientes.php">
                            <i class='bx bxs-shopping-bags'></i>
                            <?php if (!empty($contador_compras_enp) && $contador_compras_enp[0]['conteo_registros'] > 0) { ?>
                                <div class="notificaciones_compra"></div>
                            <?php } ?>
                            <span class="link-name">Compras</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link-name" href="../../secciones/productos/compras_clientes.php">Compras</a></li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=pendientes">
                                Pendientes
                                <?php if (!empty($contador_compras_pdn) && $contador_compras_pdn[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_pdn as $pdn) {
                                                echo $pdn['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=en_proceso">
                                En proceso
                                <?php if (!empty($contador_compras_enp) && $contador_compras_enp[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_enp as $proc) {
                                                echo $proc['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=aprobado">
                                Aprobados
                                <?php if (!empty($contador_compras_apr) && $contador_compras_apr[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_apr as $apr) {
                                                echo $apr['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=espera_envio">
                                En espera de envío
                                <?php if (!empty($contador_compras_esp) && $contador_compras_esp[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_esp as $esp) {
                                                echo $esp['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=en_transito">
                                En tránsito
                                <?php if (!empty($contador_compras_trans) && $contador_compras_trans[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_trans as $trans) {
                                                echo $trans['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=entregado">
                                Entregados
                                <?php if (!empty($contador_compras_ent) && $contador_compras_ent[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_ent as $ent) {
                                                echo $ent['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=completado">
                                Completados
                                <?php if (!empty($contador_compras_comp) && $contador_compras_comp[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_comp as $comp) {
                                                echo $comp['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../secciones/productos/info_compras_clientes.php?c=cancelado">
                                Cancelados
                                <?php if (!empty($contador_compras_c) && $contador_compras_c[0]['conteo_registros'] > 0) { ?>
                                    <div class="contador_compras">
                                        <p><?php
                                            foreach ($contador_compras_c as $canc) {
                                                echo $canc['conteo_registros'];
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="../../secciones/tiendas/mitienda.php">
                        <i class='bx bx-store'></i>
                        <span class="link-name">Mi tienda</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/tiendas/mitienda.php">Mi tienda</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../../secciones/productos/mis_productos.php">
                        <i class='bx bxs-carousel'></i>
                        <span class="link-name">Mis productos</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/productos/mis_productos.php">Mis productos</a></li>
                    </ul>
                    </a>
                </li>
                <li>
                    <a href="../../secciones/productos/stock.php">
                        <i class='bx bx-archive-out'></i>
                        <span class="link-name">Inventario</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link-name" href="../../secciones/productos/stock.php">Inventario</a></li>
                    </ul>
                </li>
            <?php
                    }
            ?>
            <li>
                <div id="profile-details" class="profile-details">
                    <div class="profile-content">
                        <?php
                        $id_rol = $_SESSION["usuario_rol"];

                        if ($id_rol == 'Cliente') {
                            $tabla = 'tbl_usuario';
                        } elseif ($id_rol == 'Vendedor') {
                            $tabla = 'tbl_vendedor';
                        } elseif ($id_rol == 'Administrador') {
                            $tabla = 'tbl_administrador';
                        } else {
                            // Maneja el caso en que el rol no sea válido
                            echo "El rol seleccionado no es válido.";
                            exit;
                        }

                        $sql = "SELECT * FROM $tabla WHERE id_usuario=:id_usuario";
                        $stmt = $conexion->prepare($sql);
                        $stmt->bindParam(":id_usuario", $_SESSION['usuario_id']);
                        $stmt->execute();
                        $registro_recuperado_foto_perfil = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($registro_recuperado_foto_perfil as $info) {
                            $nombres_u = $info['nombres_u'];
                            $id_rol = $info['id_rol'];
                        }

                        // Variable para almacenar el nombre de la foto de perfil
                        $nombre_foto_perfil = '';

                        foreach ($registro_recuperado_foto_perfil as $mi_foto) {
                            if (!empty($mi_foto['fotoPerfil']) && file_exists("../../secciones/miperfil/imagenes_producto/" . $mi_foto['fotoPerfil'])) {
                                $nombre_foto_perfil = $mi_foto['fotoPerfil'];
                                break; // Rompemos el bucle al encontrar la primera foto válida
                            }
                        }

                        // Si hay una foto de perfil válida, la mostramos; de lo contrario, mostramos una imagen predeterminada
                        if (!empty($nombre_foto_perfil)) {
                            echo '<img src="../../secciones/miperfil/imagenes_producto/' . $nombre_foto_perfil . '" alt="Foto de perfil">';
                        } else {
                            echo '<img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">';
                        }
                        ?>
                    </div>
                    <div class="name-job">
                        <div class="profile_name"><?php echo $nombres_u ?></div>
                        <div class="job"><?php echo $id_rol ?></div>
                    </div>
                </div>
            </li>
            </li>
        <?php
            } else {
        ?>
            <li>
                <a href="../../registro.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="link-name">Ingresar</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link-name" href="../../registro.php">Ingresar</a></li>
                </ul>
            </li>
        <?php
            }
        ?>
        </ul>
    </nav>

    <?php
    if (isset($_SESSION['loggedin']) === true) {
    ?>
        <div id="container-profile" class="container-profile ocultar_profile">
            <div class="posicion_cerrar">
                <i class='bx bx-x-circle cerrar_profile'></i>
            </div>
            <?php
            foreach ($registro_recuperado_foto_perfil as $info) { ?>
                <p class="correo">
                    <?php
                    $contenido = $info['correo'];
                    $limite_letras = 30;

                    if (strlen($contenido) > $limite_letras) {
                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                        echo $contenido_limitado;
                    } else {
                        echo $contenido;
                    }
                    ?>
                </p>
                <a href="../../secciones/miperfil/index.php">
                    <?php
                    if (!empty($info['fotoPerfil'])) { ?>
                        <div class="contaner_img_profile">
                            <img src="../../secciones/miperfil/imagenes_producto/<?php echo $info['fotoPerfil'] ?>" alt="Foto de perfil">
                        </div>
                        <div class="posicion_bt_editar">
                            <i class='bx bx-edit-alt'></i>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="contaner_img_profile">
                            <img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">
                        </div>
                        <div class="posicion_bt_editar">
                            <i class='bx bx-edit-alt'></i>
                        </div>
                    <?php } ?>
                </a>
                <p class="nombre">¡Hola, <?php echo $info['nombres_u'] ?>!</p>
            <?php } ?>
            <div class="container-botones-profile">
                <a href="../../secciones/miperfil/index.php">
                    <button class="editar_perfil">
                        Editar mi perfil
                    </button>
                </a>
                <button class="cerrar_sesion" onclick="confirmarCerrarSesion()">
                    Cerrar sesión
                </button>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="modal_carrito_flotante" id="jsModalCarrito">
        <div class="modal__container">
            <button type="button" class="modal__close fa-solid fa-xmark jsModalClose "></button>
            <div class="modal__info">
                <div class="modal__header">
                    <h2><i class='bx bx-cart'></i>Carrito</h2>
                </div>
                <?php if (!empty($total_c_flotante)) { ?>
                    <div class="modal__body">
                        <div class="modal__list">
                            <?php
                            $total = 0;
                            foreach ($total_c_flotante as $flotante) {
                                $precio_desc = $flotante['precio'] - (($flotante['precio'] * $flotante['descuento_producto']) / 100);
                                $subtotal = $flotante['cantidad'] * $precio_desc;
                                $total += $subtotal;
                            ?>
                                <div class="modal__item">
                                    <div class="modal__thumb">
                                        <img src="../../secciones/productos/imagenes_producto/<?php echo $flotante['img_producto'] ?>" alt="Naranja">
                                    </div>
                                    <div class="modal__text-product">
                                        <p><?php echo $flotante['nombre'] ?></p>
                                        <p><strong>$ <?php echo number_format($precio_desc, 0, '.', ','); ?></strong></p>
                                        <p>Cantidad: <?php echo $flotante['cantidad'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="modal__footer">
                        <div class="modal__list-price">
                            <ul>
                                <li>Productos agregados:
                                    <strong>
                                        <?php foreach ($contador as $cont) {
                                            echo $cont['contador'];
                                        } ?>
                                    </strong>
                                </li>
                            </ul>
                            <h4 class="modal__total-cart"> Total: <?php echo number_format($total, 0, '.', ','); ?></h4>
                        </div>

                        <div class="modal__btns">
                            <a href="../../secciones/carrito/checkout.php" class="btn-border">Ir al carrito</a>
                            <a href="../../secciones/carrito/finalizar_compra.php" class="btn-primary">Finalizar compra</a>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="mensaje-carrito-vacio">
                        <img src="../../imagen/pngwing.com.png">
                        <p>Tú carrito está actualmente vacío.</p>
                        <a href="../../secciones/productos/index.php">
                            <button class="seguirComprando">
                            </button>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="../../js/app.js"></script>
    <script src="../../js/menu.js"></script>
    <script src="../../js/menu2.js"></script>
    <script src="../../js/carrito.js"></script>
    <script src="../../js/arrow.js"></script>
    <script src="../../js/carrusel.js"></script>
    <script src="../../js/mostrar_profile.js"></script>
    <script src="../../js/carrito_flotante.js"></script>
    <?php
    if (isset($_GET['mensaje'])) {
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

            mostrarAlerta('success', '<?php echo $_GET['mensaje']; ?>');
            history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php
    }

    if (isset($_GET['mensaje_bienvenida']) && !isset($_SESSION['alerta_bienvenida_mostrada'])) {
    ?>
        <script>
            // Función para mostrar una alerta de bienvenida
            function mostrarAlertaBienvenida(icon, title) {
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

                Toast.fire({
                    icon: icon,
                    title: title
                });
            }

            mostrarAlertaBienvenida('success', '<?php echo $_GET['mensaje_bienvenida']; ?>');

            // Marca la alerta de bienvenida como mostrada
            <?php $_SESSION['alerta_bienvenida_mostrada'] = true; ?>
        </script>
    <?php
    }
    ?>
    <script type="text/javascript">
        function confirmarCerrarSesion() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'warning',
                title: '¿Desea cerrar la sesión?',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    // El usuario hizo clic en "Sí"
                    window.location.href = "../../cerrar.php";
                } else {
                    // El usuario hizo clic en "No" o cerró la alerta
                    // Puedes realizar alguna acción adicional aquí si es necesario
                }
            });
        }
    </script>
</body>

</html>