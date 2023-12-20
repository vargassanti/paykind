<?php

session_start();

include("../../bd.php");

// Obtener las categorías y subcategorías de la base de datos
$sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia->execute();
$lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$nombre_sub_categoria = $conexion->prepare("SELECT * FROM tbl_sub_categorias");
$nombre_sub_categoria->execute();
$lista_tbl_sub_categorias = $nombre_sub_categoria->fetchAll(PDO::FETCH_ASSOC);

// Organizar las subcategorías por categoría en un arreglo asociativo
$categorias_con_subcategorias = array();

foreach ($lista_tbl_categorias as $categoria) {
    $categorias_con_subcategorias[$categoria['id_categoria']]['categoria'] = $categoria;
}

foreach ($lista_tbl_sub_categorias as $sub_categoria) {
    $id_categoria = $sub_categoria['id_categoria'];
    $categorias_con_subcategorias[$id_categoria]['subcategorias'][] = $sub_categoria;
}
?>

<?php include("../../templates/header.php"); ?>

<h4 class="titulo_sub_categoria">Categorías y Subcategorías</h4>

<ul class="category-list" id="category-list">
    <?php foreach ($categorias_con_subcategorias as $categoria_con_subcategorias) { ?>
        <li class="category">
            <a href="categoria.php?txtID=<?php echo $categoria_con_subcategorias['categoria']['id_categoria']; ?>">
                <span> <?php echo $categoria_con_subcategorias['categoria']['nombre_categoria']; ?></span>
            </a>
            <button class="show-button">Ver sub categorias</button>
        </li>
        <?php if (!empty($categoria_con_subcategorias['subcategorias'])) { ?>
            <ul class="subcategory">
                <?php foreach ($categoria_con_subcategorias['subcategorias'] as $sub_categoria) { ?>
                    <a href="./sub_categoria.php?id=<?php echo $sub_categoria['id_sub_categoria']; ?>">
                        <li><?php echo $sub_categoria['nombre_sub_categoria']; ?></li>
                    </a>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p class="no_hay_sub_categorias">No hay subcategorías disponibles.</p>
        <?php } ?>
    <?php } ?>
</ul>
<button class="boton_volver_arriba_p" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
    <i class='bx bx-up-arrow-alt'></i>
</button>
<script>
    // JavaScript para scroll suave hacia arriba
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<script src="archivos.js/categorias_subcategorias.js"></script>