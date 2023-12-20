<?php
session_start();

include("../../bd.php");
require '../../config.php';

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Administrador")) {
    // El usuario ha iniciado sesión y su rol es "vendedor", permite el acceso al contenido actual
    // Coloca el código de la página actual a continuación
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI'];
} elseif (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "Cliente" || $_SESSION["usuario_rol"] === "Vendedor") {
    // El usuario no ha iniciado sesión con el rol de "vendedor", redirige a otra página
    header("location:index.php");
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$total_ventas = $conexion->prepare("SELECT COUNT(*) AS total_ventas FROM tbl_compra");
$total_ventas->execute();

$total_inventario = $conexion->prepare("SELECT COUNT(*) AS total_inventario FROM tbl_productos");
$total_inventario->execute();

$total_clientes = $conexion->prepare("SELECT COUNT(*) AS total_clientes FROM tbl_usuario WHERE id_rol = 'Cliente'");
$total_clientes->execute();

$total_vendedores = $conexion->prepare("SELECT COUNT(*) AS total_vendedores FROM tbl_vendedor WHERE id_rol = 'Vendedor'");
$total_vendedores->execute();

$total_tiendas = $conexion->prepare("SELECT COUNT(*) AS total_tiendas FROM tbl_tienda");
$total_tiendas->execute();

?>
<?php include("../../templates/header.php"); ?>

<div class="container_reportes_admin">
    <h1>Panel de Reportes</h1>
    <nav class="nav_reportes">
        <ul>
            <li><a href="#reporte-ventas" onclick="seleccionar(this)">Reporte de Ventas</a></li>
            <li><a href="#reporte-inventario" onclick="seleccionar(this)">Reporte de Inventario</a></li>
            <li><a href="#reporte-clientes" onclick="seleccionar(this)">Reporte de Clientes</a></li>
            <li><a href="#reporte-vendedores" onclick="seleccionar(this)">Reporte de Vendedores</a></li>
            <li><a href="#reporte-tiendas" onclick="seleccionar(this)">Reporte de Tiendas</a></li>
        </ul>
    </nav>
    <main class="container_sections">
        <section id="reporte-ventas" class="reporte">
            <div class="info-reporte">
                <h2>Reporte de Ventas</h2>
                <!-- Contenido del reporte de ventas -->
                <p>Información de las ventas aquí...</p>
                <p><strong>Total de ventas:</strong>
                    <?php foreach ($total_ventas as $ventas) {
                        echo $ventas['total_ventas'];
                    } ?>
                </p>
            </div>
            <div class="container-botones-reportes">
                <button class="button_ver_r" onclick="redirectToInfo('ventas')">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Ver reporte</span>
                    </span>
                </button>

                <a href="descargar_pdf.php">
                    <button class="button_ver_r">
                        <span class="button_lg">
                            <span class="button_sl"></span>
                            <span class="button_text">Descargar pdf</span>
                        </span>
                    </button>
                </a>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar excel</span>
                    </span>
                </button>
            </div>
        </section>

        <section id="reporte-inventario" class="reporte">
            <div class="info-reporte">
                <h2>Reporte de Inventario</h2>
                <!-- Contenido del reporte de inventario -->
                <p>Información de inventario aquí...</p>
                <p><strong>Total de inventario:</strong>
                    <?php foreach ($total_inventario as $inventario) {
                        echo $inventario['total_inventario'];
                    } ?>
                </p>
            </div>
            <div class="container-botones-reportes">
                <button class="button_ver_r" onclick="redirectToInfo('inventario')">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Ver reporte</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar pdf</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar excel</span>
                    </span>
                </button>
            </div>
        </section>

        <section id="reporte-clientes" class="reporte">
            <div class="info-reporte">
                <h2>Reporte de Clientes</h2>
                <!-- Contenido del reporte de usuarios -->
                <p>Información de clientes aquí...</p>
                <p><strong>Total de clientes:</strong>
                    <?php foreach ($total_clientes as $clientes) {
                        echo $clientes['total_clientes'];
                    } ?>
                </p>
            </div>
            <div class="container-botones-reportes">
                <button class="button_ver_r" onclick="redirectToInfo('clientes')">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Ver reporte</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar pdf</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar excel</span>
                    </span>
                </button>
            </div>
        </section>

        <section id="reporte-vendedores" class="reporte">
            <div class="info-reporte">
                <h2>Reporte de Vendedores</h2>
                <!-- Contenido del reporte de usuarios -->
                <p>Información de vendedores aquí...</p>
                <p><strong>Total de vendedores:</strong>
                    <?php foreach ($total_vendedores as $vendedores) {
                        echo $vendedores['total_vendedores'];
                    } ?>
                </p>
            </div>
            <div class="container-botones-reportes">
                <button class="button_ver_r" onclick="redirectToInfo('vendedores')">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Ver reporte</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar pdf</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar excel</span>
                    </span>
                </button>
            </div>
        </section>

        <section id="reporte-tiendas" class="reporte">
            <div class="info-reporte">
                <h2>Reporte de Tiendas</h2>
                <!-- Contenido del reporte de tiendas -->
                <p>Información de tiendas aquí...</p>
                <p><strong>Total de tiendas:</strong>
                    <?php foreach ($total_tiendas as $tiendas) {
                        echo $tiendas['total_tiendas'];
                    } ?>
                </p>
            </div>
            <div class="container-botones-reportes">
                <button class="button_ver_r" onclick="redirectToInfo('tiendas')">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Ver reporte</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar pdf</span>
                    </span>
                </button>

                <button class="button_ver_r">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Descargar excel</span>
                    </span>
                </button>
            </div>
        </section>
    </main>
    <button class="boton_volver_arriba" onclick="scrollToTop()" id="btnVolverArriba" title="Volver Arriba">
        <i class='bx bx-up-arrow-alt'></i>
    </button>
</div>

<script>
    // JavaScript para scroll suave hacia arriba
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<script>
    function seleccionar(elemento) {
        // Eliminar la clase 'active' de todos los enlaces
        const enlaces = document.querySelectorAll('.nav_reportes ul li a');
        enlaces.forEach(enlace => enlace.classList.remove('active'));

        // Agregar la clase 'active' al enlace clicado
        elemento.classList.add('active');

        // Scroll hacia la sección correspondiente
        const seccionId = elemento.getAttribute('href');
        document.querySelector(seccionId).scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>

<script>
    function redirectToInfo(reportType) {
        window.location.href = `info_reporte.php?type=${reportType}`;
    }
</script>

<script>
    function seleccionar(elemento) {
        const enlaces = document.querySelectorAll('.nav_reportes ul li a');
        enlaces.forEach(enlace => enlace.classList.remove('active'));

        elemento.classList.add('active');

        const seccionId = elemento.getAttribute('href');
        const seccion = document.querySelector(seccionId);

        // Añadir clase resaltada a la sección y luego quitarla después de 2 segundos
        seccion.classList.add('resaltado');
        setTimeout(function() {
            seccion.classList.remove('resaltado');
        }, 2000);

        // Scroll hacia la sección correspondiente
        seccion.scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>