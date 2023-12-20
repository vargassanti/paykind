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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $nombres_u = $_POST['nombres_u'];
    $apellidos_u = $_POST['apellidos_u'];
    $tipo_documento_u = $_POST['tipo_documento_u'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];

    if ($id_rol == 'Cliente') {
        $tabla = 'tbl_usuario';
    } elseif ($id_rol == 'Vendedor') {
        $tabla = 'tbl_vendedor';
    } elseif ($id_rol == 'Administrador') {
        $tabla = 'tbl_usuario';
    } else {
        // Maneja el caso en que el rol no sea válido
        echo "El rol seleccionado no es válido.";
        exit;
    }

    // Construye la consulta SQL sin la columna fotoPerfil
    $sql = "UPDATE $tabla SET usuario = :usuario, nombres_u = :nombres_u, apellidos_u = :apellidos_u, tipo_documento_u = :tipo_documento_u, correo = :correo, celular = :celular, direccion = :direccion, barrio = :barrio WHERE id_usuario = :id_usuario";

    // Prepara y ejecuta la consulta sin la columna fotoPerfil
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':nombres_u', $nombres_u);
    $stmt->bindParam(':apellidos_u', $apellidos_u);
    $stmt->bindParam(':tipo_documento_u', $tipo_documento_u);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':barrio', $barrio);
    $stmt->bindParam(':id_usuario', $id_usuario); // Suponiendo que tienes una sesión de usuario

    if ($stmt->execute()) {
        // Actualización exitosa sin la columna fotoPerfil
        // Ahora manejaremos la imagen de perfil
        $fecha_ = new DateTime();
        $nombreArchivo_fotoPerfil = '';

        // Si se subió una imagen de perfil
        if (!empty($_FILES["fotoPerfil"]["name"])) {
            $nombreArchivo_fotoPerfil = $fecha_->getTimestamp() . "_" . $_FILES["fotoPerfil"]["name"];
            $tmp_img_fotoPerfil = $_FILES["fotoPerfil"]['tmp_name'];

            // Ruta completa de destino para la imagen de perfil
            $ruta_destino = "./imagenes_producto/" . $nombreArchivo_fotoPerfil;

            // Mueve la imagen de perfil a la carpeta de destino
            if (move_uploaded_file($tmp_img_fotoPerfil, $ruta_destino)) {
                // Actualiza la columna fotoPerfil en la base de datos
                $sql_actualizar_fotoPerfil = "UPDATE $tabla SET fotoPerfil = :fotoPerfil WHERE id_usuario = :id_usuario";
                $stmt_actualizar_fotoPerfil = $conexion->prepare($sql_actualizar_fotoPerfil);
                $stmt_actualizar_fotoPerfil->bindParam(':fotoPerfil', $nombreArchivo_fotoPerfil);
                $stmt_actualizar_fotoPerfil->bindParam(':id_usuario', $id_usuario);

                // Ejecuta la consulta para actualizar la columna fotoPerfil
                if ($stmt_actualizar_fotoPerfil->execute()) {
                    // Redirige a la página con éxito
                    header("location:index.php?alerta=datos_actualizados");
                    exit();
                } else {
                    // Error al actualizar la columna fotoPerfil en la base de datos
                    header("location:index.php?alerta=error_actualizar_fotoPerfil");
                    exit();
                }
            } else {
                // Error al mover la imagen de perfil a la carpeta de destino
                header("location:index.php?alerta=error_subir_imagen");
                exit();
            }
        } else {
            // No se subió una nueva imagen de perfil, simplemente redirige a la página con éxito
            header("location:index.php?alerta=datos_actualizados");
            exit();
        }
    } else {
        // Error al ejecutar la consulta SQL sin la columna fotoPerfil
        header("location:index.php?alerta=datos_no_actualizados");
        exit();
    }
    $_SESSION['fotoPerfil'] = $nombreArchivo_fotoPerfil;
}

