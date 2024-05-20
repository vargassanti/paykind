<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor")) {
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

$id_usuario = $_SESSION['usuario_id'];

// CONSULTA DE TODAS LAS COMPRAS PENDIENTES
$pendientes = $conexion->prepare("SELECT d.estado_carrito, d.cantidad, p.nombre, p.precio, u.id_usuario, d.id_carrito, s.*
FROM tbl_carrito as d 
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = d.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Pendiente' AND s.id_stock = d.id_stock");
$pendientes->bindParam(":id_usuario", $id_usuario);
$pendientes->execute();
$lista_compras_pendientes = $pendientes->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS EN PROCESO
$proceso = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'En proceso'");
$proceso->bindParam(":id_usuario", $id_usuario);
$proceso->execute();
$lista_compras_proceso = $proceso->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS EN APROBADAS
$Aprobadas = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Aprobado'");
$Aprobadas->bindParam(":id_usuario", $id_usuario);
$Aprobadas->execute();
$lista_compras_aprobadas = $Aprobadas->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS EN ESPERA DE ENVIO
$espera_envio = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'En espera de envío'");
$espera_envio->bindParam(":id_usuario", $id_usuario);
$espera_envio->execute();
$lista_compras_espera_envio = $espera_envio->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS EN TRANSITO
$en_transito = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'En tránsito'");
$en_transito->bindParam(":id_usuario", $id_usuario);
$en_transito->execute();
$lista_compras_en_transito = $en_transito->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS ENTREGADO
$entregado = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Entregado'");
$entregado->bindParam(":id_usuario", $id_usuario);
$entregado->execute();
$lista_compras_entregado = $entregado->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS COMPLETADO
$completado = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Completado'");
$completado->bindParam(":id_usuario", $id_usuario);
$completado->execute();
$lista_compras_completado = $completado->fetchAll(PDO::FETCH_ASSOC);

// CONSULTA DE TODAS LAS COMPRAS CANCELADAS
$canceladas = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Cancelado'");
$canceladas->bindParam(":id_usuario", $id_usuario);
$canceladas->execute();
$lista_compras_canceladas = $canceladas->fetchAll(PDO::FETCH_ASSOC);

$info_u = $conexion->prepare("SELECT * FROM tbl_vendedor WHERE id_usuario =:id_usuario");
$info_u->bindParam(":id_usuario", $id_usuario);
$info_u->execute();
$informacion = $info_u->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); 

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

<?php

