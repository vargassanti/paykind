<?php
session_start();

include("../../bd.php");
require '../../config.php';
require_once '../../descargar_pdf/TCPDF-main/tcpdf.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['id_compra'])) {
    $id_compra = (isset($_GET['id_compra'])) ? $_GET['id_compra'] : "";
}

// Crear una instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('Nombre de tu empresa');
$pdf->SetAuthor('Nombre de tu empresa');
$pdf->SetTitle('Factura Paykind');
$pdf->SetSubject('Ejemplo de factura con TCPDF');
$pdf->SetKeywords('TCPDF, PDF, factura, ejemplo, PHP');

// Agregar una página
$pdf->AddPage();

// Configurar fuente y tamaño
$pdf->SetFont('helvetica', '', 12);

// Encabezado de la factura
$pdf->Cell(0, 10, 'Factura Paykind', 0, 1, 'C');
$pdf->Ln(5); // Salto de línea

// Detalles de la factura (datos ficticios)
$fecha = 'Fecha: ' . date('Y-m-d');

$stmt_cliente = $conexion->prepare("SELECT nombres_u, apellidos_u FROM tbl_usuario WHERE id_usuario = :id_usuario");
$stmt_cliente->bindParam(':id_usuario', $id_usuario);
$stmt_cliente->execute();
$cliente_info = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontró la información del cliente
if ($cliente_info) {
    $nombre_cliente = $cliente_info['nombres_u'];
    $apellido_cliente = $cliente_info['apellidos_u'];
    $cliente = 'Cliente: ' . $nombre_cliente . ' ' . $apellido_cliente;
} else {
    $cliente = 'Cliente Desconocido'; // Mensaje por defecto si no se encuentra el cliente
}

// Mostrar detalles en el documento
$pdf->Cell(0, 10, $cliente, 0, 1);
$pdf->Cell(0, 10, $fecha, 0, 1);
$pdf->Ln(5);

// Detalles de los productos (ejemplo con datos estáticos)
$pdf->Cell(60, 10, 'Descripción', 1, 0, 'C');
$pdf->Cell(40, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(40, 10, 'Precio', 1, 0, 'C');
$pdf->Cell(50, 10, 'Total', 1, 1, 'C');

// Consulta para obtener los productos de la tabla tbl_compra_producto
$stmt = $conexion->prepare("SELECT c.*, p.*, r.id_producto, r.nombre, r.precio, r.descuento_producto
FROM tbl_compra as c
INNER JOIN tbl_compra_producto as p ON c.id_compra = p.id_compra
INNER JOIN tbl_productos as r ON r.id_producto = p.id_producto
WHERE c.id_usuario = :id_usuario AND c.id_compra = :id_compra;");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->bindParam(':id_compra', $id_compra);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($productos as $producto) {
    // Máximo número de caracteres permitidos en la celda
    $max_caracteres = 25; // Cambia este valor según tus necesidades

    // Texto a mostrar en la celda (suponiendo que $producto['nombre'] contiene el texto)
    $texto = $producto['nombre'];

    // Verificar si el texto excede el límite de caracteres
    if (mb_strlen($texto, 'UTF-8') > $max_caracteres) {
        // Truncar el texto y agregar puntos suspensivos
        $texto_truncado = mb_substr($texto, 0, $max_caracteres - 3, 'UTF-8') . '...';
    } else {
        $texto_truncado = $texto; // Mantener el texto sin cambios si no excede el límite
    }

    $precio_desc = $producto['precio'] - (($producto['precio'] * $producto['descuento_producto']) / 100);
    $subtotal = $producto['cantidad'] * $precio_desc;
    $total += $subtotal;
    $pdf->Cell(60, 10, $texto_truncado, 1, 0);
    $pdf->Cell(40, 10, $producto['cantidad'], 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($precio_desc, 2), 1, 0, 'R');
    $pdf->Cell(50, 10, '$' . number_format($producto['cantidad'] * $precio_desc, 2), 1, 1, 'R');
}

$total = 'Total: ' . $total;

// Mostrar el total
$pdf->Cell(140, 10, 'Total a pagar:', 1, 0, 'R');
$pdf->Cell(50, 10, $total, 1, 1, 'R');

// Salida del PDF (descarga o visualización en el navegador)
$pdf->Output('factura_paykind.pdf', 'D'); // Descarga el PDF con el nombre 'factura.pdf'

// También puedes utilizar 'I' para visualizar directamente en el navegador
// $pdf->Output('factura.pdf', 'I');
