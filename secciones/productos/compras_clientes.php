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

// CONSULTA DE TODAS LAS COMPRAS 
$compras_c = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
FROM tbl_compra as c 
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
WHERE v.id_usuario =:id_usuario;");
$compras_c->bindParam(":id_usuario", $id_usuario);
$compras_c->execute();
$lista_carrito = $compras_c->fetchAll(PDO::FETCH_ASSOC);

$info_u = $conexion->prepare("SELECT * FROM tbl_vendedor WHERE id_usuario =:id_usuario");
$info_u->bindParam(":id_usuario", $id_usuario);
$info_u->execute();
$informacion = $info_u->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

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

<div class="container_compras">
    <div class="cabecera_principal">
        <div class="logo_img">
            <img src="../../img/logo.png" alt="">
            <p>Paykind</p>
        </div>
        <div class="mas_info">
            <input placeholder="Buscar compras..." class="input_compras" id="search_input" name="q" type="text">
        </div>
    </div>
    <div class="cabecera">
        <div class="profile">
            <div class="imagen">
                <?php foreach ($informacion as $info) { ?>
                    <?php
                    if (!empty($info['fotoPerfil'])) { ?>
                        <img class="foto_perfil" src="../miperfil/imagenes_producto/<?php echo $info['fotoPerfil'] ?>" alt="">
                    <?php
                    } else { ?>
                        <img class="foto_perfil" src="../../imagen/Avatar-No-Background.png" alt="">
                <?php
                    }
                } ?>
            </div>
        </div>
        <div class="inputs">
            <div class="inputs">
                <?php foreach ($informacion as $info) { ?>
                    <input type="text" value="<?php echo $info['nombres_u'] ?>" class="non-editable">
            </div>
            <div class="inputs">
                <input type="text" value="<?php echo $info['apellidos_u'] ?>" class="non-editable">
            <?php
                } ?>
            </div>
        </div>
    </div>

    <hr>

    <h2 class="titulo_registro_c">Registro de compras</h2>

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

    <table id="tabla_compras">
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
            <?php if (empty($lista_carrito)) { ?>
                <tr>
                    <td colspan="9">No hay registros de compras.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($lista_carrito as $c) { ?>
                    <tr>
                        <td><?php echo $c['id_compra'] ?></td>
                        <td>$<?php echo number_format($c['total_compra'], 0, '.', ','); ?></td>
                        <td>$<?php echo number_format($c['costo_envio'], 0, '.', ','); ?></td>
                        <td><?php echo $c['usuario'] ?></td>
                        <td><?php echo $c['id_usuario'] ?></td>
                        <td><?php echo $c['correo'] ?></td>
                        <td><?php echo $c['metodo_pago'] ?></td>
                        <td><?php echo $c['fecha_compra'] ?></td>
                        <td>
                            <div class="opciones_comp">
                                <a onclick="cargarVistaRapidaCompras(<?php echo $c['id_compra']; ?>)">
                                    <div class="ver_compra_lupa">
                                        <i class='bx bx-search-alt-2'></i>
                                    </div>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <div id="paginacion"></div>
</div>

<script src="../../js/jquery-3.7.1.min.js"></script>
<script src="archivos.js/modal_compras.js"></script>
<script src="archivos.js/buscar_todas_compras.js"></script>
<script src="archivos.js/paginacion.js"></script>
<script src="archivos.js/ampliar_imagen.js"></script>