<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
  // El usuario ha iniciado sesión y su rol es "Administrador", permite el acceso al contenido actual
  // Coloca el código de la página actual a continuación
  $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} else {
  header("Location: ../../registro.php?alerta=iniciar_sesion_primero");
  exit();
}

include("../../bd.php");

if (isset($_GET['txtID'])) {
  $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
  $sentencia = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario=:id_usuario");
  $sentencia->bindParam(":id_usuario", $txtID);
  $sentencia->execute();
  $registro = $sentencia->fetch(PDO::FETCH_LAZY);
  $usuario = $registro["usuario"];
  $tipo_documento = $registro["tipo_documento"];
  $nombres_u = $registro["nombres_u"];
  $apellidos_u = $registro["apellidos_u"];
  $celular = $registro["celular"];
  $correo = $registro["correo"];
  $id_rol = $registro["id_rol"];
}
if ($_POST) {

  //Recolectamos los datos del metodo POST
  $txtID = (isset($_POST["txtID"]) ? $_POST["txtID"] : "");
  $usuario = (isset($_POST["usuario"]) ? $_POST["usuario"] : "");
  $tipo_documento = (isset($_POST["tipo_documento"]) ? $_POST["tipo_documento"] : "");
  $nombres_u = (isset($_POST["nombres_u"]) ? $_POST["nombres_u"] : "");
  $apellidos_u = (isset($_POST["apellidos_u"]) ? $_POST["apellidos_u"] : "");
  $celular = (isset($_POST["celular"]) ? $_POST["celular"] : "");
  $correo = (isset($_POST["correo"]) ? $_POST["correo"] : "");
  $id_rol = (isset($_POST["id_rol"]) ? $_POST["id_rol"] : "");
  //Preparar la insercción de los datos 
  $sentencia = $conexion->prepare("UPDATE tbl_usuario SET
        usuario=:usuario,
        password=:password,
        correo=:correo,
        id_rol=:id_rol
        WHERE id_usuario=:id_usuario");

  //Asignando los valores que tienen uso de la variable
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->bindParam(":correo", $correo);
  $sentencia->bindParam(":id_rol", $id_rol);
  $sentencia->bindParam(":id_usuario", $txtID);
  $sentencia->execute();
  $mensaje = "Registro actualizado";
  header("location:index.php?mensaje=" . $mensaje);
}
?>
<?php include("../../templates/header.php"); ?>

<section class="home">
  <div class="text">
    <br />
    <div class="ddddd">
      <div class="card-header">
        Datos del usuarios
      </div>
      <div class="card-body">

        <form action="" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="txtID" class="form-label">ID:</label>
            <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
          </div>

          <div class="mb-3">
            <label for="usuario" class="form-label">Nombre del usuario:</label>
            <input type="text" value="<?php echo $usuario; ?>" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
          </div>

          <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" value="<?php echo $correo; ?>" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escriba su correo">
          </div>

          <div class="mb-3">
            <label for="id_rol" class="form-label">Rol:</label>
            <select class="form-select form-select-sm" name="id_rol" id="id_rol">
              <optgroup label="Tipo rol:">
                <option value="V" <?php echo ($id_rol === 'V') ? "selected" : ""; ?>>Vendedor</option>
                <option value="C" <?php echo ($id_rol === 'C') ? "selected" : ""; ?>>Cliente</option>
              </optgroup>
            </select>
          </div>

          <button type="submit" class="btn btn-success">Agregar</button>
          <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

      </div>
      <div class="card-footer text-muted"></div>
    </div>
  </div>
</section>

