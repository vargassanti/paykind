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

$id_usuario = $_SESSION['usuario_id'];

if ($id_rol == 'Cliente') {
    $tabla = 'tbl_usuario';
} elseif ($id_rol == 'Vendedor') {
    $tabla = 'tbl_vendedor';
} elseif ($id_rol == 'Administrador') {
    $tabla = 'tbl_administrador';
} else {
    // Maneja el caso en que el rol no sea válido
    echo "El rol seleccionado no es válido.";
    exit;
}

// Obtener los datos del usuario
$stmt = $conexion->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario); // Suponiendo que tienes una sesión de usuario
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT fotoPerfil FROM $tabla WHERE id_usuario=:id_usuario");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->execute();
$registro_recuperado = $sentencia->fetch(PDO::FETCH_ASSOC);

$municipio = $conexion->prepare("SELECT * FROM tbl_municipio");
$municipio->execute();
$registro_municipio = $municipio->fetchAll(PDO::FETCH_ASSOC);

$comuna = $conexion->prepare("SELECT * FROM tbl_comuna");
$comuna->execute();
$registro_comuna = $comuna->fetchAll(PDO::FETCH_ASSOC);

$barrio = $conexion->prepare("SELECT * FROM tbl_barrio");
$barrio->execute();
$registro_barrio = $barrio->fetchAll(PDO::FETCH_ASSOC);

$ubi = $conexion->prepare("SELECT b.nombre_barrio, c.nombre_comuna, m.nombre_municipio, b.id_barrio FROM $tabla as u  
INNER JOIN tbl_barrio as b ON u.barrio = b.id_barrio
INNER JOIN tbl_comuna as c ON c.id_comuna = b.id_comuna
INNER JOIN tbl_municipio as m ON m.id_municipio = c.id_municipio
WHERE u.id_usuario  =:id_usuario");
$ubi->bindParam(":id_usuario", $id_usuario);
$ubi->execute();
$registro_ubicacion = $ubi->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT c.*, p.estado_carrito, COUNT(p.id_compra) AS total_productos
FROM tbl_compra as c
INNER JOIN tbl_usuario AS u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_compra_producto AS p ON p.id_compra = c.id_compra
WHERE u.id_usuario = :id_usuario
GROUP BY c.id_compra;");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->execute();
$lista_mis_compras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_mis_compras as $compras) {
    $estado_carrito = $compras['estado_carrito'];
}

