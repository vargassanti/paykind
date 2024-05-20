<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Administrador") {
} elseif (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("DELETE FROM tbl_categorias WHERE id_categoria=:id_categoria");
    $sentencia->bindParam(":id_categoria", $txtID);
    $sentencia->execute();
    $mensaje = "Registro eliminado";
    header("location:index.php?mensaje=" . $mensaje);
}

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $categoria = $conexion->prepare("DELETE FROM tbl_sub_categorias WHERE id_sub_categoria=:id_sub_categoria");
    $categoria->bindParam(":id_sub_categoria", $txtID);
    $categoria->execute();
    $mensaje = "Registro eliminado";
    header("location:index.php?mensaje=" . $mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia->execute();
$lista_tbl_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$nombre_sub_categoria = $conexion->prepare("SELECT * FROM tbl_sub_categorias");
$nombre_sub_categoria->execute();
$lista_tbl_sub_categorias = $nombre_sub_categoria->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php"); ?>


<br />
<h4 class="titulo_categoria">Categorias registradas</h4>
<div class="container1">
    <div class="caja_crear_nueva_categoria">
        <button id="redireccionarButton" class="button_crear_categoriaa" type="button">
            <span class="button__text">Añadir categoria</span>
            <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <line x1="12" x2="12" y1="5" y2="19"></line>
                    <line x1="5" x2="19" y1="12" y2="12"></line>
                </svg></span>
        </button>
    </div>
    <div class="container_compras">
        <table class="table_categorias" id="tabla_id">
            <thead>
                <tr>
                    <th class="primer_th">Id categoria:</th>
                    <th scope="col">Nombre de la categoria:</th>
                    <th class="ultimo_th">Acciones:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($lista_tbl_categorias)) {
                    echo "<tr><td colspan='3'>No hay categorias registradas.</td></tr>";
                } else {
                    foreach ($lista_tbl_categorias as $registro) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id_categoria']; ?></td>
                            <td><?php echo $registro['nombre_categoria']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="dropbtn" id="dropdownBtn">Opciones</button>
                                    <div class="dropdown-content" id="myDropdown">
                                        <button class="animated-button-ver">
                                            <a href="./categoria.php?txtID=<?php echo $registro['id_categoria']; ?>">
                                                <span>Ver</span>
                                                <span></span>
                                            </a>
                                        </button>

                                        <button class="animated-button-editar">
                                            <a href="editar.php?id=<?php echo $registro['id_categoria']; ?>">
                                                <span>Editar</span>
                                                <span></span>
                                            </a>
                                        </button>

                                        <button class="animated-button-eliminar">
                                            <a href="javascript:borrar(<?php echo $registro['id_categoria']; ?>);">
                                                <span>Eliminar</span>
                                                <span></span>
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <div class="caja_crear_nueva_categoria">
        <button id="redireccionarButton2" class="button_crear_sub_categoriaa" type="button">
            <span class="button__text">Añadir sub categoria</span>
            <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <line x1="12" x2="12" y1="5" y2="19"></line>
                    <line x1="5" x2="19" y1="12" y2="12"></line>
                </svg></span>
        </button>
    </div>

    <div class="container_compras">
        <table class="table_categorias" id="tabla_id">
            <thead>
                <tr>
                    <th class="primer_th">Id sub categoria:</th>
                    <th>Nombre de la sub categoria:</th>
                    <th class="ultimo_th">Acciones:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($lista_tbl_sub_categorias)) {
                    echo "<tr><td colspan='3'>No hay sub categorias registradas.</td></tr>";
                } else {
                    foreach ($lista_tbl_sub_categorias as $registro) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id_sub_categoria']; ?></td>
                            <td><?php echo $registro['nombre_sub_categoria']; ?></td>
                            <?php
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                if (isset($_SESSION['usuario_rol'])) {
                                    $usuario_rol = $_SESSION['usuario_rol'];
                                    if ($usuario_rol == 'Vendedor' || $usuario_rol == 'Administrador') {
                            ?>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropbtn" id="dropdownBtn">Opciones</button>
                                                <div class="dropdown-content" id="myDropdown">
                                                    <button class="animated-button-ver">
                                                        <a href="./sub_categoria.php?id=<?php echo $registro['id_sub_categoria']; ?>">
                                                            <span>Ver</span>
                                                            <span></span>
                                                        </a>
                                                    </button>

                                                    <button class="animated-button-editar">
                                                        <a href="editar_sub_categoria.php?id=<?php echo $registro['id_sub_categoria']; ?>">
                                                            <span>Editar</span>
                                                            <span></span>
                                                        </a>
                                                    </button>

                                                    <button class="animated-button-eliminar">
                                                        <a href="javascript:borrar(<?php echo $registro['id_sub_categoria']; ?>);">
                                                            <span>Eliminar</span>
                                                            <span></span>
                                                        </a>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="archivos.js/redireccionarbutton1.js"></script>
<script src="archivos.js/redireccionarbutton2.js"></script>
<script src="archivos.js/script.js"></script>
<script src="archivos.js/borrar.js"></script>