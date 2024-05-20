<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
  // El usuario ha iniciado sesión y su rol es "Administrador", permite el acceso al contenido actual
  // Coloca el código de la página actual a continuación
} else {
  header("Location: ../../registro.php?alerta=iniciar_sesion_primero");
  exit();
}

include("../../bd.php");

if (isset($_GET['txtID'], $_GET['rol_usuario'])) {
  $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
  $rol_usuario = (isset($_GET['rol_usuario'])) ? $_GET['rol_usuario'] : "";

  if ($rol_usuario == 'Cliente') {
    $tabla = 'tbl_usuario';
  } elseif ($rol_usuario == 'Vendedor') {
    $tabla = 'tbl_vendedor';
  } elseif ($rol_usuario == 'Administrador') {
    $tabla = 'tbl_administrador';
  } else {
    echo "El rol seleccionado no es válido.";
    exit;
  }

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
  $ubi->bindParam(":id_usuario", $txtID);
  $ubi->execute();
  $registro_ubicacion = $ubi->fetchAll(PDO::FETCH_ASSOC);

  $info_u = $conexion->prepare("SELECT * FROM $tabla WHERE id_usuario =:id_usuario AND id_rol =:id_rol");
  $info_u->bindParam(":id_usuario", $txtID);
  $info_u->bindParam(":id_rol", $rol_usuario);
  $info_u->execute();
  $info_usuario = $info_u->fetchAll(PDO::FETCH_ASSOC);

  foreach ($info_usuario as $usu) {
    $id_usuarioo = $usu['id_usuario'];
    $usuario_u = $usu['usuario'];
    $tipo_documento_u = $usu['tipo_documento_u'];
    $nombres_u = $usu['nombres_u'];
    $apellidos_u = $usu['apellidos_u'];
    $correo = $usu['correo'];
    $celular = $usu['celular'];
    $direccion = $usu['direccion'];
    $barrio = $usu['barrio'];
    $id_rol = $usu['id_rol'];
  }
}

include("../../templates/header.php"); ?>


<div class="caja_botoncancelar">
  <button class="button_retrocederrr" id="redireccionarButtonDevolver">
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
</div>
<form action="editar_usuario.php" method="post">
  <div class="card_crear_producto">
    <a class="singup">Editar <?php echo $rol_usuario ?></a>
    <div class="caja_productoos">
      <div class="inputBox">
        <input type="text" id="nombres_u" name="nombres_u" value="<?php echo $nombres_u ?>" required="required">
        <span>Nombres:</span>
      </div>

      <div class="inputBox">
        <input type="text" id="apellidos_u" name="apellidos_u" value="<?php echo $apellidos_u ?>" required="required">
        <span>Apellidos:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <input type="email" id="correo" name="correo" value="<?php echo $correo ?>" required="required">
        <span>Correo:</span>
      </div>

      <div class="inputBox">
        <input type="text" id="usuario" name="usuario" value="<?php echo $usuario_u ?>" required="required">
        <span>Usuario:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <input type="text" id="celular" name="celular" value="<?php echo $celular ?>" required="required">
        <span>Celular:</span>
      </div>
      <div class="inputBox">
        <select name="tipo_documento_u" required="required">
          <option value="CC" <?php if ($tipo_documento_u === 'CC') echo 'selected'; ?>>Cedula Ciudadanía</option>
          <option value="TI" <?php if ($tipo_documento_u === 'TI') echo 'selected'; ?>>Tarjeta de Identidad</option>
        </select>
        <span>Tipo de identificación:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <input type="text" id="id_usuario" name="id_usuario" value="<?php echo $id_usuarioo ?>" required="required">
        <span>Identificacion:</span>
      </div>

      <div class="inputBox">
        <select name="id_rol" id="id_rol" required="required">
          <?php if ($rol_usuario == "Administrador") { ?>
            <option value="Administrador" <?php if ($rol_usuario === 'Administrador') echo 'selected'; ?>>Administrador</option>
          <?php
          } else { ?>
            <option value="Cliente" <?php if ($rol_usuario === 'Cliente') echo 'selected'; ?>>Cliente</option>
            <option value="Vendedor" <?php if ($rol_usuario === 'Vendedor') echo 'selected'; ?>>Vendedor</option>
          <?php } ?>
        </select>
        <span>Tipo de usuario:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <input type="text" id="direccion" name="direccion" value="<?php echo $direccion ?>" required="required">
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
    </div>

    <div class="caja_productoos">
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

    <div class="caja_boton1">
      <button type="submit" class="btn">Actualizar usuario</button>
    </div>
  </div>
</form>
<script src="archivos.js/redireccionarboton_admin.js"></script>
<script src="../miperfil/archivos.js/ubicacion.js"></script>