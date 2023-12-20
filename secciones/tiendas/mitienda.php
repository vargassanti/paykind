<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor" || $_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");

include("../../templates/header.php");

$id_usuario = $_SESSION['usuario_id'];

$sentencia = $conexion->prepare("SELECT COUNT(*) FROM `tbl_tienda` WHERE id_usuario = :id_usuario");
$sentencia->bindParam(":id_usuario", $id_usuario); 
$sentencia->execute();

$cantidad_tiendas = $sentencia->fetchColumn();

$usuario = $conexion->prepare("SELECT * FROM tbl_vendedor WHERE id_usuario=:id_usuario");
$usuario->bindParam(":id_usuario", $id_usuario);
$usuario->execute();
$nombre_usuario = $usuario->fetchAll(PDO::FETCH_ASSOC);
?>

<h4 class="titulo_producto">Mis tiendas</h4>
<div class="container_tiendas">
    <?php
    if (!empty($cantidad_tiendas)) {
    ?>
        <p class="count_tiendas">
            <?php foreach ($nombre_usuario as $nombre_u) {
                echo $nombre_u["nombres_u"];
            } ?>, has registrado <?php echo $cantidad_tiendas ?> tienda(s).</p>
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        if (isset($_SESSION['usuario_rol'])) {
            $usuario_rol = $_SESSION['usuario_rol'];

            $sentencia = $conexion->prepare("SELECT * FROM `tbl_tienda` WHERE id_usuario = :id_usuario");
            $sentencia->bindParam(":id_usuario", $id_usuario); // Asegúrate de que tengas un valor para $id_usuario
            $sentencia->execute();
            if ($usuario_rol == 'Vendedor') {
    ?>
                <div class="caja_crear_tiendas">
                    <button id="redireccionarButton" class="button_crear_tienda" type="button">
                        <span class="button__text">Crear tienda</span>
                        <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <line x1="12" x2="12" y1="5" y2="19"></line>
                                <line x1="5" x2="19" y1="12" y2="12"></line>
                            </svg></span>
                    </button>
                </div>
    <?php
            }
        }
    }
    ?>
    <br>
    <div class="container_mis_tiendas">
        <?php
        if ($sentencia->rowCount() == 0) { ?>
            <b class="no_hay_tiendas_r">No hay tiendas registradas, crea una.</b>
            <?php
        } else {
            foreach ($sentencia as $registro) { ?>
                <a href="mas_tienda.php?txtID=<?php echo $registro['nit_identificacion']; ?>">
                    <div class="card">
                        <div class="card__img">
                            <img class="imagen_tienditas" src="./imagenes_tienda/<?php echo $registro['logo_tienda']; ?>" class="img-fluid rounded" alt="" />
                        </div>
                        <div class="card__descr-wrapper">
                            <p class="card__title">
                                <p class="nombre_tienda">
                                    <?php
                                    $contenido = $registro['nombre_tienda'];
                                    $limite_letras = 20;

                                    if (strlen($contenido) > $limite_letras) {
                                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                        echo $contenido_limitado;
                                    } else {
                                        echo $contenido;
                                    }
                                    ?>
                                </p>
                            </p>
                        </div>
                    </div>
                </a>
        <?php }
        }
        ?>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtén una referencia al botón
        const redireccionarButton = document.getElementById('redireccionarButton');

        // Agrega un evento de clic al botón
        redireccionarButton.addEventListener('click', () => {
            // Especifica la URL de destino a la que deseas redirigir
            const urlDestino = 'crear.php'; // Reemplaza con tu URL de destino

            // Redirige el navegador a la URL de destino
            window.location.href = urlDestino;
        });
    });
</script>

<script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "nit_ya_existente") {
        // Muestra una alerta si el usuario no se encuentra
        Swal.mixin({
            toast: true,
            position: 'top-end', // Cambia la posición a la izquierda
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).fire({
            icon: 'error',
            title: 'El nit que ingresaste ya se encuentra registrado.'
        })
    }
    if (alerta == "no_eliminar_tienda") {
        // Muestra una alerta si el usuario no se encuentra
        Swal.mixin({
            toast: true,
            position: 'top-end', // Cambia la posición a la izquierda
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).fire({
            icon: 'error',
            title: 'La tienda tiene productos registrados. No se puede eliminar.'
        })

    }
    history.replaceState({}, document.title, window.location.pathname);
</script>