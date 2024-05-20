<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['txtID'], $_GET['rol_usuario_e'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $rol_usuario_e = (isset($_GET['rol_usuario_e'])) ? $_GET['rol_usuario_e'] : "";

    if ($rol_usuario_e == 'Cliente') {
        $tabla_eliminar = 'tbl_usuario';
    } elseif ($rol_usuario_e == 'Vendedor') {
        $tabla_eliminar = 'tbl_vendedor';
    } elseif ($rol_usuario_e == 'Administrador') {
        $tabla_eliminar = 'tbl_administrador';
    } else {
        echo "El rol seleccionado no es válido.";
        exit;
    }

    $sentencia = $conexion->prepare("DELETE FROM $tabla_eliminar WHERE id_usuario=:id_usuario AND id_rol=:id_rol");
    $sentencia->bindParam(":id_usuario", $txtID);
    $sentencia->bindParam(":id_rol", $rol_usuario_e);
    $sentencia->execute();

    $mensaje = "Registro eliminado";
    header("location:index.php?mensaje=" . $mensaje);
}

$clientes = $conexion->prepare("SELECT * FROM `tbl_usuario` where id_rol = 'Cliente'");
$clientes->execute();
$lista_tbl_usuarios = $clientes->fetchAll(PDO::FETCH_ASSOC);

$administradores = $conexion->prepare("SELECT * FROM `tbl_administrador` WHERE id_rol = 'Administrador'");
$administradores->execute();
$lista_tbl_administradores = $administradores->fetchAll(PDO::FETCH_ASSOC);

$vendedores = $conexion->prepare("SELECT * FROM `tbl_vendedor`");
$vendedores->execute();
$lista_tbl_vendedores = $vendedores->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT fotoPerfil FROM `tbl_usuario`");
$sentencia->execute();
$registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

if (isset($registro_recuperado["fotoPerfil"]) && $registro_recuperado["fotoPerfil"] != "") {
    if (file_exists("./imagenes_producto/" . $registro_recuperado["fotoPerfil"])) {
        unlink("./imagenes_producto/" . $registro_recuperado["fotoPerfil"]);
    }
}

$info_u = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario =:id_usuario");
$info_u->bindParam(":id_usuario", $id_usuario);
$info_u->execute();
$informacion = $info_u->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>