$tbl_compra = $conexion->prepare("SELECT COUNT(c.id_compra) AS total_compras FROM tbl_compra AS c WHERE c.id_usuario =:id_usuario");
$tbl_compra->bindParam(":id_usuario", $id_usuario);
$tbl_compra->execute();
$tot_compras = $tbl_compra->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>
<h1 class="titulo_perfil"> Mi perfil </h1>
<div class="container_profile_card">
    <div class="profile-card">
        <div class="profile-header">
            <div class="cover-photo">
            </div>
            <div class="user-avatar">
                <?php if (!empty($registro_recuperado["fotoPerfil"])) : ?>
                    <img src="./imagenes_producto/<?php echo $registro_recuperado["fotoPerfil"]; ?>" alt="Foto de perfil actual">
                <?php else : ?>
                    <img src="../../imagen/Avatar-No-Background.png" alt="Imagen predeterminada">
                <?php endif; ?>
            </div>
            <div class="user-info">
                <h1><?php echo $user['usuario']; ?></h1>
                <p class="campos">Correo electrónico: <?php echo $user['correo']; ?></p>
            </div>
        </div>
        <div class="profile-body">
            <div class="bio">
                <h2>Mis datos personales</h2>
                <p class="campos">Nombres: <?php echo $user['nombres_u']; ?></p>
                <p class="campos">Apellidos: <?php echo $user['apellidos_u']; ?></p>
                <p class="campos">Tipo documento: <?php echo $user['tipo_documento_u']; ?></p>
                <p class="campos">Identificación: <?php echo $user['id_usuario']; ?></p>
                <p class="campos">Celular: <?php echo $user['celular']; ?></p>
                <p class="campos">Tipo de usuario: <?php echo $user['id_rol']; ?></p>
            </div>
        </div>
        <div class="cover-photo2">
            <button class="boton_editar_mi_perfil" onclick="mostrarModal()">Editar perfil
                <svg class="svg" viewBox="0 0 512 512">
                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<div class="modal_editar_perfil" id="miModal">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModal()">&times;</span>
        <form action="actualizar_datos.php" method="POST" enctype="multipart/form-data">
            <div class="card_editar_miperfil">
                <a class="singup">Editar Perfil</a>
                <div class="container_campos_mi_perfil">
                    <div class="caja_productoos">
                        <div class="foto_perfil">
                            <div class="previzualizar_imagen" id="previzualizar_imagen">
                                <?php if (!empty($registro_recuperado["fotoPerfil"])) : ?>
                                    <img src="../../secciones/miperfil/imagenes_producto/<?php echo $registro_recuperado["fotoPerfil"]; ?>" alt="Foto de perfil actual" id="imagen_perfil">
                                <?php else : ?>
                                    <img src="../../imagen/Avatar-No-Background.png" alt="Imagen predeterminada" id="imagen_perfil">
                                <?php endif; ?>
                                <span class="mensaje_hover" id="mensaje_hover">Haz clic para cambiar la foto de perfil</span>
                            </div>
                            <div class="input_subir_imagen">
                                <div class="inputBox">
                                    <input type="file" id="fotoPerfil" name="fotoPerfil" style="display: none;" onchange="mostrarImagenSeleccionada(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="caja_productoos">
                        <div class="inputBox" style="display: none;">
                            <input type="hidden" name="id_usuario" value="<?php echo $user['id_usuario']; ?>" required="required">
                            <span>Id_usuario:</span>
                        </div>

                        <div class="inputBox" style="display: none;">
                            <input type="hidden" name="id_rol" value="<?php echo $user['id_rol']; ?>" required="required">
                            <span>Id rol:</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="usuario" value="<?php echo $user['usuario']; ?>" required="required">
                            <span>Usuario:</span>
                        </div>

                        <div class="inputBox">
                            <select name="tipo_documento_u" required="required">
                                <option value="CC" <?php if ($user['tipo_documento_u'] === 'CC') echo 'selected'; ?>>Cedula Ciudadanía</option>
                                <option value="TI" <?php if ($user['tipo_documento_u'] === 'TI') echo 'selected'; ?>>Tarjeta de Identidad</option>
                            </select>
                            <span>Tipo de documento:</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="nombres_u" value="<?php echo $user['nombres_u']; ?>" required="required" onkeypress="return soloLetras(event)">
                            <span>Nombres:</span>
                        </div>
                    </div>

                    <div class="caja_productoos">
                        <div class="inputBox">
                            <input type="text" name="apellidos_u" value="<?php echo $user['apellidos_u']; ?>" required="required" onkeypress="return soloLetras(event)">
                            <span>Apellidos:</span>
                        </div>

                        <div class="inputBox">
                            <input type="email" name="correo" value="<?php echo $user['correo']; ?>" required="required">
                            <span>Correo:</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="celular" id="celular" value="<?php echo $user['celular']; ?>" required="required">
                            <span>Celular:</span>
                        </div>
                    </div>
                    <div class="caja_productoos">
                        <div class="inputBox">
                            <input type="text" name="direccion" value="<?php echo $user['direccion']; ?>" required="required">
                            <span>Dirección:</span>
                        </div>

                        <div class="inputBox">
                            <select name="" id="municipio" require>
                                <?php foreach ($registro_ubicacion as $municipio) { ?>
                                    <option value=""><?php echo $municipio['nombre_municipio'] ?></option>
                                <?php } ?>
                                <?php foreach ($registro_municipio as $muni) { ?>
                                    <option value="<?php echo $muni['id_municipio']; ?>">
                                        <?php echo $muni['nombre_municipio']; ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                            <span>Municipio:</span>
                        </div>

                        <div class="inputBox">
                            <select name="" id="comuna" require>
                                <?php foreach ($registro_ubicacion as $comuna) { ?>
                                    <option value=""><?php echo $comuna['nombre_comuna'] ?></option>
                                <?php } ?>
                            </select>
                            <select hidden name="" id="comuna2">
                                <?php foreach ($registro_comuna as $comu) { ?>
                                    <option value="<?php echo $comu['id_comuna']; ?>" data-comuna="<?php echo $comu['id_municipio']; ?>">
                                        <?php echo $comu['nombre_comuna']; ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                            <span>Comuna:</span>
                        </div>
                    </div>
                    <div class="caja_productoos">
                        <div class="inputBox">
                            <select name="barrio" id="barrio" require>
                                <?php foreach ($registro_ubicacion as $barrio) { ?>
                                    <option value="<?php echo $barrio['id_barrio']; ?>"><?php echo $barrio['nombre_barrio'] ?></option>
                                <?php } ?>
                            </select>
                            <select hidden name="" id="barrio2">
                                <?php foreach ($registro_barrio as $barri) { ?>
                                    <option value="<?php echo $barri['id_barrio']; ?>" data-barrio="<?php echo $barri['id_comuna']; ?>">
                                        <?php echo $barri['nombre_barrio']; ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                            <span>Barrio:</span>
                        </div>
                    </div>

                    <div class="caja_boton_actualizar_perfil">
                        <button type="submit" class="btn_mi_perfill">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if ($_SESSION["usuario_rol"] === "Cliente") { ?>
    <div class="container-mis-compras-realizadas">
        <h4 class="titulo_mis_compras">Mis compras</h4>
        <?php
        if (!empty($tot_compras) && $tot_compras[0]['total_compras'] > 0) {
            foreach ($tot_compras as $compras_u) { ?>
                <p class="tot_compras">Has realizado <?php echo $compras_u['total_compras']; ?> compras(s)</p>
        <?php
            }
        }
        ?>
        <div class="container_mis_productos">
            <?php if (empty($lista_mis_compras)) { ?>
                <div class="no-products-message">
                    <p>No haz realizado ninguna compra.</p>
                </div>
            <?php } else { ?>
                <?php
                $contador = 1;
                foreach ($lista_mis_compras as $compras) { ?>
                    <a href="ver_misproductos.php?id_compra=<?php echo $compras['id_compra'] ?>">
                        <div class="product">
                            <p class="estado_compra"><?php echo $contador . " . " . "Compra:" ?></p>
                            <?php $contador++; ?>
                            <?php if ($compras['estado_carrito'] == "Cancelado") { ?>
                                <img src="../../imagen/compra_cancelada-removebg-preview.png" alt="">
                            <?php } else { ?>
                                <img src="../../imagen/compra_segura.png" alt="">
                            <?php } ?>
                            <p><strong>Productos comprados:</strong> <?php echo $compras['total_productos'] ?></p>
                            <p><strong>Fecha compra: </strong><?php echo $compras['fecha_compra'] ?></p>
                            <p class="estado_carrito">Estado: <?php echo $compras['estado_carrito'] ?></p>
                        </div>
                    </a>
            <?php
                }
            } ?>
        </div>
    </div>
<?php
}
?>

<script src="archivos.js/redireccionarboton.js"></script>
<script src="archivos.js/vizualizar_imagen.js"></script>
<script src="archivos.js/ubicacion.js"></script>
<script src="../../js/solonumeros2.js"></script>
<script src="../../js/sololetras.js"></script>
<script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "datos_actualizados") {
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
            icon: 'success',
            title: 'Datos actualizados correctamente'
        })
    }
    if (alerta == "datos_no_actualizados") {
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
            title: 'Datos no actualizados.'
        })
    }
    history.replaceState({}, document.title, window.location.pathname);
</script>
<script src="archivos.js/modal_mi_perfil.js"></script>