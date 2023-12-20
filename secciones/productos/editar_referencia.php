<?php
session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Vendedor")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}
include("../../bd.php");

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['id_stock'], $_GET['id_producto'], $_GET['ruta'])) {
    $id_stock = (isset($_GET['id_stock'])) ? $_GET['id_stock'] : "";
    $id_producto = (isset($_GET['id_producto'])) ? $_GET['id_producto'] : "";
    $ruta = (isset($_GET['ruta'])) ? $_GET['ruta'] : "";

    $consulta_stock = $conexion->prepare("SELECT s.*, p.*, t.*, v.id_usuario
    FROM tbl_stock as s
    INNER JOIN tbl_productos as p ON p.id_producto = s.id_producto
    INNER JOIN tbl_tienda as t ON t.nit_identificacion = p.nit_identificacion
    INNER JOIN tbl_vendedor as v ON v.id_usuario = t.id_usuario
    WHERE s.id_producto = :id_producto 
    AND v.id_usuario = :id_usuario
    AND id_stock = :id_stock;");
    $consulta_stock->bindParam(":id_producto", $id_producto);
    $consulta_stock->bindParam(":id_usuario", $id_usuario);
    $consulta_stock->bindParam(":id_stock", $id_stock);
    $consulta_stock->execute();
    $registro_stock = $consulta_stock->fetchAll(PDO::FETCH_ASSOC);

    foreach ($registro_stock as $producto) {
        $cantidad_disponible = $producto['cantidad_disponible'];
        $color_producto = $producto['color_producto'];
    }
    include("../../templates/header.php"); ?>

    <div class="caja_botoncancelar">
        <a href="<?php echo $ruta ?>">
            <button class="button_retrocederrr">
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
        </a>
    </div>
    <form action="editar_refencia_producto.php" method="post">
        <div class="card_crear_referencia">
            <a class="singup">Editar referencia</a>
            <div class="caja_productoos">
                <div class="inputBox" style="display: none;">
                    <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $id_producto; ?>">
                    <span>Id producto:</span>
                </div>

                <div class="inputBox" style="display: none;">
                    <input type="hidden" id="id_stock" name="id_stock" value="<?php echo $id_stock; ?>">
                    <span>Id producto:</span>
                </div>

                <div class="inputBox">
                    <input type="text" id="cantidad_disponible" name="cantidad_disponible" value="<?php echo $cantidad_disponible ?>" required="required">
                    <span>Cantidad:</span>
                </div>

                <div class="inputBox">
                    <select name="color_producto" id="color_producto" required="required">
                        <option selected value="<?php echo $color_producto ?>"><?php echo $color_producto ?></option>
                        <option value="#000000">Negro</option>
                        <option value="#8a2be2">Azul violeta</option>
                        <option value="#888">Gris</option>
                        <option value="#dc143c">Rojo carmesí</option>
                        <option value="#20b2aa">Turquesa</option>
                        <option value="#9370db">Lavanda</option>
                        <option value="#32cd32">Verde lima</option>
                        <option value="#ff69b4">Rosa claro</option>
                        <option value="#1e90ff">Azul acero</option>
                        <option value="#ff4500">Rojo anaranjado</option>
                        <option value="#adff2f">Verde amarillo</option>
                        <option value="#9932cc">Púrpura oscuro</option>
                        <option value="#8b4513">Marrón silla de montar</option>
                        <option value="#228b22">Verde bosque</option>
                        <option value="#ff6347">Tomate</option>
                        <option value="#00fa9a">Verde medio mar</option>
                        <option value="#4b0082">Índigo</option>
                        <option value="#7fff00">Verde carta</option>
                        <option value="#ba55d3">Orquídea medio</option>
                        <option value="#ff7f50">Coral claro</option>
                        <option value="#40e0d0">Turquesa medio</option>
                        <option value="#800000">Marrón</option>
                        <option value="#00ced1">Azul oscuro turquesa</option>
                        <option value="#ff8c00">Naranja oscuro</option>
                        <option value="#b8860b">Dorado oscuro</option>
                        <option value="#008080">Teal</option>
                        <option value="#556b2f">Olivino</option>
                        <option value="#4682b4">Azul acero claro</option>
                        <option value="#2e8b57">Verde mar oscuro</option>
                        <option value="#87ceeb">Azul cielo</option>
                        <option value="#8b008b">Magenta oscuro</option>
                        <option value="#b0c4de">Azul acero claro</option>
                        <option value="#cd853f">Bronceado</option>
                        <option value="#cd5c5c">Rosado claro</option>
                        <option value="#008b8b">Cyan oscuro</option>
                        <option value="#d8bfd8">Lila</option>
                        <option value="#ff1493">Rosa brillante</option>
                        <option value="#dda0dd">Violeta pálido</option>
                        <option value="#6a5acd">Azul lavanda</option>
                        <option value="#7fffd4">Turquesa agua</option>
                        <option value="#c71585">Rosa medio violeta</option>
                        <option value="#f0e68c">Amarillo caña</option>
                        <option value="#ffefd5">Almendra</option>
                        <option value="#ffebcd">Blanco almendra</option>
                        <option value="#d2b48c">Marrón claro</option>
                    </select>
                    <span class="color">Color</span>
                </div>
            </div>
            <div class="caja_botones">
                <div class="caja_boton1">
                    <button type="submit" class="btn">Actualizar referencia</button>
                </div>
            </div>
        </div>
    </form>
<?php
} else {
    echo "No se recibieron datos";
}

?>