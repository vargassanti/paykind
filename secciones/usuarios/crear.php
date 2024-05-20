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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $usuario = $_POST['usuario'];
  $id_usuario = $_POST['id_usuario'];
  $tipo_documento_u = $_POST['tipo_documento_u'];
  $correo = $_POST['correo'];
  $celular = $_POST['celular'];
  $nombres_u = $_POST['nombres_u'];
  $apellidos_u = $_POST['apellidos_u'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $id_rol = $_POST['id_rol'];

  // Verificar si el correo ya existe en tbl_usuario
  $verificar_sql_usuario = "SELECT * FROM tbl_usuario WHERE correo = :correo OR id_usuario = :id_usuario";
  $verificar_stmt_usuario = $conexion->prepare($verificar_sql_usuario);
  $verificar_stmt_usuario->bindParam(':correo', $correo, PDO::PARAM_STR);
  $verificar_stmt_usuario->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
  $verificar_stmt_usuario->execute();
  $existe_usuario = $verificar_stmt_usuario->fetch(PDO::FETCH_ASSOC);

  // Verificar si el correo ya existe en tbl_vendedor
  $verificar_sql_vendedor = "SELECT * FROM tbl_vendedor WHERE correo = :correo OR id_usuario = :id_usuario";
  $verificar_stmt_vendedor = $conexion->prepare($verificar_sql_vendedor);
  $verificar_stmt_vendedor->bindParam(':correo', $correo, PDO::PARAM_STR);
  $verificar_stmt_vendedor->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
  $verificar_stmt_vendedor->execute();
  $existe_vendedor = $verificar_stmt_vendedor->fetch(PDO::FETCH_ASSOC);

  // Verificar si el correo ya existe en tbl_administrador
  $verificar_sql_administrador = "SELECT * FROM tbl_administrador WHERE correo = :correo OR id_usuario = :id_usuario";
  $verificar_stmt_administrador = $conexion->prepare($verificar_sql_administrador);
  $verificar_stmt_administrador->bindParam(':correo', $correo, PDO::PARAM_STR);
  $verificar_stmt_administrador->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
  $verificar_stmt_administrador->execute();
  $existe_administrador= $verificar_stmt_administrador->fetch(PDO::FETCH_ASSOC);

  // Verificar si el correo existe en alguna de las tablas
  if ($existe_usuario || $existe_vendedor || $existe_administrador) {
    header("location: index.php?alerta=cuenta_ya_existente");
  } else {
    // Determinar en qué tabla insertar según el rol y construir la consulta SQL
    if ($id_rol == 'Administrador') {
      $tabla = 'tbl_administrador';
    } else {
      // Manejar el caso en que el rol no sea válido
      echo "El rol seleccionado no es válido.";
      exit;
    }
  
    // Preparar y ejecutar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO $tabla (usuario, id_usuario, tipo_documento_u, correo, celular, nombres_u, apellidos_u, password, id_rol) VALUES (:usuario, :id_usuario, :tipo_documento_u, :correo, :celular, :nombres_u, :apellidos_u, :password, :id_rol)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_documento_u', $tipo_documento_u, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':celular', $celular, PDO::PARAM_STR);
    $stmt->bindParam(':nombres_u', $nombres_u, PDO::PARAM_STR);
    $stmt->bindParam(':apellidos_u', $apellidos_u, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_STR);

    try {
      $stmt->execute();
      // Ahora puedes redirigir al usuario según corresponda
      if ($id_rol == 'Administrador') {
        header("location: index.php?alerta=cuenta_administrador_registrada");
      } else {
        echo "Registro exitoso. Redirecciona según corresponda.";
      }
      exit;
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
}
?>

<?php include("../../templates/header.php"); ?>

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
<form action="" method="post" enctype="multipart/form-data">
  <div class="card_crear_producto">
    <a class="singup">Crear Administrador</a>
    <div class="caja_productoos">
      <div class="inputBox">
        <input type="text" id="nombres_u" name="nombres_u" required="required">
        <span>Nombres:</span>
      </div>

      <div class="inputBox">
        <input type="text" id="apellidos_u" name="apellidos_u" required="required">
        <span>Apellidos:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <input type="email" id="correo" name="correo" required="required">
        <span>Correo:</span>
      </div>

      <div class="inputBox">
        <input type="password" name="password" id="contrasena" required="required">
        <span>Contraseña:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <input type="text" id="usuario" name="usuario" required="required">
        <span>Usuario:</span>
      </div>

      <div class="inputBox">
        <input type="text" id="celular" name="celular" required="required">
        <span>Celular:</span>
      </div>
    </div>

    <div class="caja_productoos">
      <div class="inputBox">
        <select name="tipo_documento_u" id="tipo_documento_u" required="required">
          <option selected hidden></option>
          <option value="CC">Cedula Ciudadanía</option>
          <option value="TI">Tarjeta de Identidad</option>
        </select>
        <span>Tipo de identificación:</span>
      </div>

      <div class="inputBox">
        <input type="text" id="id_usuario" name="id_usuario" required="required">
        <span>Identificacion:</span>
      </div>
    </div>

    <div class="inputBox" style="display: none;">
      <select hidden name="id_rol" id="id_rol" required="required">
        <option value="Administrador">Administrador</option>
      </select>
      <span>Tipo de usuario:</span>
    </div>

    <div class="caja_boton1">
      <button type="submit" class="btn">Crear usuario</button>
    </div>
  </div>

  </div>

</form>
<script src="archivos.js/redireccionarboton_admin.js"></script>