<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_GET['txtID'])) {
    $categoria_id = $_GET['txtID'];

    $categorias = $conexion->prepare("SELECT * FROM tbl_sub_categorias WHERE id_categoria=:id_categoria");
    $categorias->bindParam(":id_categoria", $categoria_id);
    $categorias->execute();
    $sub_categorias = $categorias->fetchAll(PDO::FETCH_ASSOC);

    $categoria_query = $conexion->prepare("SELECT * FROM tbl_categorias WHERE id_categoria=:id_categoria");
    $categoria_query->bindParam(":id_categoria", $categoria_id);
    $categoria_query->execute();
    $nombre_categorias = $categoria_query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php include("../../templates/header.php"); ?>

<div class="titulo_producto">
    <h4>
        <?php
        foreach ($nombre_categorias as $categoria) {
            echo $categoria['nombre_categoria'] . "<br>";
        }
        ?>
    </h4>
</div>

<div class="cantidad_categorias">
    <p class="categoriaaa">
        <?php
        if (empty($sub_categorias)) {
            echo "No hay sub categorías disponibles.";
        } else {
            foreach ($sub_categorias as $sub) {

                $cantidad_productos = $conexion->prepare("SELECT COUNT(*) as cantidad FROM `tbl_productos` WHERE id_sub_categoria = :id_sub_categoria");
                $cantidad_productos->bindParam(":id_sub_categoria", $sub['id_sub_categoria']);
                $cantidad_productos->execute();
                $cantidad_p = $cantidad_productos->fetchAll(PDO::FETCH_ASSOC);

                foreach ($cantidad_p as $cant) {
                    $c = $cant['cantidad'];

        ?>
    <div class="cada_categoria">
        <a class="button_sub_categoria" href="./sub_categoria.php?id=<?php echo $sub['id_sub_categoria']; ?>">
            <?php echo $sub['nombre_sub_categoria']; ?>(<?php echo $c ?>)
        </a>
    </div>
<?php
                }
            }
        }
?>
</p>
</div>