<h4 class="titulo_usuarios_registrados">Usuarios registrados</h4>
<div class="container1">
    <div class="caja_crear_nuevo_usuario">
        <button id="redireccionarButton" class="button_crear_nuevo_usuario" type="button">
            <span class="button__text">Crear Administrador</span>
            <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <line x1="12" x2="12" y1="5" y2="19"></line>
                    <line x1="5" x2="19" y1="12" y2="12"></line>
                </svg></span>
        </button>
    </div>
    <div class="container_compras">
        <div class="cabecera">
            <div class="profile">
                <?php foreach ($informacion as $info) { ?>
                    <img class="foto_perfil" src="../miperfil/imagenes_producto/<?php echo $info['fotoPerfil'] ?>" alt="">
                <?php
                } ?>
            </div>
            <div class="inputs">
                <div class="inputs">
                    <?php foreach ($informacion as $info) { ?>
                        <input type="text" value="<?php echo $info['nombres_u'] ?>" class="non-editable">
                </div>
                <div class="inputs">
                    <input type="text" value="<?php echo $info['apellidos_u'] ?>" class="non-editable">
                <?php
                    } ?>
                </div>
            </div>
        </div>

        <hr>
        <br>
        <table class="table" id="tabla_id">
            <caption class="titulo_tabla">Tabla de los Administradores registrados</caption>
            <thead>
                <tr>
                    <th class="primer_th">Usuario:</th>
                    <th>Id usuario:</th>
                    <th>Correo:</th>
                    <th>Celular:</th>
                    <th>Tipo de usuario:</th>
                    <th class="ultimo_th">Acciones:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($lista_tbl_administradores)) {
                    echo "<tr><td colspan='6'>No hay administradores registrados.</td></tr>";
                } else {
                    foreach ($lista_tbl_administradores as $registro) { ?>
                        <tr>
                            <td>
                                <div class="container_foto_usu">
                                    <div class="fotico">
                                        <?php if (empty($registro['fotoPerfil'])) { ?>
                                            <img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">
                                        <?php } else { ?>
                                            <img src="../miperfil/imagenes_producto/<?php echo $registro['fotoPerfil']; ?>" alt="">
                                        <?php } ?>
                                    </div>
                                    <p>
                                        <?php
                                        $contenido = $registro['usuario'];
                                        $limite_letras = 5;

                                        if (strlen($contenido) > $limite_letras) {
                                            $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                            echo $contenido_limitado;
                                        } else {
                                            echo $contenido;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </td>
                            <td scope="row">
                                <?php
                                $numero = $registro['id_usuario'];
                                $limite_digitos = 10;

                                if (strlen((string)$numero) > $limite_digitos) {
                                    $numero_limitado = number_format($numero, 0, '', '');
                                    echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                } else {
                                    echo $numero;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $contenido = $registro['correo'];
                                $limite_letras = 15;

                                if (strlen($contenido) > $limite_letras) {
                                    $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                    echo $contenido_limitado;
                                } else {
                                    echo $contenido;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $numero = $registro['celular'];
                                $limite_digitos = 10;

                                if (strlen((string)$numero) > $limite_digitos) {
                                    $numero_limitado = number_format($numero, 0, '', '');
                                    echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                } else {
                                    echo $numero;
                                }
                                ?>
                            </td>
                            <td><?php echo $registro['id_rol']; ?></td>
                            <td>
                                <button class="animated-button-editar">
                                    <a href="editar.php?txtID=<?php echo $registro['id_usuario']; ?>&rol_usuario=<?php echo $registro['id_rol']; ?>">
                                        <span>Editar</span>
                                        <span></span>
                                    </a>
                                </button>

                                <button class="animated-button-eliminar">
                                    <a href="javascript:borrar(<?php echo $registro['id_usuario']; ?>, '<?php echo $registro['id_rol']; ?>');">
                                        <span>Eliminar</span>
                                        <span></span>
                                    </a>
                                </button>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
    <div class="container_compras">
        <table class="table" id="tabla_id">
            <caption class="titulo_tabla">Tabla de los Clientes registrados</caption>
            <thead>
                <tr>
                    <th class="primer_th">Usuario:</th>
                    <th>Id usuario:</th>
                    <th>Correo:</th>
                    <th>Celular:</th>
                    <th>Tipo de usuario:</th>
                    <th class="ultimo_th">Acciones:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($lista_tbl_usuarios)) {
                    echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
                } else {
                    foreach ($lista_tbl_usuarios as $registro) { ?>
                        <tr>
                            <td>
                                <div class="container_foto_usu">
                                    <div class="fotico">
                                        <?php if (empty($registro['fotoPerfil'])) { ?>
                                            <img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">
                                        <?php } else { ?>
                                            <img src="../miperfil/imagenes_producto/<?php echo $registro['fotoPerfil']; ?>" alt="">
                                        <?php } ?>
                                    </div>
                                    <p>
                                        <?php
                                        $contenido = $registro['usuario'];
                                        $limite_letras = 5;

                                        if (strlen($contenido) > $limite_letras) {
                                            $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                            echo $contenido_limitado;
                                        } else {
                                            echo $contenido;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </td>
                            <td scope="row">
                                <?php
                                $numero = $registro['id_usuario'];
                                $limite_digitos = 10;

                                if (strlen((string)$numero) > $limite_digitos) {
                                    $numero_limitado = number_format($numero, 0, '', '');
                                    echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                } else {
                                    echo $numero;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $contenido = $registro['correo'];
                                $limite_letras = 15;

                                if (strlen($contenido) > $limite_letras) {
                                    $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                    echo $contenido_limitado;
                                } else {
                                    echo $contenido;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $numero = $registro['celular'];
                                $limite_digitos = 10;

                                if (strlen((string)$numero) > $limite_digitos) {
                                    $numero_limitado = number_format($numero, 0, '', '');
                                    echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                } else {
                                    echo $numero;
                                }
                                ?>
                            </td>
                            <td><?php echo $registro['id_rol']; ?></td>
                            <td>
                                <button class="animated-button-editar">
                                    <a href="editar.php?txtID=<?php echo $registro['id_usuario']; ?>&rol_usuario=<?php echo $registro['id_rol']; ?>">
                                        <span>Editar</span>
                                        <span></span>
                                    </a>
                                </button>

                                <button class="animated-button-eliminar">
                                    <a href="javascript:borrar(<?php echo $registro['id_usuario']; ?>, '<?php echo $registro['id_rol']; ?>');">
                                        <span>Eliminar</span>
                                        <span></span>
                                    </a>
                                </button>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
    <div class="container_compras">
        <table class="table" id="tabla_id">
            <caption class="titulo_tabla">Tabla de los Vendedores registrados</caption>
            <thead>
                <tr>
                    <th class="primer_th">Usuario:</th>
                    <th>Id usuario:</th>
                    <th>Correo:</th>
                    <th>Celular:</th>
                    <th>Tipo de usuario:</th>
                    <th class="ultimo_th">Acciones:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($lista_tbl_vendedores)) {
                    echo "<tr><td colspan='6'>No hay vendedores registrados.</td></tr>";
                } else {
                    foreach ($lista_tbl_vendedores as $registro) { ?>
                        <tr class="">
                            <td>
                                <div class="container_foto_usu">
                                    <div class="fotico">
                                        <?php if (empty($registro['fotoPerfil'])) { ?>
                                            <img src="../../imagen/Avatar-No-Background.png" alt="Imagen Predeterminada">
                                        <?php } else { ?>
                                            <img src="../miperfil/imagenes_producto/<?php echo $registro['fotoPerfil']; ?>" alt="">
                                        <?php } ?>
                                    </div>
                                    <p>
                                        <?php
                                        $contenido = $registro['usuario'];
                                        $limite_letras = 5;

                                        if (strlen($contenido) > $limite_letras) {
                                            $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                            echo $contenido_limitado;
                                        } else {
                                            echo $contenido;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </td>
                            <td scope="row">
                                <?php
                                $numero = $registro['id_usuario'];
                                $limite_digitos = 10;

                                if (strlen((string)$numero) > $limite_digitos) {
                                    $numero_limitado = number_format($numero, 0, '', '');
                                    echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                } else {
                                    echo $numero;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $contenido = $registro['correo'];
                                $limite_letras = 15;

                                if (strlen($contenido) > $limite_letras) {
                                    $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                    echo $contenido_limitado;
                                } else {
                                    echo $contenido;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $numero = $registro['celular'];
                                $limite_digitos = 10;

                                if (strlen((string)$numero) > $limite_digitos) {
                                    $numero_limitado = number_format($numero, 0, '', '');
                                    echo substr($numero_limitado, 0, $limite_digitos) . '...';
                                } else {
                                    echo $numero;
                                }
                                ?>
                            </td>
                            <td><?php echo $registro['id_rol']; ?></td>
                            <td>
                                <button class="animated-button-editar">
                                    <a href="editar.php?txtID=<?php echo $registro['id_usuario']; ?>&rol_usuario=<?php echo $registro['id_rol']; ?>">
                                        <span>Editar</span>
                                        <span></span>
                                    </a>
                                </button>

                                <button class="animated-button-eliminar">
                                    <a href="javascript:borrar(<?php echo $registro['id_usuario']; ?>, '<?php echo $registro['id_rol']; ?>');">
                                        <span>Eliminar</span>
                                        <span></span>
                                    </a>
                                </button>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>
<button class="boton_volver_arriba2" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
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

<script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "cuenta_administrador_registrada") {
        // Muestra una alerta si el usuario no se encuentra
        Swal.mixin({
            toast: true,
            position: 'top-end', // Cambia la posición a la izquierda
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).fire({
            icon: 'success',
            title: 'Administrador registrado correctamente.'
        })

    }
    if (alerta == "cuenta_ya_existente") {
        // Muestra una alerta si el usuario no se encuentra
        Swal.mixin({
            toast: true,
            position: 'top-end', // Cambia la posición a la izquierda
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).fire({
            icon: 'warning',
            title: 'La cuenta ya fue registrada anteriormente.'
        })
    }
    history.replaceState({}, document.title, window.location.pathname);
</script>
<script src="archivos.js/alertas.js"></script>
<script src="archivos.js/redireccionarboton.js"></script>
<script src="archivos.js/borrar.js"></script>
<script src="archivos.js/script.js"></script>