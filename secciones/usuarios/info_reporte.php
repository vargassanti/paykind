<?php
session_start();

include("../../bd.php");
require '../../config.php';

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

$id_usuario = $_SESSION['usuario_id'];

$tiendas = $conexion->prepare("SELECT * FROM tbl_tienda");
$tiendas->execute();
$tiendas_admin = $tiendas->fetchAll(PDO::FETCH_ASSOC);

$clientes = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_rol = 'Cliente'");
$clientes->execute();
$clientes_admin = $clientes->fetchAll(PDO::FETCH_ASSOC);

$vendedores = $conexion->prepare("SELECT * FROM tbl_vendedor WHERE id_rol = 'Vendedor'");
$vendedores->execute();
$vendedores_admin = $vendedores->fetchAll(PDO::FETCH_ASSOC);

$productos = $conexion->prepare("SELECT p.*, s.*, t.nombre_tienda,t.nit_identificacion
FROM tbl_productos as p 
INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion");
$productos->execute();
$productos_admin = $productos->fetchAll(PDO::FETCH_ASSOC);

$compras = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario;");
$compras->execute();
$compras_admin = $compras->fetchAll(PDO::FETCH_ASSOC);

$info_ad = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario =:id_usuario");
$info_ad->bindParam(":id_usuario", $id_usuario);
$info_ad->execute();
$informacion = $info_ad->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");

if (isset($_GET['type'])) {
    $reportType = $_GET['type'];

    switch ($reportType) {
        case 'ventas':
            // Lógica para mostrar información de ventas
?>
            <div class="container_compras">
                <div class="caja_botoncancelar_infoproducto">
                    <a href="reportes.php">
                        <button class="button_retroceder_infoproducto">
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
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar compras.." class="input_compras" id="search_input_ventas" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras</h2>

                <br>

                <table id="tabla_compras_ventas">
                    <thead>
                        <tr>
                            <th class="primer_th">Id compra</th>
                            <th>Total compra</th>
                            <th>Costo envio</th>
                            <th>Usuario</th>
                            <th>Identificación usuario</th>
                            <th>Correo usuario</th>
                            <th>Metodo pago</th>
                            <th>Fecha compra</th>
                            <th class="ultimo_th">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($compras_admin as $compras) { ?>
                            <tr>
                                <td><?php echo $compras['id_compra'] ?></td>
                                <td>$<?php echo number_format($compras['total_compra'], 0, '.', ','); ?></td>
                                <td>$<?php echo number_format($compras['costo_envio'], 0, '.', ','); ?></td>
                                <td><?php echo $compras['usuario'] ?></td>
                                <td><?php echo $compras['id_usuario'] ?></td>
                                <td><?php echo $compras['correo'] ?></td>
                                <td><?php echo $compras['metodo_pago'] ?></td>
                                <td><?php echo $compras['fecha_compra'] ?></td>
                                <td>
                                    <div class="opciones_comp">
                                        <a onclick="cargarVistaRapidaCompras(<?php echo $compras['id_compra']; ?>)">
                                            <div class="ver_compra_lupa">
                                                <i class='bx bx-search-alt-2'></i>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'inventario':
            // Lógica para mostrar información de inventario
        ?>
            <div class="container_compras">
                <div class="caja_botoncancelar_infoproducto">
                    <a href="reportes.php">
                        <button class="button_retroceder_infoproducto">
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
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar en el inventario.." class="input_compras" id="search_input_inventario" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro del inventario</h2>

                <br>
                <table id="tabla_inventario">
                    <thead>
                        <tr>
                            <th class="primer_th">Imagen</th>
                            <th>Id producto</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Nit tienda</th>
                            <th>Tienda</th>
                            <th>Cantidad</th>
                            <th>Fecha registro</th>
                            <th class="ultimo_th">Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($productos_admin as $productos) { ?>
                            <tr>
                                <td>
                                    <img src="../productos/imagenes_producto/<?php echo $productos['img_producto'] ?>" width="100px" height="100px">
                                </td>
                                <td><?php echo $productos['id_producto'] ?></td>
                                <td><?php echo $productos['nombre'] ?></td>
                                <td>$<?php echo number_format($productos['precio'], 0, '.', ','); ?></td>
                                <td><?php echo $productos['nit_identificacion'] ?></td>
                                <td><?php echo $productos['nombre_tienda'] ?></td>
                                <td><?php echo $productos['cantidad_disponible'] ?></td>
                                <td><?php echo $productos['fecha_registro'] ?></td>
                                <td>
                                    <span class="color-option" style="background-color: <?php echo $productos['color_producto']; ?>;"></span>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'clientes':
            // Lógica para mostrar información de los clientes
        ?>
            <div class="container_compras">
                <div class="caja_botoncancelar_infoproducto">
                    <a href="reportes.php">
                        <button class="button_retroceder_infoproducto">
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
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar clientes.." class="input_compras" id="search_input_clientes" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de los clientes</h2>

                <br>
                <table id="tabla_clientes">
                    <thead>
                        <tr>
                            <th class="primer_th">Foto perfil</th>
                            <th>Id usuario</th>
                            <th>Usuario</th>
                            <th>Tipo documento</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Municipio</th>
                            <th>Barrio</th>
                            <th>Comuna</th>
                            <th>Direccion</th>
                            <th class="ultimo_th">Rol</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($clientes_admin as $clientes) { ?>
                            <tr>
                                <td>
                                    <?php
                                    $ruta_foto = "../miperfil/imagenes_producto/" . $clientes['fotoPerfil'];

                                    if (empty($clientes['fotoPerfil']) || !file_exists($ruta_foto)) {
                                        // Si no hay foto de perfil o el archivo no existe, muestra una imagen predeterminada
                                        $imagen_predeterminada = "../../imagen/Avatar-No-Background.png"; // Reemplaza con la ruta de tu imagen predeterminada
                                        echo '<img src="' . $imagen_predeterminada . '" width="70px" height="70px">';
                                    } else {
                                        // Si hay foto de perfil y el archivo existe, muestra la foto de perfil
                                        echo '<img src="' . $ruta_foto . '" width="70px" height="70px">';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numero = $clientes['id_usuario'];
                                    $limite_digitos = 7;

                                    if (strlen((string)$numero) > $limite_digitos) {
                                        $numero_limitado = number_format($numero, 0, '', '');
                                        echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                    } else {
                                        echo $numero;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contenido = $clientes['usuario'];
                                    $limite_letras = 7;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $clientes['tipo_documento_u'] ?></td>
                                <td>
                                    <?php
                                    $contenido = $clientes['nombres_u'];
                                    $limite_letras = 7;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contenido = $clientes['apellidos_u'];
                                    $limite_letras = 7;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contenido = $clientes['correo'];
                                    $limite_letras = 8;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numero = $clientes['celular'];
                                    $limite_digitos = 7;

                                    if (strlen((string)$numero) > $limite_digitos) {
                                        $numero_limitado = number_format($numero, 0, '', '');
                                        echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                    } else {
                                        echo $numero;
                                    }
                                    ?>
                                </td>
                                <td>Medellin</td>
                                <td>Barrio</td>
                                <td>Comuna</td>
                                <td>
                                    <?php
                                    $contenido = $clientes['direccion'];
                                    $limite_letras = 8;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>

                                <td><?php echo $clientes['id_rol'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'vendedores':
            // Lógica para mostrar información de los vendedores
        ?>
            <div class="container_compras">
                <div class="caja_botoncancelar_infoproducto">
                    <a href="reportes.php">
                        <button class="button_retroceder_infoproducto">
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
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar vendedores..." class="input_compras" id="search_input_vendedores" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de los vendedores</h2>

                <br>
                <table id="tabla_vendedores">
                    <thead>
                        <tr>
                            <th class="primer_th">Foto perfil</th>
                            <th>Id usuario</th>
                            <th>Usuario</th>
                            <th>Tipo documento</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Municipio</th>
                            <th>Barrio</th>
                            <th>Comuna</th>
                            <th>Direccion</th>
                            <th class="ultimo_th">Rol</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($vendedores_admin as $clientes) { ?>
                            <tr>
                                <td>
                                    <?php
                                    $ruta_foto = "../miperfil/imagenes_producto/" . $clientes['fotoPerfil'];

                                    if (empty($clientes['fotoPerfil']) || !file_exists($ruta_foto)) {
                                        // Si no hay foto de perfil o el archivo no existe, muestra una imagen predeterminada
                                        $imagen_predeterminada = "../../imagen/Avatar-No-Background.png"; // Reemplaza con la ruta de tu imagen predeterminada
                                        echo '<img src="' . $imagen_predeterminada . '" width="70px" height="70px">';
                                    } else {
                                        // Si hay foto de perfil y el archivo existe, muestra la foto de perfil
                                        echo '<img src="' . $ruta_foto . '" width="70px" height="70px">';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numero = $clientes['id_usuario'];
                                    $limite_digitos = 7;

                                    if (strlen((string)$numero) > $limite_digitos) {
                                        $numero_limitado = number_format($numero, 0, '', '');
                                        echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                    } else {
                                        echo $numero;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contenido = $clientes['usuario'];
                                    $limite_letras = 7;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $clientes['tipo_documento_u'] ?></td>
                                <td>
                                    <?php
                                    $contenido = $clientes['nombres_u'];
                                    $limite_letras = 7;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contenido = $clientes['apellidos_u'];
                                    $limite_letras = 7;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contenido = $clientes['correo'];
                                    $limite_letras = 8;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numero = $clientes['celular'];
                                    $limite_digitos = 7;

                                    if (strlen((string)$numero) > $limite_digitos) {
                                        $numero_limitado = number_format($numero, 0, '', '');
                                        echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                    } else {
                                        echo $numero;
                                    }
                                    ?>
                                </td>
                                <td>Medellin</td>
                                <td>Barrio</td>
                                <td>Comuna</td>
                                <td>
                                    <?php
                                    $contenido = $clientes['direccion'];
                                    $limite_letras = 8;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>

                                <td><?php echo $clientes['id_rol'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'tiendas';
            // Lógica para mostrar información de las tiendas
        ?>
            <div class="container_compras">
                <div class="caja_botoncancelar_infoproducto">
                    <a href="reportes.php">
                        <button class="button_retroceder_infoproducto">
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
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar tiendas..." class="input_compras" id="search_input_tiendas" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de las tiendas</h2>

                <br>
                <table id="tabla_tiendas">
                    <thead>
                        <tr>
                            <th class="primer_th">Logo</th>
                            <th>Nit</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th class="ultimo_th">Id vendedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tiendas_admin as $tiendas) { ?>
                            <tr>
                                <td>
                                    <img src="../tiendas/imagenes_tienda/<?php echo $tiendas['logo_tienda'] ?>" width="100px" height="100px">
                                </td>
                                <td><?php echo $tiendas['nit_identificacion'] ?></td>
                                <td><?php echo $tiendas['nombre_tienda'] ?></td>
                                <td>
                                    <?php
                                    $contenido = $tiendas['descripcion'];
                                    $limite_letras = 100;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $tiendas['id_usuario'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
<?php
            break;
        default:
            // Manejar un tipo de reporte desconocido
            break;
    }
} else {
    echo "No se ha especificado un tipo de reporte.";
}
?>

<input type="checkbox" id="btn-modal">
<div class="container-modal-compras" id="modal">
    <div class="content-modal">
        <div id="vista-rapida-content"></div>
        <div class="position__boton">
            <div class="fondo_boton_cerrar" onclick="cerrarModal()">
                <i class='bx bx-x'></i>
            </div>
        </div>
    </div>
    <label onclick="cerrarModal()" class="cerrar-modal"></label>
</div>

<button class="boton_volver_arriba_admin" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
    <i class='bx bx-up-arrow-alt'></i>
</button>

<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<script src="../../js/jquery-3.7.1.min.js"></script>
<script src="archivos.js/compras.js"></script>
<script src="archivos.js/inventario.js"></script>
<script src="archivos.js/clientes.js"></script>
<script src="archivos.js/vendedores.js"></script>
<script src="archivos.js/tiendas.js"></script>
<script src="archivos.js/modal_compras.js"></script>