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

if (isset($_GET['type'])) {
    $reportType = $_GET['type'];

    switch ($reportType) {
        case 'Ventas':
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename= reporte_ventas.xls");

            $compras = $conexion->prepare("SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
            FROM tbl_compra as c 
            INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
            INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
            INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario;");
            $compras->execute();
            $compras_admin = $compras->fetchAll(PDO::FETCH_ASSOC);
?>
            <table>
                <thead>
                    <tr>
                        <th>Id compra</th>
                        <th>Total compra</th>
                        <th>Costo envio</th>
                        <th>Usuario</th>
                        <th>Id usuario</th>
                        <th>Correo usuario</th>
                        <th>Metodo pago</th>
                        <th>Fecha compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($compras_admin as $compras) { ?>
                        <tr>
                            <td><?php echo $compras['id_compra'] ?></td>
                            <td>$<?php echo number_format($compras['total_compra'], 2, '.', ','); ?></td>
                            <td>$<?php echo number_format($compras['costo_envio'], 2, '.', ','); ?></td>
                            <td><?php echo $compras['usuario'] ?></td>
                            <td><?php echo $compras['id_usuario'] ?></td>
                            <td><?php echo $compras['correo'] ?></td>
                            <td><?php echo $compras['metodo_pago'] ?></td>
                            <td><?php echo $compras['fecha_compra'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
            break;
        case 'Inventario':
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename= reporte_inventario.xls");

            $productos = $conexion->prepare("SELECT p.*, s.*, t.nombre_tienda,t.nit_identificacion
            FROM tbl_productos as p 
            INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
            INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion");
            $productos->execute();
            $productos_admin = $productos->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Id producto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Nit tienda</th>
                        <th>Tienda</th>
                        <th>Cantidad</th>
                        <th>Fecha registro</th>
                        <th>Color</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos_admin as $productos) { ?>
                        <tr>
                            <td><?php echo $productos['id_producto'] ?></td>
                            <td><?php echo $productos['nombre'] ?></td>
                            <td>$<?php echo number_format($productos['precio'], 0, '.', ','); ?></td>
                            <td><?php echo $productos['nit_identificacion'] ?></td>
                            <td><?php echo $productos['nombre_tienda'] ?></td>
                            <td><?php echo $productos['cantidad_disponible'] ?></td>
                            <td><?php echo $productos['fecha_registro'] ?></td>
                            <td>
                                <?php echo $productos['color_producto']; ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
            break;
        case 'Clientes':
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename= reporte_clientes.xls");

            $clientes = $conexion->prepare("SELECT b.nombre_barrio, c.nombre_comuna, m.nombre_municipio, u.* FROM tbl_usuario as u  
            INNER JOIN tbl_barrio as b ON u.barrio = b.id_barrio
            INNER JOIN tbl_comuna as c ON c.id_comuna = b.id_comuna
            INNER JOIN tbl_municipio as m ON m.id_municipio = c.id_municipio
            WHERE u.id_rol = 'Cliente';");
            $clientes->execute();
            $clientes_admin = $clientes->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <table>
                <thead>
                    <tr>
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
                        <th>Rol</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($clientes_admin as $clientes) { ?>
                        <tr>
                            <td>
                                <?php echo $clientes['id_usuario']; ?>
                            </td>
                            <td>
                                <?php echo $clientes['usuario']; ?>
                            </td>
                            <td><?php echo $clientes['tipo_documento_u'] ?></td>
                            <td>
                                <?php echo $clientes['nombres_u']; ?>
                            </td>
                            <td>
                                <?php echo $clientes['apellidos_u']; ?>
                            </td>
                            <td>
                                <?php echo $clientes['correo']; ?>
                            </td>
                            <td>
                                <?php echo $clientes['celular']; ?>
                            </td>
                            <td>
                                <?php echo $clientes['nombre_municipio'] ?>
                            </td>
                            <td>
                                <?php echo $clientes['nombre_comuna'] ?>
                            </td>
                            <td>
                                <?php echo $clientes['nombre_barrio'] ?>
                            </td>
                            <td>
                                <?php echo $clientes['direccion'] ?>
                            </td>
                            <td><?php echo $clientes['id_rol'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
            break;
        case 'Vendedores':
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename= reporte_vendedores.xls");

            $vendedores = $conexion->prepare("SELECT b.nombre_barrio, c.nombre_comuna, m.nombre_municipio, u.* FROM tbl_vendedor as u  
            INNER JOIN tbl_barrio as b ON u.barrio = b.id_barrio
            INNER JOIN tbl_comuna as c ON c.id_comuna = b.id_comuna
            INNER JOIN tbl_municipio as m ON m.id_municipio = c.id_municipio
            WHERE u.id_rol = 'Vendedor';");
            $vendedores->execute();
            $vendedores_admin = $vendedores->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <table>
                <thead>
                    <tr>
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
                        <th>Rol</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($vendedores_admin as $vendedores) { ?>
                        <tr>
                            <td>
                                <?php echo $vendedores['id_usuario']; ?>
                            </td>
                            <td>
                                <?php echo $vendedores['usuario']; ?>
                            </td>
                            <td><?php echo $vendedores['tipo_documento_u'] ?></td>
                            <td>
                                <?php echo $vendedores['nombres_u']; ?>
                            </td>
                            <td>
                                <?php echo $vendedores['apellidos_u']; ?>
                            </td>
                            <td>
                                <?php echo $vendedores['correo']; ?>
                            </td>
                            <td>
                                <?php echo $vendedores['celular']; ?>
                            </td>
                            <td>
                                <?php echo $vendedores['nombre_municipio'] ?>
                            </td>
                            <td>
                                <?php echo $vendedores['nombre_comuna'] ?>
                            </td>
                            <td>
                                <?php echo $vendedores['nombre_barrio'] ?>
                            </td>
                            <td>
                                <?php echo $vendedores['direccion'] ?>
                            </td>
                            <td><?php echo $vendedores['id_rol'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
            break;
        case 'Tiendas';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename= reporte_tiendas.xls");

            $tiendas = $conexion->prepare("SELECT t.*, v.nombres_u, v.apellidos_u, v.correo
            FROM tbl_tienda as t
            INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario");
            $tiendas->execute();
            $tiendas_admin = $tiendas->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Nit</th>
                        <th>Nombre</th>
                        <th>Id vendedor</th>
                        <th>Nombres vendedor</th>
                        <th>Apellidos vendedor</th>
                        <th>Correo vendedor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tiendas_admin as $tiendas) { ?>
                        <tr>
                            <td><?php echo $tiendas['nit_identificacion'] ?></td>
                            <td><?php echo $tiendas['nombre_tienda'] ?></td>
                            <td><?php echo $tiendas['id_usuario'] ?></td>
                            <td><?php echo $tiendas['nombres_u'] ?></td>
                            <td><?php echo $tiendas['apellidos_u'] ?></td>
                            <td><?php echo $tiendas['correo'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
<?php
            break;
        default:
            // Manejar un tipo de reporte desconocido
            break;
    }
}


?>