<?php
include("bd.php");

if (!defined('KEY_TOKEN')) {
    define('KEY_TOKEN', 'tu_valor_aqui');
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $id_usuario = $_SESSION['usuario_id'];
    $count = $conexion->prepare("SELECT COUNT(*) AS contador FROM tbl_carrito WHERE id_usuario =:id_usuario AND estado_carrito = 'Pendiente'");
    $count->bindParam(":id_usuario", $id_usuario);
    $count->execute();
    $contador = $count->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO PENDIENTE

    $conteo_pendientes = $conexion->prepare("SELECT COUNT(d.estado_carrito) as conteo_registros
    FROM tbl_compra_producto as d
    INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock as s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Pendiente';");
    $conteo_pendientes->bindParam(":id_usuario", $id_usuario);
    $conteo_pendientes->execute();
    $contador_compras_pdn = $conteo_pendientes->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO EN PROCESO

    $conteo_en_proceso = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'En proceso';");
    $conteo_en_proceso->bindParam(":id_usuario", $id_usuario);
    $conteo_en_proceso->execute();
    $contador_compras_enp = $conteo_en_proceso->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO APROBADO

    $conteo_aprobados = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Aprobado';");
    $conteo_aprobados->bindParam(":id_usuario", $id_usuario);
    $conteo_aprobados->execute();
    $contador_compras_apr = $conteo_aprobados->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO EN ESPERA DE ENVÍO

    $conteo_espera_envio = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'En espera de envío';");
    $conteo_espera_envio->bindParam(":id_usuario", $id_usuario);
    $conteo_espera_envio->execute();
    $contador_compras_esp = $conteo_espera_envio->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO EN TRÁNSITO

    $conteo_transito = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'En tránsito';");
    $conteo_transito->bindParam(":id_usuario", $id_usuario);
    $conteo_transito->execute();
    $contador_compras_trans = $conteo_transito->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO ENTREGADO

    $conteo_entregado = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Entregado';");
    $conteo_entregado->bindParam(":id_usuario", $id_usuario);
    $conteo_entregado->execute();
    $contador_compras_ent = $conteo_entregado->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO COMPLETADO

    $conteo_completado = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
    WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Completado';");
    $conteo_completado->bindParam(":id_usuario", $id_usuario);
    $conteo_completado->execute();
    $contador_compras_comp = $conteo_completado->fetchAll(PDO::FETCH_ASSOC);

    // CONSULTA PARA CONTAR LAS COMPRAS EN ESTADO CANCELADO

    $conteo_cancelados = $conexion->prepare("SELECT COUNT(DISTINCT d.id_compra) AS conteo_registros
    FROM tbl_compra AS c 
    INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
    INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
    INNER JOIN tbl_tienda AS t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor AS v ON v.id_usuario = t.id_usuario
    INNER JOIN tbl_stock AS s ON s.id_stock = d.id_stock
     WHERE v.id_usuario =:id_usuario AND d.estado_carrito = 'Cancelado';");
    $conteo_cancelados->bindParam(":id_usuario", $id_usuario);
    $conteo_cancelados->execute();
    $contador_compras_c = $conteo_cancelados->fetchAll(PDO::FETCH_ASSOC);
}
