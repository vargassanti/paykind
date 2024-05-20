<?php
session_start();

include("../../bd.php");
require '../../config.php';

$vendedores = $conexion->prepare("SELECT * FROM `tbl_vendedor`");
$vendedores->execute();
$lista_vendedores = $vendedores->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<h4 class="titulo_tienda">Vendedores</h4>

<div class="container23">
    <?php
    if (empty($lista_vendedores)) {
        echo "<p> No hay vendedores registrados. </p>";
    } else {
        foreach ($lista_vendedores as $registro) { ?>
            <div class="body">
                <a class="card_v human-resources" href="mas_vendedor.php?vendedor=<?php echo $registro['id_usuario']; ?>&ruta=vendedores.php">
                    <?php
                    if (!empty($registro['fotoPerfil'])) { ?>
                        <div class="contaner_img_vendedor">
                            <img src="../miperfil/imagenes_producto/<?php echo $registro['fotoPerfil'] ?>" alt="Foto de perfil">
                        </div>
                    <?php
                    } else { ?>
                        <div class="contaner_img_vendedor">
                            <img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">
                        </div>
                    <?php } ?>
                    <p>
                        <strong>
                            <?php
                            $contenido = $registro['usuario'];
                            $limite_letras = 20;

                            if (strlen($contenido) > $limite_letras) {
                                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                echo $contenido_limitado;
                            } else {
                                echo $contenido;
                            }
                            ?>
                        </strong>
                    </p>
                </a>
            </div>
    <?php }
    } ?>
</div>