if (isset($_GET['c'])) {
    $c = (isset($_GET['c'])) ? $_GET['c'] : "";

    switch ($c) {
        case 'pendientes':
?>
            <div class="container_compras">
                <p class="titulo_desc">Estado pendiente:</p>
                <!-- <p class="descripcion_estado">Este estado de compra indica que la compra ha sido iniciada pero aún no se ha completado. Puede significar que el cliente ha agregado productos al carrito pero no ha finalizado el proceso de pago.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_pendientes" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras pendientes</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_pendientes">
                    <thead>
                        <tr>
                            <th class="primer_th">Nombre</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Id usuario</th>
                            <th>Color</th>
                            <th class="ultimo_th">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lista_compras_pendientes)) { ?>
                            <tr>
                                <td colspan="7">No hay productos pendientes.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_pendientes as $pe) { ?>
                                <tr>
                                    <td><?php echo $pe['nombre'] ?></td>
                                    <td><?php echo $pe['estado_carrito'] ?></td>
                                    <td><?php echo $pe['cantidad'] ?></td>
                                    <td>$<?php echo number_format($pe['precio'], 0, '.', ','); ?></td>
                                    <td><?php echo $pe['id_usuario'] ?></td>
                                    <td>
                                        <span class="color-option" style="background-color: <?php echo $pe['color_producto'] ?>;"></span>
                                    </td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaComprasPend(<?php echo $pe['id_carrito']; ?>)">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'en_proceso':
        ?>
            <div class="container_compras">
                <p class="titulo_desc">Estado en proceso:</p>
                <!-- <p class="descripcion_estado">Una vez que el cliente ha realizado el pago, la compra pasa al estado "En proceso". Esto indica que la transacción está siendo verificada y procesada. Puede involucrar la confirmación del pago, la verificación de la disponibilidad de los productos, etc.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_en_proceso" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras en proceso</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_en_proceso">
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
                        <?php if (empty($lista_compras_proceso)) { ?>
                            <tr>
                                <td colspan="9">No hay productos en proceso.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_proceso as $pr) { ?>
                                <tr>
                                    <td><?php echo $pr['id_compra'] ?></td>
                                    <td>$<?php echo number_format($pr['total_compra'], 0, '.', ','); ?></td>
                                    <td>$<?php echo number_format($pr['costo_envio'], 0, '.', ','); ?></td>
                                    <td><?php echo $pr['usuario'] ?></td>
                                    <td><?php echo $pr['id_usuario'] ?></td>
                                    <td><?php echo $pr['correo'] ?></td>
                                    <td><?php echo $pr['metodo_pago'] ?></td>
                                    <td><?php echo $pr['fecha_compra'] ?></td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaCompras(<?php echo $pr['id_compra']; ?>)" data-tooltip="Ver compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                            <a onclick="cargarVistaRapidaEditarP(<?php echo $pr['id_compra']; ?>)" data-tooltip="Editar estado">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-edit'></i>
                                                </div>
                                            </a>
                                            <a onclick="eliminarCompra(<?php echo $pr['id_compra']; ?>)" data-tooltip="Cancelar compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-x-circle'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'aprobado';
        ?>
            <div class="container_compras">
                <p class="titulo_desc">Estado aprobado:</p>
                <!-- <p class="descripcion_estado">La compra ha sido aprobada y aceptada. Esto significa que se ha completado con éxito el proceso de pago y que los productos o servicios están listos para ser entregados o utilizados.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_aprobados" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras aprobadas</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_aprobados">
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
                        <?php if (empty($lista_compras_aprobadas)) { ?>
                            <tr>
                                <td colspan="9">No hay productos aprobados.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_aprobadas as $ap) { ?>
                                <tr>
                                    <td><?php echo $ap['id_compra'] ?></td>
                                    <td>$<?php echo number_format($ap['total_compra'], 0, '.', ','); ?></td>
                                    <td>$<?php echo number_format($ap['costo_envio'], 0, '.', ','); ?></td>
                                    <td><?php echo $ap['usuario'] ?></td>
                                    <td><?php echo $ap['id_usuario'] ?></td>
                                    <td><?php echo $ap['correo'] ?></td>
                                    <td><?php echo $ap['metodo_pago'] ?></td>
                                    <td><?php echo $ap['fecha_compra'] ?></td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaCompras(<?php echo $ap['id_compra']; ?>)" data-tooltip="Ver compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                            <a onclick="cargarVistaRapidaEditarA(<?php echo $ap['id_compra']; ?>)" data-tooltip="Editar estado">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-edit'></i>
                                                </div>
                                            </a>
                                            <a onclick="eliminarCompra(<?php echo $ap['id_compra']; ?>)" data-tooltip="Cancelar compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-x-circle'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'espera_envio':
        ?>
            <div class="container_compras">
                <p class="titulo_desc">Estado en espera de envío:</p>
                <!-- <p class="descripcion_estado"> En el caso de productos físicos, una vez que la compra ha sido aprobada, puede entrar en el estado "En espera de envío". Esto indica que los productos están listos para ser enviados, pero aún no han salido del almacén o no se ha generado la etiqueta de envío.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_espera_envio" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras en espera de envío</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_espera_envio">
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
                        <?php if (empty($lista_compras_espera_envio)) { ?>
                            <tr>
                                <td colspan="9">No hay productos en espera de envío.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_espera_envio as $ep) { ?>
                                <tr>
                                    <td><?php echo $ep['id_compra'] ?></td>
                                    <td>$<?php echo number_format($ep['total_compra'], 0, '.', ','); ?></td>
                                    <td>$<?php echo number_format($ep['costo_envio'], 0, '.', ','); ?></td>
                                    <td><?php echo $ep['usuario'] ?></td>
                                    <td><?php echo $ep['id_usuario'] ?></td>
                                    <td><?php echo $ep['correo'] ?></td>
                                    <td><?php echo $ep['metodo_pago'] ?></td>
                                    <td><?php echo $ep['fecha_compra'] ?></td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaCompras(<?php echo $ep['id_compra']; ?>)" data-tooltip="Ver compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                            <a onclick="cargarVistaRapidaEditarEsp(<?php echo $ep['id_compra']; ?>)" data-tooltip="Editar estado">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-edit'></i>
                                                </div>
                                            </a>
                                            <a onclick="eliminarCompra(<?php echo $ep['id_compra']; ?>)" data-tooltip="Cancelar compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-x-circle'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'en_transito':
        ?>
            <div class="container_compras">
                <p class="titulo_desc">En tránsito:</p>
                <!-- <p class="descripcion_estado"> Los productos han sido enviados y se encuentran en camino hacia la dirección de entrega proporcionada por el cliente.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_en_transito" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras en tránsito</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_en_transito">
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
                        <?php if (empty($lista_compras_en_transito)) { ?>
                            <tr>
                                <td colspan="9">No hay productos en tránsito.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_en_transito as $et) { ?>
                                <tr>
                                    <td><?php echo $et['id_compra'] ?></td>
                                    <td>$<?php echo number_format($et['total_compra'], 0, '.', ','); ?></td>
                                    <td>$<?php echo number_format($et['costo_envio'], 0, '.', ','); ?></td>
                                    <td><?php echo $et['usuario'] ?></td>
                                    <td><?php echo $et['id_usuario'] ?></td>
                                    <td><?php echo $et['correo'] ?></td>
                                    <td><?php echo $et['metodo_pago'] ?></td>
                                    <td><?php echo $et['fecha_compra'] ?></td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaCompras(<?php echo $et['id_compra']; ?>)" data-tooltip="Ver compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                            <a onclick="cargarVistaRapidaEditarEts(<?php echo $et['id_compra']; ?>)" data-tooltip="Editar estado">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-edit'></i>
                                                </div>
                                            </a>
                                            <a onclick="eliminarCompra(<?php echo $et['id_compra']; ?>)" data-tooltip="Cancelar compra">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-x-circle'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'completado';
        ?>
            <div class="container_compras">
                <p class="titulo_desc">Completado:</p>
                <!-- <p class="descripcion_estado"> Este estado indica que todo el proceso de la compra ha finalizado con éxito. Los productos o servicios han sido entregados y se considera que la transacción está cerrada.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_completado" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras completadas</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_completado">
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
                        <?php if (empty($lista_compras_completado)) { ?>
                            <tr>
                                <td colspan="9">No hay productos completados.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_completado as $en) { ?>
                                <tr>
                                    <td><?php echo $en['id_compra'] ?></td>
                                    <td>$<?php echo number_format($en['total_compra'], 0, '.', ','); ?></td>
                                    <td>$<?php echo number_format($en['costo_envio'], 0, '.', ','); ?></td>
                                    <td><?php echo $en['usuario'] ?></td>
                                    <td><?php echo $en['id_usuario'] ?></td>
                                    <td><?php echo $en['correo'] ?></td>
                                    <td><?php echo $en['metodo_pago'] ?></td>
                                    <td><?php echo $en['fecha_compra'] ?></td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaCompras(<?php echo $en['id_compra']; ?>)">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
            break;
        case 'cancelado';
        ?>
            <div class="container_compras">
                <p class="titulo_desc">Cancelado:</p>
                <!-- <p class="descripcion_estado"> En algunos casos, una compra puede ser cancelada, ya sea por el cliente antes de su envío o por el vendedor debido a problemas como falta de stock, problemas de pago, etc.</p> -->
                <div class="cabecera_principal">
                    <div class="logo_img">
                        <img src="../../img/logo.png" alt="">
                        <p>Paykind</p>
                    </div>
                    <div class="mas_info">
                        <input placeholder="Buscar.." class="input_compras" id="search_input_cancelado" name="q" type="text">
                    </div>
                </div>

                <h2 class="titulo_registro_c">Registro de compras canceladas</h2>

                <div class="opciones">
                    <a href="info_compras_clientes.php?c=pendientes">
                        <div class="botones_sc">
                            <p>Pendientes</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_proceso">
                        <div class="botones_sc">
                            <p>En proceso</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=aprobado">
                        <div class="botones_sc">
                            <p>Aprobados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=espera_envio">
                        <div class="botones_sc">
                            <p>En espera de envío</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=en_transito">
                        <div class="botones_sc">
                            <p>En tránsito</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=completado">
                        <div class="botones_sc">
                            <p>Completados</p>
                        </div>
                    </a>
                    <a href="info_compras_clientes.php?c=cancelado">
                        <div class="botones_sc">
                            <p>Cancelados</p>
                        </div>
                    </a>
                </div>

                <table id="tabla_compras_cancelado">
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
                        <?php if (empty($lista_compras_canceladas)) { ?>
                            <tr>
                                <td colspan="9">No hay productos cancelados.</td>
                            </tr>
                            <?php } else {
                            foreach ($lista_compras_canceladas as $ca) { ?>
                                <tr>
                                    <td><?php echo $ca['id_compra'] ?></td>
                                    <td>$<?php echo number_format($ca['total_compra'], 0, '.', ','); ?></td>
                                    <td>$<?php echo number_format($ca['costo_envio'], 0, '.', ','); ?></td>
                                    <td><?php echo $ca['usuario'] ?></td>
                                    <td><?php echo $ca['id_usuario'] ?></td>
                                    <td><?php echo $ca['correo'] ?></td>
                                    <td><?php echo $ca['metodo_pago'] ?></td>
                                    <td><?php echo $ca['fecha_compra'] ?></td>
                                    <td>
                                        <div class="opciones_comp">
                                            <a onclick="cargarVistaRapidaCompras(<?php echo $ca['id_compra']; ?>)">
                                                <div class="ver_compra_lupa">
                                                    <i class='bx bx-search-alt-2'></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
<?php
            break;
        default:
            echo "No se ha especificado un tipo de compra.";
            break;
    }
} else {
    echo "Error.";
}

?>

<script src="../../js/jquery-3.7.1.min.js"></script>
<script src="archivos.js/custom-tooltip.js"></script>
<script src="archivos.js/modal_compras.js"></script>
<script src="archivos.js/modal_compras_editar.js"></script>
<script src="archivos.js/eliminar_compra.js"></script>
<script src="archivos.js/resaltar_boton.js"></script>
<script src="archivos.js/buscador_compras_estados.js"></script>
<script src="archivos.js/alerta_estado.js"></script>