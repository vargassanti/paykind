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

// Configuración de la página
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configura la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Reporte de Compras');
$pdf->SetSubject('Asunto del PDF');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, demo');

// Establece márgenes
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Configura la fuente predeterminada y el tamaño del texto
$pdf->SetFont('times', '', 12);

// Agrega una página
$pdf->AddPage();

$data = $conexion->prepare("SELECT c.*, d.*, p.nombre, p.precio, p.img_producto, s.color_producto, u.usuario
FROM tbl_compra as c
INNER JOIN tbl_detalle_compra as d ON d.id_detalle_compra = c.id_detalle_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_stock as s ON s.id_stock = d.id_stock
INNER JOIN tbl_usuario as u ON u.id_usuario = d.id_usuario");
$data->execute();
$compras_data = $data->fetchAll(PDO::FETCH_ASSOC);

// Datos
$pdf->SetFont('times', '', 12); // Restaurar la fuente normal
foreach ($compras_data as $row) {
    $pdf->MultiCell(0, 10, 'Nombre Producto: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['nombre'], 0, 'L');
    $pdf->MultiCell(0, 10, 'ID Usuario: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['id_usuario'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Usuario: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['usuario'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Total compra: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['total_compra'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Direccion: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['direccion'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Costo envio: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['costo_envio'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Metodo pago: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['metodo_pago'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Cantidad: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['cantidad'], 0, 'L');
    $pdf->MultiCell(0, 10, 'Estado de la compra: ', 0, 'L');
    $pdf->MultiCell(0, 10, $row['estado_carrito'], 0, 'L');

    $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0))); // Establecer el estilo de la línea
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 170, $pdf->GetY()); // Dibujar una línea horizontal

    $pdf->Ln(); // Salto de línea después de cada conjunto de datos
}

// Cierra y genera el archivo PDF
$pdf->Output('datos.pdf', 'D'); // 'D' para descargar el archivo

echo '<script>
    setTimeout(function() {
        window.location.href = "reportes.php"; // Reemplaza con la URL de tu página de destino
    }, 3000); // Redireccionar después de 3 segundos (puedes ajustar este tiempo)
</script>';