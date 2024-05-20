<?php
session_start();

include("../../bd.php");
require '../../config.php';
require_once '../../descargar_pdf/TCPDF-main/tcpdf.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente" && $_SESSION["usuario_rol"] === "Vendedor") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['P'])) {
    $P = (isset($_GET['P'])) ? $_GET['P'] : "";

    switch ($P) {
        case 'Ventas':
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre del Autor');
            $pdf->SetTitle('Reporte de Compras');
            $pdf->SetSubject('Asunto del PDF');
            $pdf->SetKeywords('TCPDF, PDF, ejemplo, demo');

            $pdf->SetMargins(10, 10, 10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetFont('times', '', 12);
            $pdf->AddPage();

            // Título
            $pdf->SetFont('times', 'B', 16);
            $pdf->Cell(0, 10, 'Informe de Compras', 0, 1, 'C');
            $pdf->Ln(10); // Añadir espacio después del título

            // Descripción
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell(0, 10, 'Este informe contiene detalles sobre las compras realizadas y la información personal del cliente comprador.', 0, 'L');
            $pdf->Ln(10); // Añadir espacio después de la descripción

            $data = $conexion->prepare("SELECT * FROM tbl_venta");
            $data->execute();
            $compras_data = $data->fetchAll(PDO::FETCH_ASSOC);

            $header = array('Campos', 'Información');
            $pdf->SetFont('times', 'B', 12);
            $pdf->SetFillColor(200, 220, 255);

            foreach ($header as $col) {
                $pdf->Cell(95, 10, $col, 1, 0, 'C', 1);
            }

            $pdf->Ln();

            $pdf->SetFont('times', '', 12);
            foreach ($compras_data as $row) {
                $pdf->Cell(95, 10, 'Id venta:', 1);
                $pdf->Cell(95, 10, $row['id_venta'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombres:', 1);
                $pdf->Cell(95, 10, $row['nombres_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Apellidos:', 1);
                $pdf->Cell(95, 10, $row['apellidos_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Identificación:', 1);
                $pdf->Cell(95, 10, $row['id_usuario'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Correo:', 1);
                $pdf->Cell(95, 10, $row['correo'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Dirección:', 1);
                $pdf->Cell(95, 10, $row['direccion'], 1);
                $pdf->Ln();

                $totalCompraFormateado = number_format($row['total_compra'], 0, '.', ',');

                $pdf->Cell(95, 10, 'Total compra:', 1);
                $pdf->Cell(95, 10, '$' . $totalCompraFormateado, 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Metodo pago:', 1);
                $pdf->Cell(95, 10, $row['metodo_pago'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Estado de la compra:', 1);
                $pdf->Cell(95, 10, $row['estado'], 1);
                $pdf->Ln();

                $CostoFormateado = number_format($row['costo_envio'], 0, '.', ',');

                $pdf->Cell(95, 10, 'Costo envío:', 1);
                $pdf->Cell(95, 10, '$' . $CostoFormateado, 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Fecha compra:', 1);
                $pdf->Cell(95, 10, $row['fecha_compra'], 1);
                $pdf->Ln();

                $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
                $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 80, $pdf->GetY());

                $pdf->Ln();
            }

            $pdf->Output('Reporte_ventas.pdf', 'D');
            break;
        case 'Inventario':
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre del Autor');
            $pdf->SetTitle('Reporte de Compras');
            $pdf->SetSubject('Asunto del PDF');
            $pdf->SetKeywords('TCPDF, PDF, ejemplo, demo');

            $pdf->SetMargins(10, 10, 10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetFont('times', '', 12);
            $pdf->AddPage();

            // Título
            $pdf->SetFont('times', 'B', 16);
            $pdf->Cell(0, 10, 'Informe del inventario', 0, 1, 'C');
            $pdf->Ln(10); // Añadir espacio después del título

            // Descripción
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell(0, 10, 'Este informe contiene detalles sobre el inventario de cada tienda que hay registrada.', 0, 'L');
            $pdf->Ln(10); // Añadir espacio después de la descripción

            $data = $conexion->prepare("SELECT p.*, s.*, t.nombre_tienda,t.nit_identificacion
            FROM tbl_productos as p 
            INNER JOIN tbl_stock as s ON s.id_producto = p.id_producto
            INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion");
            $data->execute();
            $compras_data = $data->fetchAll(PDO::FETCH_ASSOC);

            $header = array('Campos', 'Información');
            $pdf->SetFont('times', 'B', 12);
            $pdf->SetFillColor(200, 220, 255);

            foreach ($header as $col) {
                $pdf->Cell(95, 10, $col, 1, 0, 'C', 1);
            }

            $pdf->Ln();

            $pdf->SetFont('times', '', 12);
            foreach ($compras_data as $row) {
                $pdf->Cell(95, 10, 'Id producto:', 1);
                $pdf->Cell(95, 10, $row['id_producto'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombre:', 1);
                $pdf->Cell(95, 10, $row['nombre'], 1);
                $pdf->Ln();

                $PrecioProductoFormateado = number_format($row['precio'], 0, '.', ',');

                $pdf->Cell(95, 10, 'Precio:', 1);
                $pdf->Cell(95, 10, '$' . $PrecioProductoFormateado, 1);
                $pdf->Ln();


                $pdf->Cell(95, 10, 'Nit tienda:', 1);
                $pdf->Cell(95, 10, $row['nit_identificacion'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombre tienda:', 1);
                $pdf->Cell(95, 10, $row['nombre_tienda'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Estado producto:', 1);
                $pdf->Cell(95, 10, $row['estado_producto'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Cantidad:', 1);
                $pdf->Cell(95, 10, $row['cantidad_disponible'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Color:', 1);
                $pdf->Cell(95, 10, $row['color_producto'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Fecha registro:', 1);
                $pdf->Cell(95, 10, $row['fecha_registro'], 1);
                $pdf->Ln();

                $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
                $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 80, $pdf->GetY());

                $pdf->Ln();
            }

            $pdf->Output('Reporte_inventario.pdf', 'D');
            break;
        case 'Clientes':
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre del Autor');
            $pdf->SetTitle('Reporte de Compras');
            $pdf->SetSubject('Asunto del PDF');
            $pdf->SetKeywords('TCPDF, PDF, ejemplo, demo');

            $pdf->SetMargins(10, 10, 10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetFont('times', '', 12);
            $pdf->AddPage();

            // Título
            $pdf->SetFont('times', 'B', 16);
            $pdf->Cell(0, 10, 'Informe de los Clientes', 0, 1, 'C');
            $pdf->Ln(10); // Añadir espacio después del título

            // Descripción
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell(0, 10, 'Este informe contiene detalles sobre los usuarios clientes que se encuentran registrados.', 0, 'L');
            $pdf->Ln(10); // Añadir espacio después de la descripción

            $data = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_rol = 'Cliente'");
            $data->execute();
            $compras_data = $data->fetchAll(PDO::FETCH_ASSOC);

            $header = array('Campos', 'Información');
            $pdf->SetFont('times', 'B', 12);
            $pdf->SetFillColor(200, 220, 255);

            foreach ($header as $col) {
                $pdf->Cell(95, 10, $col, 1, 0, 'C', 1);
            }

            $pdf->Ln();

            $pdf->SetFont('times', '', 12);
            foreach ($compras_data as $row) {
                $pdf->Cell(95, 10, 'Identificación:', 1);
                $pdf->Cell(95, 10, $row['id_usuario'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Usuario:', 1);
                $pdf->Cell(95, 10, $row['usuario'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Tipo documento:', 1);
                $pdf->Cell(95, 10, $row['tipo_documento_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombres:', 1);
                $pdf->Cell(95, 10, $row['nombres_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Apellidos:', 1);
                $pdf->Cell(95, 10, $row['apellidos_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Correo:', 1);
                $pdf->Cell(95, 10, $row['correo'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Celular:', 1);
                $pdf->Cell(95, 10, $row['celular'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Dirección', 1);
                $pdf->Cell(95, 10, $row['direccion'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Rol', 1);
                $pdf->Cell(95, 10, $row['id_rol'], 1);
                $pdf->Ln();

                $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
                $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 80, $pdf->GetY());

                $pdf->Ln();
            }

            $pdf->Output('Reporte_clientes.pdf', 'D');
            break;
        case 'Vendedores':
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre del Autor');
            $pdf->SetTitle('Reporte de Compras');
            $pdf->SetSubject('Asunto del PDF');
            $pdf->SetKeywords('TCPDF, PDF, ejemplo, demo');

            $pdf->SetMargins(10, 10, 10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetFont('times', '', 12);
            $pdf->AddPage();

            // Título
            $pdf->SetFont('times', 'B', 16);
            $pdf->Cell(0, 10, 'Informe de los Vendedores', 0, 1, 'C');
            $pdf->Ln(10); // Añadir espacio después del título

            // Descripción
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell(0, 10, 'Este informe contiene detalles sobre los usuarios vendedores que se encuentran registrados.', 0, 'L');
            $pdf->Ln(10); // Añadir espacio después de la descripción

            $data = $conexion->prepare("SELECT * FROM tbl_vendedor WHERE id_rol = 'Vendedor'");
            $data->execute();
            $compras_data = $data->fetchAll(PDO::FETCH_ASSOC);

            $header = array('Campos', 'Información');
            $pdf->SetFont('times', 'B', 12);
            $pdf->SetFillColor(200, 220, 255);

            foreach ($header as $col) {
                $pdf->Cell(95, 10, $col, 1, 0, 'C', 1);
            }

            $pdf->Ln();

            $pdf->SetFont('times', '', 12);
            foreach ($compras_data as $row) {
                $pdf->Cell(95, 10, 'Identificación:', 1);
                $pdf->Cell(95, 10, $row['id_usuario'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Usuario:', 1);
                $pdf->Cell(95, 10, $row['usuario'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Tipo documento:', 1);
                $pdf->Cell(95, 10, $row['tipo_documento_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombres:', 1);
                $pdf->Cell(95, 10, $row['nombres_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Apellidos:', 1);
                $pdf->Cell(95, 10, $row['apellidos_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Correo:', 1);
                $pdf->Cell(95, 10, $row['correo'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Celular:', 1);
                $pdf->Cell(95, 10, $row['celular'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Dirección', 1);
                $pdf->Cell(95, 10, $row['direccion'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Rol', 1);
                $pdf->Cell(95, 10, $row['id_rol'], 1);
                $pdf->Ln();

                $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
                $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 80, $pdf->GetY());

                $pdf->Ln();
            }

            $pdf->Output('Reporte_vendedores.pdf', 'D');
            break;
        case 'Tiendas':
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre del Autor');
            $pdf->SetTitle('Reporte de Compras');
            $pdf->SetSubject('Asunto del PDF');
            $pdf->SetKeywords('TCPDF, PDF, ejemplo, demo');

            $pdf->SetMargins(10, 10, 10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetFont('times', '', 12);
            $pdf->AddPage();

            // Título
            $pdf->SetFont('times', 'B', 16);
            $pdf->Cell(0, 10, 'Informe de las tiendas', 0, 1, 'C');
            $pdf->Ln(10); // Añadir espacio después del título

            // Descripción
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell(0, 10, 'Este informe contiene detalles sobre las tiendas y los vendedores que la registraron.', 0, 'L');
            $pdf->Ln(10); // Añadir espacio después de la descripción

            $data = $conexion->prepare("SELECT t.*, v.nombres_u, v.apellidos_u, v.correo
            FROM tbl_tienda as t 
            INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario");
            $data->execute();
            $compras_data = $data->fetchAll(PDO::FETCH_ASSOC);

            $header = array('Campos', 'Información');
            $pdf->SetFont('times', 'B', 12);
            $pdf->SetFillColor(200, 220, 255);

            foreach ($header as $col) {
                $pdf->Cell(95, 10, $col, 1, 0, 'C', 1);
            }

            $pdf->Ln();

            $pdf->SetFont('times', '', 12);
            foreach ($compras_data as $row) {
                $pdf->Cell(95, 10, 'Identificación:', 1);
                $pdf->Cell(95, 10, $row['id_usuario'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombres:', 1);
                $pdf->Cell(95, 10, $row['nombres_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Apellidos:', 1);
                $pdf->Cell(95, 10, $row['apellidos_u'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Correo:', 1);
                $pdf->Cell(95, 10, $row['correo'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nit tienda:', 1);
                $pdf->Cell(95, 10, $row['nit_identificacion'], 1);
                $pdf->Ln();

                $pdf->Cell(95, 10, 'Nombre tienda:', 1);
                $pdf->Cell(95, 10, $row['nombre_tienda'], 1);
                $pdf->Ln();

                $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
                $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 80, $pdf->GetY());

                $pdf->Ln();
            }

            $pdf->Output('Reporte_tiendas.pdf', 'D');
            break;
        default:
            break;
    }
}
