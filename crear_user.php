<?php
include("./bd.php");

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

  // Verificar si el correo existe en alguna de las tablas
  if ($existe_usuario || $existe_vendedor) {
    header("location: registro.php?alerta=cuenta_ya_existente");
  } else {
    // Determinar en qué tabla insertar según el rol y construir la consulta SQL
    if ($id_rol == 'Cliente') {
      $tabla = 'tbl_usuario';
    } elseif ($id_rol == 'Vendedor') {
      $tabla = 'tbl_vendedor';
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
      if ($id_rol == 'Cliente') {
        header("location: registro.php?alerta=cuenta_cliente_registrada");
      } elseif ($id_rol == 'Vendedor') {
        header("location: registro.php?alerta=cuenta_vendedor_registrada");
      } else {
        echo "Registro exitoso. Redirecciona según corresponda.";
      }
      exit;
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
}else{
  header("location: index.php");
}
?>
