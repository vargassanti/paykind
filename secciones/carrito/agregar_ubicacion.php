<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    // El usuario ha iniciado sesión y su rol es "cliente", permite el acceso al contenido actual
} else {
    header("Location: ../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

include("../../bd.php");
require '../../config.php';

$id_usuario = $_SESSION['usuario_id'];

$municipio = $conexion->prepare("SELECT * FROM tbl_municipio");
$municipio->execute();
$registro_municipio = $municipio->fetchAll(PDO::FETCH_ASSOC);

$comuna = $conexion->prepare("SELECT * FROM tbl_comuna");
$comuna->execute();
$registro_comuna = $comuna->fetchAll(PDO::FETCH_ASSOC);

$barrio = $conexion->prepare("SELECT * FROM tbl_barrio");
$barrio->execute();
$registro_barrio = $barrio->fetchAll(PDO::FETCH_ASSOC);

// Obtener los datos del usuario
$stmt = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario); // Suponiendo que tienes una sesión de usuario
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$ubi = $conexion->prepare("SELECT b.nombre_barrio, c.nombre_comuna, m.nombre_municipio, b.id_barrio FROM tbl_usuario as u  
INNER JOIN tbl_barrio as b ON u.barrio = b.id_barrio
INNER JOIN tbl_comuna as c ON c.id_comuna = b.id_comuna
INNER JOIN tbl_municipio as m ON m.id_municipio = c.id_municipio
WHERE u.id_usuario=:id_usuario");
$ubi->bindParam(":id_usuario", $id_usuario);
$ubi->execute();
$registro_ubicacion = $ubi->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<div class="container_agregar_ubicacion">
    <h4 class="titulo_proceso_compra">Mi ubicación: </h4>
    <p class="p_text_ubicacion">Por favor, debes tener una dirección guardada para poder seguir con el pago</p>
    <form action="editar_ubicacion.php" method="post">
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
    </form>
</div>

<script src="archivos.js/ubicacion.js"></script>

<script>
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "agregar_ubicacion") {
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
        icon: 'warning',
        title: 'Agrega una dirección'
      })

    }
    history.replaceState({}, document.title, window.location.pathname);
</script>