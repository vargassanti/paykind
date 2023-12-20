<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador" || $_SESSION["usuario_rol"] === "Cliente")) {
        $id_rol = $_SESSION["usuario_rol"];
    }
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['id_producto'])) {
    $id_producto = (isset($_GET['id_producto'])) ? $_GET['id_producto'] : "";
    $id_compra = (isset($_GET['id_compra'])) ? $_GET['id_compra'] : "";
} else {
    header("location: index.php");
}

$sentencia = $conexion->prepare("SELECT c.*, d.*, p.*, s.color_producto
FROM tbl_compra as c
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario AS u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_stock as s ON d.id_stock = s.id_stock
WHERE u.id_usuario = :id_usuario AND d.estado_carrito = 'Completado' AND d.id_compra = :id_compra AND p.id_producto = :id_producto");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->bindParam(":id_compra", $id_compra);
$sentencia->bindParam(":id_producto", $id_producto);
$sentencia->execute();
$lista_mi_compras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_mi_compras as $mi_producto) {
    $nombre = $mi_producto['nombre'];
}

include("../../templates/header.php");

?>

<form action="guardar_comentario.php" method="post">
    <div class="container_comentario">
        <h2>Agregar Comentario al
            <?php echo $nombre; ?>
        </h2>

        <input type="text" name="id_usuario" value="<?php echo $id_usuario ?>" hidden>

        <input type="text" name="id_producto" value="<?php echo $id_producto ?>" hidden>

        <label>Ingresa el texto:</label>
        <input type="text" name="texto" id="texto" required>

        <label for="rating">¿Qué puntuación le das a este producto?</label>
        <select name="calificacion" id="calificacion" required>
            <option value="1" class="stars">&#9733;</option>
            <option value="2" class="stars">&#9733;&#9733;</option>
            <option value="3" class="stars">&#9733;&#9733;&#9733;</option>
            <option value="4" class="stars">&#9733;&#9733;&#9733;&#9733;</option>
            <option value="5" class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
        </select>

        <button class="guardarComentario" type="submit">Guardar Comentario</button>
    </div>
</form>

<style>
    .container_comentario {
        width: 730px;
        height: 400px;
        margin: 12% auto;
        padding: 39px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    /* Estilos para el título */
    .container_comentario h2 {
        font-size: 1.5em;
        margin-bottom: 27px;
        text-align: center;
    }

    /* Estilos para los inputs y labels */
    .container_comentario label {
        display: block;
        margin-bottom: 5px;
    }

    .container_comentario input[type="text"],
    .container_comentario select {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Estilos para el botón */
    .container_comentario button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        margin-top: 28px;
        transition: background-color 0.3s ease;
    }

    .container_comentario button:hover {
        background-color: #0056b3;
    }

    /* Estilos para las opciones del select */
    .stars {
        font-size: 1.5em;
        color: orange;
    }
</style>