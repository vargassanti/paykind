<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}


include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $rol_ver_usu = (isset($_GET['id_rol'])) ? $_GET['id_rol'] : "";
}

include("../../templates/header.php"); ?>

<h2 class="titulo_producto"><?php echo $rol_ver_usu ?></h2>

<?php

switch ($rol_ver_usu) {
    case 'Administrador':
        $administrador = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario=:id_usuario AND id_rol = 'Administrador'");
        $administrador->bindParam(":id_usuario", $txtID);
        $administrador->execute();
        $registro_administrador = $administrador->fetchAll(PDO::FETCH_ASSOC);

        foreach ($registro_administrador as $admin) { ?>
            <div class="container_todo_ver_usuario">
                <div class="card_informacion_usuario">
                    <img class="img" src="../miperfil/imagenes_producto/<?php echo $admin['fotoPerfil']; ?>" alt="Foto de perfil">
                    <span><?php echo ucfirst($admin["usuario"]); ?></span>
                    <div class="info">
                        <p><strong>Nombres: </strong><?php echo $admin["nombres_u"]; ?></p>
                        <p><strong>Apellidos: </strong> <?php echo $admin["apellidos_u"]; ?></p>
                        <p><strong>Tipo de usuario: </strong> <?php echo $admin["id_rol"]; ?> </p>
                        <p><strong>Tipo de documento: </strong> <?php echo $admin["tipo_documento_u"]; ?></p>
                        <p><strong>Identificación: </strong> <?php echo $admin["id_usuario"] ?></p>
                        <p><strong>Correo: </strong> <?php echo $admin["correo"]; ?></p>
                        <p><strong>Celular: </strong> <?php echo $admin["celular"]; ?></p>
                        <p><strong>Dirección: </strong> <?php echo $admin["direccion"]; ?></p>
                        <p><strong>Barrio: </strong> <?php echo $admin["barrio"]; ?></p>
                    </div>
                </div>

                <div class="informacionnnn">
                    <p class="titulo">Registros de este <?php echo $rol_ver_usu ?></p>

                </div>
            </div>
        <?php
        }
        break;

    case 'Cliente':
        $cliente = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id_usuario=:id_usuario AND id_rol = 'Cliente'");
        $cliente->bindParam(":id_usuario", $txtID);
        $cliente->execute();
        $registro_cliente = $cliente->fetchAll(PDO::FETCH_ASSOC);

        foreach ($registro_cliente as $clien) { ?>
            <div class="container_todo_ver_usuario">
                <div class="card_informacion_usuario">
                    <img class="img" src="../miperfil/imagenes_producto/<?php echo $clien['fotoPerfil']; ?>" alt="Foto de perfil">
                    <span><?php echo ucfirst($clien["usuario"]); ?></span>
                    <div class="info">
                        <p><strong>Nombres: </strong><?php echo $clien["nombres_u"]; ?></p>
                        <p><strong>Apellidos: </strong> <?php echo $clien["apellidos_u"]; ?></p>
                        <p><strong>Tipo de usuario: </strong> <?php echo $clien["id_rol"]; ?> </p>
                        <p><strong>Tipo de documento: </strong> <?php echo $clien["tipo_documento_u"]; ?></p>
                        <p><strong>Identificación: </strong> <?php echo $clien["id_usuario"] ?></p>
                        <p><strong>Correo: </strong> <?php echo $clien["correo"]; ?></p>
                        <p><strong>Celular: </strong> <?php echo $clien["celular"]; ?></p>
                        <p><strong>Dirección: </strong> <?php echo $clien["direccion"]; ?></p>
                        <p><strong>Barrio: </strong> <?php echo $clien["barrio"]; ?></p>
                    </div>
                </div>

                <div class="informacionnnn">
                    <p class="titulo">Registros de este <?php echo $rol_ver_usu ?></p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus repellat, eius veniam molestias aspernatur sed odio assumenda ratione voluptatibus debitis quae tempore reprehenderit omnis amet aperiam dolorem expedita quo! Itaque.</p>

                </div>
            </div>
        <?php
        }
        break;

    case 'Vendedor':
        $vendedor = $conexion->prepare("SELECT * FROM tbl_vendedor WHERE id_usuario=:id_usuario AND id_rol = 'Vendedor'");
        $vendedor->bindParam(":id_usuario", $txtID);
        $vendedor->execute();
        $registro_vendedor = $vendedor->fetchAll(PDO::FETCH_ASSOC);

        foreach ($registro_vendedor as $vende) { ?>
            <div class="container_todo_ver_usuario">
                <div class="card_informacion_usuario">
                    <img class="img" src="../miperfil/imagenes_producto/<?php echo $vende['fotoPerfil']; ?>" alt="Foto de perfil">
                    <span><?php echo ucfirst($vende["usuario"]); ?></span>
                    <div class="info">
                        <p><strong>Nombres: </strong><?php echo $vende["nombres_u"]; ?></p>
                        <p><strong>Apellidos: </strong> <?php echo $vende["apellidos_u"]; ?></p>
                        <p><strong>Tipo de usuario: </strong> <?php echo $vende["id_rol"]; ?> </p>
                        <p><strong>Tipo de documento: </strong> <?php echo $vende["tipo_documento_u"]; ?></p>
                        <p><strong>Identificación: </strong> <?php echo $vende["id_usuario"] ?></p>
                        <p><strong>Correo: </strong> <?php echo $vende["correo"]; ?></p>
                        <p><strong>Celular: </strong> <?php echo $vende["celular"]; ?></p>
                        <p><strong>Dirección: </strong> <?php echo $vende["direccion"]; ?></p>
                        <p><strong>Barrio: </strong> <?php echo $vende["barrio"]; ?></p>
                    </div>
                </div>

                <div class="informacionnnn">
                    <p class="titulo">Registros de este <?php echo $rol_ver_usu ?></p>

                </div>
            </div>
<?php
        }
        break;

    default:
        break;
}

?>