if ($id_rol == 'Cliente') {
    $tabla = 'tbl_usuario';
} elseif ($id_rol == 'Vendedor') {
    $tabla = 'tbl_vendedor';
} elseif ($id_rol == 'Administrador') {
    $tabla = 'tbl_usuario';
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

$id_usuario = $_SESSION['usuario_id'];

$sentencia = $conexion->prepare("SELECT c.*, COUNT(p.id_compra) AS total_productos
FROM tbl_compra as c
INNER JOIN tbl_usuario AS u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_compra_producto AS p ON p.id_compra = c.id_compra
WHERE u.id_usuario = :id_usuario
GROUP BY c.id_compra;");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->execute();
$lista_mis_compras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT c.*, d.*, p.*, s.*, u.*
FROM tbl_compra as c
INNER JOIN tbl_compra_producto as d ON d.id_compra = c.id_compra
INNER JOIN tbl_productos as p ON p.id_producto = d.id_producto
INNER JOIN tbl_usuario AS u ON u.id_usuario = c.id_usuario
INNER JOIN tbl_stock as s ON p.id_producto = s.id_producto
WHERE u.id_usuario = :id_usuario AND d.estado_carrito = 'En proceso' AND s.id_stock = d.id_stock;");
$sentencia->bindParam(":id_usuario", $id_usuario);
$sentencia->execute();
$lista_mis_compras_en_proceso = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$tbl_compra = $conexion->prepare("SELECT COUNT(c.id_compra) AS total_compras FROM tbl_compra AS c WHERE c.id_usuario =:id_usuario");
$tbl_compra->bindParam(":id_usuario", $id_usuario);
$tbl_compra->execute();
$tot_compras = $tbl_compra->fetchAll(PDO::FETCH_ASSOC);

$tbl_compra = $conexion->prepare("SELECT COUNT(c.id_compra) AS total_compras 
FROM tbl_compra AS c
INNER JOIN tbl_compra_producto AS d ON d.id_compra = c.id_compra
WHERE c.id_usuario =:id_usuario AND d.estado_carrito = 'En proceso'");
$tbl_compra->bindParam(":id_usuario", $id_usuario);
$tbl_compra->execute();
$tot_compras_en_proceso = $tbl_compra->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>
<h1 class="titulo_perfil"> Mi perfil </h1>
<div class="container_profile_card">
    <div class="profile-card">
        <div class="profile-header">
            <div class="cover-photo">
            </div>
            <div class="user-avatar">
                <?php if (!empty($registro_recuperado["fotoPerfil"])) : ?>
                    <img src="../../secciones/miperfil/imagenes_producto/<?php echo $registro_recuperado["fotoPerfil"]; ?>" alt="Foto de perfil actual">
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
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card_editar_miperfil">
                <a class="singup">Editar Perfil</a>
                <div class="container_campos_mi_perfil">
                    <div class="caja_productoos">
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
                <div class="container_foto_perfil">
                    <div class="foto_perfil">
                        <div class="previzualizar_imagen" id="imagenPreview_miperfil">
                            <?php if (!empty($registro_recuperado["fotoPerfil"])) : ?>
                                <img src="../../secciones/miperfil/imagenes_producto/<?php echo $registro_recuperado["fotoPerfil"]; ?>" alt="Foto de perfil actual">
                            <?php else : ?>
                                <img src="../../imagen/Avatar-No-Background.png" alt="Imagen predeterminada">
                            <?php endif; ?>
                        </div>
                        <div class="input_subir_imagen">
                            <div class="inputBox">
                                <input type="file" id="fotoPerfil" name="fotoPerfil" onchange="mostrarImagenPreview('fotoPerfil', 'imagenPreview_miperfil')" value="<?php echo $registro_recuperado['fotoPerfil']; ?>">
                                <span>Foto de perfil:</span>
                            </div>
                        </div>
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
                    <div class="boton_seguirComprando">
                        <a href="../productos/index.php">
                            <button class="seguirComprando">
                            </button>
                        </a>
                    </div>
                </div>
            <?php } else { ?>
                <?php 
                $contador = 1;
                foreach ($lista_mis_compras as $compras) { ?>
                    <a href="ver_misproductos.php?id_compra=<?php echo $compras['id_compra'] ?>">
                        <div class="product">
                            <p class="estado_compra"><?php echo $contador . " . " . "Compra:" ?></p>
                            <?php $contador++; ?>
                            <img src="../../imagen/compra_segura.png" alt="">
                            <p><strong>Productos comprados:</strong> <?php echo $compras['total_productos'] ?></p>
                            <p class="price"><strong>Total: </strong> $<?php echo number_format($compras['total_compra'], 0); ?></p>
                            <p><strong>Metodo de pago: </strong><?php echo $compras['metodo_pago'] ?></p>
                            <p class="descipcion"><strong>Dirección:</strong> <?php echo $compras['direccion'] ?></p>
                            <p><strong>Fecha compra: </strong><?php echo $compras['fecha_compra'] ?></p>
                        </div>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
        <br><br>
        <h4 class="titulo_mis_compras">Compras en proceso</h4>
        <?php
        if (!empty($tot_compras_en_proceso) && $tot_compras_en_proceso[0]['total_compras'] > 0) {
            foreach ($tot_compras_en_proceso as $compras_u_proceso) { ?>
                <p class="tot_compras">Tienes <?php echo $compras_u_proceso['total_compras']; ?> compras en proceso</p>
        <?php
            }
        }
        ?>
        <div class="container_mis_productos">
            <?php if (empty($lista_mis_compras_en_proceso)) { ?>
                <div class="no-products-message">
                    <p>No tienes ninguna compra en proceso.</p>
                </div>
            <?php } else { ?>
                <?php foreach ($lista_mis_compras_en_proceso as $proceso) { ?>
                    <div class="product">
                        <p class="estado_compra">Estado compra: <?php echo $proceso['estado_carrito'] ?></p>
                        <img src="../productos/imagenes_producto/<?php echo $proceso['img_producto']; ?>" alt="Producto">
                        <h2>
                            <?php
                            $contenido = $proceso['nombre'];
                            $limite_letras = 15;

                            if (strlen($contenido) > $limite_letras) {
                                $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                                echo $contenido_limitado;
                            } else {
                                echo $contenido;
                            }
                            ?>
                        </h2>
                        <p class="descipcion">Cantidad: <?php echo $proceso['cantidad'] ?></p>
                        <p class="price">Precio: $<?php echo number_format($proceso['precio'], 2); ?></p>
                        <p><?php echo $proceso['fecha_compra'] ?></p>
                        <p>Color:</p>
                        <span class="color-option-compras" style="background-color: <?php echo $proceso['color_producto'] ?>;">
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <br><br>
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
            icon: 'success',
            title: 'Cuenta como usuario cliente registrada, ya puedes iniciar sesión.'
        })
    }
    history.replaceState({}, document.title, window.location.pathname);
</script>
<script>
    function mostrarModal() {
        var modal = document.getElementById('miModal');
        modal.style.display = 'block';
        // Evento para cerrar el modal al hacer clic fuera de él
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    }

    function cerrarModal() {
        var modal = document.getElementById('miModal');
        modal.style.display = 'none';
    }
</script>