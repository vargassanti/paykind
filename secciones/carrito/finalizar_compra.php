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

$productos_carrito = $conexion->prepare("SELECT u.id_usuario, u.usuario, u.correo, p.nombre, p.precio, p.img_producto, p.descuento_producto, d.*, s.color_producto
FROM tbl_carrito AS d
INNER JOIN tbl_productos AS p ON p.id_producto = d.id_producto
INNER JOIN tbl_stock AS s ON d.id_stock = s.id_stock
INNER JOIN tbl_usuario AS u ON u.id_usuario = d.id_usuario
WHERE d.id_usuario =:id_usuario AND d.estado_carrito = 'Pendiente'");
$productos_carrito->bindParam(":id_usuario", $id_usuario);
$productos_carrito->execute();
$total_carrito = $productos_carrito->fetchAll(PDO::FETCH_ASSOC);

$productos_c = $conexion->prepare("SELECT p.id_producto, p.nombre, p.precio, d.cantidad, p.img_producto, p.descuento_producto, s.color_producto, d.id_carrito, s.cantidad_disponible
FROM tbl_productos AS p 
INNER JOIN tbl_carrito AS d ON d.id_producto = p.id_producto 
INNER JOIN tbl_stock as s ON s.id_producto = d.id_producto
WHERE d.id_usuario=:id_usuario");
$productos_c->bindParam("id_usuario", $id_usuario);
$productos_c->execute();
$total_p = $productos_c->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM `tbl_productos` ORDER BY RAND()");
$sentencia->execute();
$lista_tbl_productos_c = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($lista_tbl_productos_c as $registro) {
    $nombre = $registro['nombre'];
    $precio = $registro['precio'];
    $descripcion = $registro['descripcion'];
    $descuento = $registro['descuento_producto'];
    $img_producto = $registro['img_producto'];
    $img_producto2 = $registro['img_producto2'];
    $img_producto3 = $registro['img_producto3'];
    $img_producto4 = $registro['img_producto4'];
    $img_producto5 = $registro['img_producto5'];
    $img_producto6 = $registro['img_producto6'];
    $precio_desc = $precio - ($precio * floatval($descuento) / 100);
}

// Consulta a la base de datos para obtener los detalles de la compra
$stmt = $conexion->prepare("SELECT id_carrito FROM tbl_carrito WHERE estado_carrito = 'Pendiente'");
$stmt->execute();
$id_carrito_result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener como un array asociativo

if (empty($id_carrito_result)) {
    header("Location: checkout.php");
    exit();
}

if (is_array($id_carrito_result) && count($id_carrito_result) > 0) {
    // La consulta devolvió un array con resultados
    $id_carrito = []; // Inicializar el array para almacenar los valores obtenidos

    // Iterar a través del resultado y almacenar los valores en $id_detalle_compra
    foreach ($id_carrito_result as $row) {
        $id_carrito[] = $row['id_carrito'];
    }
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
<h4 class="titulo_proceso_compra">Proceso de compra</h4>

<div class="container-paso1">
    <h2 class="titulo_paso1">Paso 1: ¿En qué ubicación te gustaría recibir tu compra?</h2>
    <div class="paso-pago" id="ubicacionContenido">
        <p class="sub_titulo">Mi ubicación:</p>
        <div class="mi_ubicacion">
            <div class="ubicacionnn">
                <p><strong>Municipio:</strong>
                    <?php foreach ($registro_ubicacion as $municipio) { ?>
                        <?php echo $municipio['nombre_municipio'] ?>
                    <?php } ?>
                </p>
            </div>
            <div class="ubicacionnn">
                <p><strong>Comuna:</strong>
                    <?php foreach ($registro_ubicacion as $comuna) { ?>
                        <?php echo $comuna['nombre_comuna'] ?>
                    <?php } ?>
                </p>
            </div>
            <div class="ubicacionnn">
                <p><strong>Barrio: </strong>
                    <?php foreach ($registro_ubicacion as $barrio) { ?>
                        <?php echo $barrio['nombre_barrio'] ?>
                    <?php } ?>
                </p>
            </div>
            <div class="ubicacionnn">
                <p><strong>Dirección:</strong> <?php echo $user['direccion']; ?></p>
            </div>
        </div>
        <button class="editar_ubicacion"></button>
        <button class="cssbuttons-io-button boton_paso1" data-paso="2">
            Siguiente paso
            <div class="icon">
                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                </svg>
            </div>
        </button>
    </div>
    <div id="modalUbicacion" class="modal_ubicacion_edit">
        <div class="modal-contenido">
            <span class="cerrar-modal">&times;</span>
            <h2 class="actualizar_ubi">Actualizar mi ubicación:</h2>
            <form action="editar_ubicacion.php" method="post">
                <div class="mi_ubicacion2">
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
                </div>
                <div class="caja_boton_actualizar_perfil">
                    <button type="submit" class="btn_mi_perfill">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-paso2" style="display: none;">
    <h2 class="titulo_paso2">Paso 2: Productos agregados en el carrito</h2>
    <div class="resumen-producto">
        <!-- Contenido del paso 2: Productos agregados en el carrito -->
        <?php
        $total = 0;
        $total_descripcion = '';
        foreach ($total_carrito as $carrito) {
            $id_producto = $carrito['id_producto'];
            $nombre = $carrito['nombre'];
            $precio = $carrito['precio'];
            $cantidad = $carrito['cantidad'];
            $color_producto = $carrito['color_producto'];
            $descuento = $carrito['descuento_producto'];
            $img_producto = $carrito['img_producto'];
            $envio_precio = 20000;
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $subtotal = $cantidad * $precio_desc;
            $total += $subtotal;
            $id_usuario = $carrito['id_usuario'];
            $usuario = $carrito['usuario'];
            $correo = $carrito['correo'];
        ?>
            <div class="producto">
                <img src="../productos/imagenes_producto/<?php echo $carrito['img_producto'] ?>" alt="">
                <p>
                    <?php
                    $contenido = $carrito['nombre'];
                    $limite_letras = 12;

                    if (strlen($contenido) > $limite_letras) {
                        $contenido_limitado = substr($contenido, 0, $limite_letras) . '...';
                        echo $contenido_limitado;
                    } else {
                        echo $contenido;
                    }
                    ?>
                </p>
                <p>Cantidad: <?php echo $carrito['cantidad'] ?></p>
                <span class="color-option" style="background-color: <?php echo $carrito['color_producto'] ?>;"></span>
            </div>
        <?php } ?>
    </div>
    <button class="cssbuttons-io-button boton_paso2" data-paso="3">
        Siguiente paso
        <div class="icon">
            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
            </svg>
        </div>
    </button>
</div>

<div class="container-paso3" style="display: none;">
    <h2 class="titulo_paso3">Paso 3: ¿Están correctos los datos?</h2>
    <div class="container_compra_terminada">
        <div class="formulario">
            <div class="inputBox">
                <input type="text" value="<?php echo number_format($total, 0, '.', '.'); ?>" class="non-editable">
                <span>Total:</span>
            </div>
            <div class="inputBox">
                <input type="text" value="<?php echo number_format($envio_precio, 0, '.', '.'); ?>" class="non-editable">
                <span>Costo envío:</span>
            </div>
            <div class="inputBox">
                <input type="text" value="<?php echo $user['direccion']; ?>" class="non-editable">
                <span>Direccion:</span>
            </div>
            <div class="inputBox">
                <input type="text" value="<?php echo $id_usuario; ?>" class="non-editable">
                <span>Identificación:</span>
            </div>
            <div class="inputBox">
                <input type="text" value="<?php echo $usuario; ?>" class="non-editable">
                <span>Usuario:</span>
            </div>
            <div class="inputBox">
                <input type="text" value="<?php echo $correo; ?>" class="non-editable">
                <span>Correo:</span>
            </div>
        </div>
    </div>
    <button class="cssbuttons-io-button boton_paso3" data-paso="4">
        Siguiente paso
        <div class="icon">
            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
            </svg>
        </div>
    </button>
</div>

<div class="container-paso4" style="display: none;">
    <h2 class="titulo_paso4">Paso 4: Método de pago y finalización</h2>
    <p class="descripcion_paso4">Para finalizar el proceso de la compra, debes seleccionar un metodo de pago y realizar los pasos que te dice el metodo de paso que escogiste: </p>
    <div class="container_compra_terminada">
        <form action="compra_terminada.php" id="miFormulario" method="POST" id="form-paso-4" enctype="multipart/form-data" onsubmit="return validarCampos()">
            <div class="formulario">
                <div class="inputBox" style="display: none;">
                    <input type="hidden" name="total_compra" value="<?php echo $total; ?>" class="non-editable">
                    <span>Total:</span>
                </div>
                <div class="inputBox" style="display: none;">
                    <input type="hidden" name="costo_envio" value="20000" class="non-editable">
                    <span>Costo envío:</span>
                </div>
                <div class="inputBox" style="display: none;">
                    <input type="hidden" name="direccion" value="<?php echo $user['direccion']; ?>" class="non-editable">
                    <span>Direccion:</span>
                </div>
                <div class="total_compra">
                    <p class="info">Este es el total de tú compra:</p>
                    <p class="precio">$<?php echo number_format($total, 0, '.', ','); ?></p>
                </div>
                <div class="inputBox">
                    <select name="metodo_pago" id="metodo_pago" required="required" onchange="mostrarInformacion()">
                        <option selected hidden></option>
                        <option value="Transferencia Daviplata">Transferencia Daviplata</option>
                        <option value="Transferencia Ahorros Bancolombia">Transferencia Ahorros Bancolombia</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Mercadopago">Mercadopago</option>
                    </select>
                    <span>Metodo de pago:</span>
                </div>
            </div>

            <div id="divTransferenciaDaviplata" style="display: none;" class="div_mostrar_pago">
                <p class="titulo_procesos">Contenido para Transferencia Daviplata</p>
                <div class="numero_transferencia">
                    <div class="numero">
                        <div class="input1">
                            <label>Numero para la transferencia:</label>
                            <input type="text" id="OtroNumeroTransferencia" value="3102283608" class="non-editable">
                            <button type="button" class="copy" onclick="copiarOtroValor()">
                                <span data-text-end="Copiado!" data-text-initial="Copiar numero de transferencia:" class="tooltip"></span>
                                <span>
                                    <svg xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 6.35 6.35" y="0" x="0" height="20" width="20" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg" class="clipboard">
                                        <g>
                                            <path fill="currentColor" d="M2.43.265c-.3 0-.548.236-.573.53h-.328a.74.74 0 0 0-.735.734v3.822a.74.74 0 0 0 .735.734H4.82a.74.74 0 0 0 .735-.734V1.529a.74.74 0 0 0-.735-.735h-.328a.58.58 0 0 0-.573-.53zm0 .529h1.49c.032 0 .049.017.049.049v.431c0 .032-.017.049-.049.049H2.43c-.032 0-.05-.017-.05-.049V.843c0-.032.018-.05.05-.05zm-.901.53h.328c.026.292.274.528.573.528h1.49a.58.58 0 0 0 .573-.529h.328a.2.2 0 0 1 .206.206v3.822a.2.2 0 0 1-.206.205H1.53a.2.2 0 0 1-.206-.205V1.529a.2.2 0 0 1 .206-.206z"></path>
                                        </g>
                                    </svg>
                                    <svg xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="18" width="18" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg" class="checkmark">
                                        <g>
                                            <path data-original="#000000" fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="input2">
                            <label>Comprobante de la transferencia:</label>
                            <input type="file" name="imagen_tranferencia" id="imagen_transferencia_daviplata">
                        </div>
                    </div>
                </div>
                <button class="cssbuttons-io-button-finalizar-compra" id="finalizar_compra" name="finalizar_compra" type="submit">
                    Finalizar compra
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
                <br><br>
            </div>

            <div id="divTransferenciaAhorrosBancolombia" style="display: none;" class="div_mostrar_pago">
                <p class="titulo_procesos">Contenido para Transferencia Ahorros Bancolombia</p>
                <div class="numero_transferencia">
                    <img class="imagenn" src="../../imagen/QR.png" alt="">
                    <div class="numero">
                        <div class="input1">
                            <label>Numero para la transferencia:</label>
                            <input type="text" id="numeroTransferencia" value="3102283608" class="non-editable">
                            <button type="button" class="copy" onclick="copiarValor()">
                                <span data-text-end="Copiado!" data-text-initial="Copiar numero de transferencia:" class="tooltip"></span>
                                <span>
                                    <svg xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 6.35 6.35" y="0" x="0" height="20" width="20" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg" class="clipboard">
                                        <g>
                                            <path fill="currentColor" d="M2.43.265c-.3 0-.548.236-.573.53h-.328a.74.74 0 0 0-.735.734v3.822a.74.74 0 0 0 .735.734H4.82a.74.74 0 0 0 .735-.734V1.529a.74.74 0 0 0-.735-.735h-.328a.58.58 0 0 0-.573-.53zm0 .529h1.49c.032 0 .049.017.049.049v.431c0 .032-.017.049-.049.049H2.43c-.032 0-.05-.017-.05-.049V.843c0-.032.018-.05.05-.05zm-.901.53h.328c.026.292.274.528.573.528h1.49a.58.58 0 0 0 .573-.529h.328a.2.2 0 0 1 .206.206v3.822a.2.2 0 0 1-.206.205H1.53a.2.2 0 0 1-.206-.205V1.529a.2.2 0 0 1 .206-.206z"></path>
                                        </g>
                                    </svg>
                                    <svg xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="18" width="18" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg" class="checkmark">
                                        <g>
                                            <path data-original="#000000" fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="input2">
                            <label>Comprobante de la transferencia:</label>
                            <input type="file" name="imagen_tranferencia" id="imagen_transferencia_bancolombia">
                        </div>
                    </div>
                </div>
                <button class="cssbuttons-io-button-finalizar-compra" id="finalizar_compra" name="finalizar_compra" type="submit">
                    Finalizar compra
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
                <br><br>
            </div>

            <div id="divEfectivo" style="display: none;" class="div_mostrar_pago">
                <p class="titulo_procesos">Contenido para Efectivo</p>
                <p class="descripcion_efectivo">Has seleccionado el método de pago en efectivo. Por favor, verifica el total de tu compra y podrás finalizar el pago en efectivo al momento de la entrega o en el punto de venta indicado.</p>
                <button class="cssbuttons-io-button-finalizar-compra" id="finalizar_compra" name="finalizar_compra" type="submit">
                    Finalizar compra
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
            </div>

            <div id="divMercadopago" style="display: none;" class="div_mostrar_pago">
                <p class="titulo_procesos">Contenido para Mercadopago</p>
                <p class="descripcion_efectivo">Has seleccionado el método de pago en Mercadopago. Por favor, verifica el total de tu compra y podrás finalizar el pago en efectivo al momento de la entrega o en el punto de venta indicado.</p>
                <button class="cssbuttons-io-button-finalizar-compra" id="finalizar_compra" name="finalizar_compra" type="submit">
                    Finalizar compra
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
            </div>

            <div class="campos-ocultos" style="display: none;">
                <input type="hidden" name="total_compra" value="<?php echo $total ?>">
                <?php foreach ($id_carrito as $detalle) { ?>
                    <input type="hidden" name="id_carrito[]" value="<?php echo $detalle ?>">
                <?php } ?>
            </div>
        </form>
    </div>
</div>
<script src="archivos.js/modal_ubicacion.js"></script>
<script src="archivos.js/proceso_compra.js"></script>
<script src="archivos.js/copiar_contenido.js"></script>
<script src="archivos.js/validar_formulario.js"></script>
<script src="archivos.js/ubicacion.js"></script>