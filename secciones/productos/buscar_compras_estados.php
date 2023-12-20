<?php

session_start();

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['c'])) {
    $estado_carrito = $_GET['c'];
}

if (isset($_POST['query'])) {
    $search = $_POST['query'];
}

switch ($estado_carrito) {
    case 'pendientes':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT d.estado_carrito, d.cantidad, p.nombre, p.precio, u.id_usuario, d.*, s.*
        FROM tbl_carrito as d 
        INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
        INNER JOIN tbl_usuario as u ON u.id_usuario = d.id_usuario
        INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
        INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
        INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
        WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'Pendiente' AND s.id_stock = d.id_stock 
        AND (p.nombre LIKE :search OR d.estado_carrito LIKE :search OR d.cantidad LIKE :search OR p.precio LIKE :search OR u.id_usuario LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach
            foreach ($resultados as $pe) {
                $rows .= '<tr>
                <td>' . $pe['nombre'] . '</td>
                <td>' . $pe['estado_carrito'] . '</td>
                <td>' . $pe['cantidad'] . '</td>
                <td>$' . number_format($pe['precio'], 0, '.', ',') . '</td>
                <td>' . $pe['id_usuario'] . '</td>
                <td>
                    <span class="color-option" style="background-color: ' . $pe['color_producto'] . ';"></span>
                </td>
                <td>
                    <div class="opciones_comp">
                        <a onclick="cargarVistaRapidaComprasPend(' . $pe['id_carrito'] . ')">
                            <div class="ver_compra_lupa">
                                <i class=\'bx bx-search-alt-2\'></i>
                            </div>
                        </a>
                    </div>
                </td>
            </tr>';
            }
        } else {
            $rows = '<tr><td colspan="7">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    case 'en_proceso':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
        FROM tbl_compra as c
        INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
        INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
        INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
        INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
        INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
        INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
        WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'En proceso' 
        AND (c.id_compra LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR u.id_usuario LIKE :search OR c.fecha_compra LIKE :search OR c.metodo_pago LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach
            foreach ($resultados as $pr) {
                $rows .= '<tr>
                    <td>' . $pr['id_compra'] . '</td>
                    <td>$' . number_format($pr['total_compra'], 0, '.', ',') . '</td>
                    <td>$' . number_format($pr['costo_envio'], 0, '.', ',') . '</td>
                    <td>' . $pr['usuario'] . '</td>
                    <td>' . $pr['id_usuario'] . '</td>
                    <td>' . $pr['correo'] . '</td>
                    <td>' . $pr['metodo_pago'] . '</td>
                    <td>' . $pr['fecha_compra'] . '</td>
                    <td>
                        <div class="opciones_comp">
                            <a onclick="cargarVistaRapidaCompras(' . $pr['id_compra'] . ')" data-tooltip="Ver compra">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-search-alt-2\'></i>
                                </div>
                            </a>
                            <a onclick="cargarVistaRapidaEditarP(' . $pr['id_compra'] . ')" data-tooltip="Editar estado">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-edit\'></i>
                                </div>
                            </a>
                            <a onclick="eliminarCompra(' . $pr['id_compra'] . ')" data-tooltip="Cancelar compra">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-x-circle\'></i>
                                </div>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            $rows = '<tr><td colspan="9">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    case 'aprobados':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
        FROM tbl_compra as c
        INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
        INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
        INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
        INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
        INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
        INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
        WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'Aprobado'
        AND (c.id_compra LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR u.id_usuario LIKE :search OR c.fecha_compra LIKE :search OR c.metodo_pago LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach

            foreach ($resultados as $ap) {
                $rows .= '<tr>
                    <td>' . $ap['id_compra'] . '</td>
                    <td>$' . number_format($ap['total_compra'], 0, '.', ',') . '</td>
                    <td>$' . number_format($ap['costo_envio'], 0, '.', ',') . '</td>
                    <td>' . $ap['usuario'] . '</td>
                    <td>' . $ap['id_usuario'] . '</td>
                    <td>' . $ap['correo'] . '</td>
                    <td>' . $ap['metodo_pago'] . '</td>
                    <td>' . $ap['fecha_compra'] . '</td>
                    <td>
                        <div class="opciones_comp">
                            <a onclick="cargarVistaRapidaCompras(' . $ap['id_compra'] . ')" data-tooltip="Ver compra">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-search-alt-2\'></i>
                                </div>
                            </a>
                            <a onclick="cargarVistaRapidaEditarA(' . $ap['id_compra'] . ')" data-tooltip="Editar estado">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-edit\'></i>
                                </div>
                            </a>
                            <a onclick="eliminarCompra(' . $ap['id_compra'] . ')" data-tooltip="Cancelar compra">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-x-circle\'></i>
                                </div>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            $rows = '<tr><td colspan="9">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    case 'espera_envio':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
            FROM tbl_compra as c
            INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
            INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
            INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
            INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
            INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
            INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
            WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'En espera de envío'
            AND (c.id_compra LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR u.id_usuario LIKE :search OR c.fecha_compra LIKE :search OR c.metodo_pago LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach

            foreach ($resultados as $ep) {
                $rows .= '<tr>
                        <td>' . $ep['id_compra'] . '</td>
                        <td>$' . number_format($ep['total_compra'], 0, '.', ',') . '</td>
                        <td>$' . number_format($ep['costo_envio'], 0, '.', ',') . '</td>
                        <td>' . $ep['usuario'] . '</td>
                        <td>' . $ep['id_usuario'] . '</td>
                        <td>' . $ep['correo'] . '</td>
                        <td>' . $ep['metodo_pago'] . '</td>
                        <td>' . $ep['fecha_compra'] . '</td>
                        <td>
                            <div class="opciones_comp">
                                <a onclick="cargarVistaRapidaCompras(' . $ep['id_compra'] . ')" data-tooltip="Ver compra">
                                    <div class="ver_compra_lupa">
                                        <i class=\'bx bx-search-alt-2\'></i>
                                    </div>
                                </a>
                                <a onclick="cargarVistaRapidaEditarEsp(' . $ep['id_compra'] . ')" data-tooltip="Editar estado">
                                    <div class="ver_compra_lupa">
                                        <i class=\'bx bx-edit\'></i>
                                    </div>
                                </a>
                                <a onclick="eliminarCompra(' . $ep['id_compra'] . ')" data-tooltip="Cancelar compra">
                                    <div class="ver_compra_lupa">
                                        <i class=\'bx bx-x-circle\'></i>
                                    </div>
                                </a>
                            </div>
                        </td>
                    </tr>';
            }
        } else {
            $rows = '<tr><td colspan="8">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    case 'en_transito':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
                FROM tbl_compra as c
                INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
                INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
                INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
                INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
                INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
                INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
                WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'En tránsito'
                AND (c.id_compra LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR u.id_usuario LIKE :search OR c.fecha_compra LIKE :search OR c.metodo_pago LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach

            foreach ($resultados as $et) {
                $rows .= '<tr>
                            <td>' . $et['id_compra'] . '</td>
                            <td>$' . number_format($et['total_compra'], 0, '.', ',') . '</td>
                            <td>$' . number_format($et['costo_envio'], 0, '.', ',') . '</td>
                            <td>' . $et['usuario'] . '</td>
                            <td>' . $et['id_usuario'] . '</td>
                            <td>' . $et['correo'] . '</td>
                            <td>' . $et['metodo_pago'] . '</td>
                            <td>' . $et['fecha_compra'] . '</td>
                            <td>
                                <div class="opciones_comp">
                                    <a onclick="cargarVistaRapidaCompras(' . $et['id_compra'] . ')" data-tooltip="Ver compra">
                                        <div class="ver_compra_lupa">
                                            <i class=\'bx bx-search-alt-2\'></i>
                                        </div>
                                    </a>
                                    <a onclick="cargarVistaRapidaEditarEts(' . $et['id_compra'] . ')" data-tooltip="Editar estado">
                                        <div class="ver_compra_lupa">
                                            <i class=\'bx bx-edit\'></i>
                                        </div>
                                    </a>
                                    <a onclick="eliminarCompra(' . $et['id_compra'] . ')" data-tooltip="Cancelar compra">
                                        <div class="ver_compra_lupa">
                                            <i class=\'bx bx-x-circle\'></i>
                                        </div>
                                    </a>
                                </div>
                            </td>
                        </tr>';
            }
        } else {
            $rows = '<tr><td colspan="9">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    case 'completado':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
                        FROM tbl_compra as c
                        INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
                        INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
                        INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
                        INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
                        INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
                        INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
                        WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'Completado'
                        AND (c.id_compra LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR u.id_usuario LIKE :search OR c.fecha_compra LIKE :search OR c.metodo_pago LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach

            foreach ($resultados as $en) {
                $rows .= '<tr>
                            <td>' . $en['id_compra'] . '</td>
                            <td>$' . number_format($en['total_compra'], 0, '.', ',') . '</td>
                            <td>$' . number_format($en['costo_envio'], 0, '.', ',') . '</td>
                            <td>' . $en['usuario'] . '</td>
                            <td>' . $en['id_usuario'] . '</td>
                            <td>' . $en['correo'] . '</td>
                            <td>' . $en['metodo_pago'] . '</td>
                            <td>' . $en['fecha_compra'] . '</td>
                            <td>
                                <div class="opciones_comp">
                                    <a onclick="cargarVistaRapidaCompras(' . $en['id_compra'] . ')">
                                        <div class="ver_compra_lupa">
                                            <i class=\'bx bx-search-alt-2\'></i>
                                        </div>
                                    </a>
                                </div>
                            </td>
                         </tr>';
            }
        } else {
            $rows = '<tr><td colspan="9">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    case 'cancelado':
        // Preparar la consulta parametrizada para realizar la búsqueda y filtrar por id_usuario
        $query = "SELECT DISTINCT c.*, u.id_usuario, u.usuario, u.correo
                    FROM tbl_compra as c
                    INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
                    INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
                    INNER JOIN tbl_usuario as u ON u.id_usuario = c.id_usuario
                    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
                    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
                    INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
                    WHERE v.id_usuario = :id_usuario AND d.estado_carrito = 'Cancelado'
                    AND (c.id_compra LIKE :search OR u.usuario LIKE :search OR u.correo LIKE :search OR u.id_usuario LIKE :search OR c.fecha_compra LIKE :search OR c.metodo_pago LIKE :search)";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rows = '';
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            $rows = ''; // Inicializa la variable $rows para concatenar filas en el bucle foreach

            foreach ($resultados as $ca) {
                $rows .= '<tr>
                    <td>' . $ca['id_compra'] . '</td>
                    <td>$' . number_format($ca['total_compra'], 0, '.', ',') . '</td>
                    <td>$' . number_format($ca['costo_envio'], 0, '.', ',') . '</td>
                    <td>' . $ca['usuario'] . '</td>
                    <td>' . $ca['id_usuario'] . '</td>
                    <td>' . $ca['correo'] . '</td>
                    <td>' . $ca['metodo_pago'] . '</td>
                    <td>' . $ca['fecha_compra'] . '</td>
                    <td>
                        <div class="opciones_comp">
                            <a onclick="cargarVistaRapidaCompras(' . $ca['id_compra'] . ')">
                                <div class="ver_compra_lupa">
                                    <i class=\'bx bx-search-alt-2\'></i>
                                </div>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            $rows = '<tr><td colspan="9">No se encontraron resultados</td></tr>';
        }

        echo $rows; // Devolver las filas encontradas o un mensaje de no resultados
        break;
    default:
        echo "No se ha recibido un parametro get.";
        break;
}
