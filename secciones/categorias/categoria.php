<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_GET['txtID'], $_GET['ruta'])) {
    $categoria_id = $_GET['txtID'];
    $ruta = $_GET['ruta'];

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

<div class="caja_botoncancelar">
    <a href="<?php echo $ruta ?>">
        <button class="button_retrocederrr">
            <div class="button-box">
                <span class="button-elem">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 40">
                        <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
                    </svg>
                </span>
                <span class="button-elem">
                    <svg viewBox="0 0 46 40">
                        <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
                    </svg>
                </span>
            </div>
        </button>
    </a>
</div>

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

                $cantidad_productos = $conexion->prepare("SELECT COUNT(*) as cantidad FROM `tbl_productos` WHERE id_sub_categoria = :id_sub_categoria AND estado_producto = 'Activo'");
                $cantidad_productos->bindParam(":id_sub_categoria", $sub['id_sub_categoria']);
                $cantidad_productos->execute();
                $cantidad_p = $cantidad_productos->fetchAll(PDO::FETCH_ASSOC);

                foreach ($cantidad_p as $cant) {
                    $c = $cant['cantidad'];

        ?>
    <div class="cada_categoria">
        <a class="button_sub_categoria" href="./sub_categoria.php?id=<?php echo $sub['id_sub_categoria']; ?>&ruta=categorias_sub.php">
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
