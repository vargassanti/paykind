<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
  <title>Paykind</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="header_registro">
    <div class="imagen">
      <a href="index.php">
        <img src="img/logo.png" alt="">
      </a>
    </div>
    <div class="texto">
      <p id="botonMostrarModalTerminos1">Términos y Condiciones</p>
      <p id="botonTratamientoDatos1">Tratamiento de Datos</p>
      <a href="index.php">
        <p>Regresar al sitio web</p>
      </a>
    </div>
  </div>
  <main>
    <div class="contenedor__todo">
      <div class="caja__trasera">
        <div class="caja__trasera-login">
          <h3>¿Ya tienes una cuenta?</h3>
          <p>Inicia sesión para entrar en la página</p>
          <button id="btn__iniciar-sesion" class="animated-button">
            <span>Iniciar Sesión</span>
            <span></span>
          </button>
        </div>
        <div class="caja__trasera-register">
          <h3>¿Aún no tienes una cuenta?</h3>
          <p>Regístrate para que puedas iniciar sesión</p>
          <button id="btn__registrarse" class="animated-button-register">
            <span>Regístrarse</span>
            <span></span>
          </button>
        </div>
      </div>

      <!--Formulario de Login y registro-->
      <div class="contenedor__login-register">
        <!--Login-->
        <form action="inicio_sesion.php" method="post" class="formulario__login" onsubmit="return validarFormularioLogin()">
          <h2>Iniciar Sesión</h2>
          <input type="email" placeholder="Correo:" name="correo" id="correo">
          <input type="password" placeholder="Contraseña:" name="password" id="password">
          <img class="password-toggle" id="togglePassword" src="img/ocultar_contraseña.png" alt="Mostrar Contraseña">

          <button type="submit" name="btn_iniciar" id="btn2" class="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75">
              </path>
            </svg>
            <div class="text">
              Ingresar
            </div>
          </button>
        </form>

        <!--Register-->
        <form action="crear_user.php" class="formulario__register" method="POST" enctype="multipart/form-data" onsubmit="return validarFormularioRegister()">
          <h2>Regístrarse</h2>
          <div class="caaaaja">
            <input class="estilos_campos" type="text" placeholder="Nombres:" name="nombres_u" id="nombres_u" onkeypress="return soloLetras(event)" onpaste="return soloLetras(event)">
            <input class="estilos_campos" type="text" placeholder="Apellidos:" name="apellidos_u" id="apellidos_u" onkeypress="return soloLetras(event)" onpaste="return soloLetras(event)">
          </div>
          <input class="estilos_campos" type="email" placeholder="Correo:" name="correo" id="correo2">

          <input type="password" placeholder="Contraseña:" name="password" id="contrasena">
          <img class="toggle-password-button" id="toggleButton" src="img/ocultar_contraseña.png" alt="Mostrar Contraseña">

          <div class="caaaaja">
            <input class="estilos_campos" type="text" placeholder="Usuario:" name="usuario" id="usuario">
            <input class="estilos_campos" type="text" placeholder="Celular:" name="celular" id="celular">
          </div>
          <select class="estilos_campos_select" name="tipo_documento_u" id="tipo_documento_u">
            <option class="estilos_option" value="" selected hidden>Tipo de identificación:</option>
            <option class="estilos_option" value="CC">Cedula Ciudadanía</option>
            <option class="estilos_option" value="TI">Tarjeta de Identidad</option>
          </select>

          <div class="caaaaja">
            <input class="estilos_campos" type="text" placeholder="Identificacion:" name="id_usuario" id="id_usuario">
          </div>
          <select class="estilos_campos_select" name="id_rol" id="id_rol">
            <option selected hidden>Tipo de usuario:</option>
            <option value="Cliente">Cliente</option>
            <option value="Vendedor">Vendedor</option>
          </select>

          <div class="container_checkbox">
            <div class="checkbox-wrapper-19">
              <input id="cbtest-19" type="checkbox">
              <label class="check-box" for="cbtest-19">
              </label>
            </div>
            <p id="botonMostrarModalTerminos2">Términos y Condiciones</p>
            <div class="checkbox-wrapper-20">
              <input id="cbtest-20" type="checkbox">
              <label class="check-box-20" for="cbtest-20">
              </label>
            </div>
            <p id="botonTratamientoDatos2">Tratamiento de Datos</p>
          </div>

          <button type="submit" id="btn" name="btn_enviar_crear_cuenta" class="button2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
            </svg>
            <div class="text">
              Regístrarse
            </div>
          </button>
        </form>
      </div>
    </div>
  </main>

  <div id="modalTerminos" class="modal_terminos_condiciones">
    <div class="modal-contenido">
      <span class="cerrarModal">&times;</span>
      <div class="contenido_terminos">
        <h2>Términos y Condiciones</h2>
        <br>
        <p>La organización tiene por objeto brindar información a todos los grupos y personas de
          valor sobre las actividades que lleva a cabo la entidad. El uso y su contenido está
          sujeto a las condiciones de uso al acceder, navegar o usar este medio u otro canal de
          interacción de la organización, reconocen que han leído, entendido y se obligan a
          cumplir con estos términos y cumplir con todas las leyes y reglamentos aplicables. Si
          el Ciudadano - Usuario - Cliente no está de acuerdo con estos términos y condiciones
          de uso o con cualquier disposición del actual documento o los demás documentos
          complementarios internos, le sugerimos comunicarse por medio de una PQRS o que
          se abstenga de acceder o navegar por este Portal.
        </p>
        <br>
        <p class="titulos_negritos">1. Aceptación de términos.</p>
        <p>
          La prestación del servicio del Portal de la Organización es de carácter libre y gratuito
          para los usuarios y se rige por los términos y condiciones que se incluyen en el
          presente texto y demás documentos establecidos por la organización, los cuales se
          entienden como conocidos y aceptados por los Ciudadano - Usuario – Cliente del sitio,
          el uso de los datos personales del usuario se encuentra sujetos a la Política de
          tratamiento de información personal.
        </p>
        <br>
        <p>
          La Organización se reserva el derecho de revisar y modificar de manera unilateral
          estos términos y condiciones de uso o la información contenida en el portal web en
          cualquier momento sin aviso previo, mediante la actualización de este anuncio.
          También puede realizar mejoras o cambios en los servicios descritos en este medio
          en cualquier momento y sin previo aviso.
        </p>
        <br>
        <p class="titulos_negritos"> 2. Derechos de propiedad intelectual. </p>
        La Organización es titular de todos los derechos sobre el software del portal Web, así
        como de los derechos de propiedad industrial e intelectual referidos a los contenidos
        que en ella se incluyan, además se reserva todos los derechos de autor, incluidos los
        no mencionados en este documento.
        </p>
        <br>
        <p>
          La propiedad intelectual sobre los contenidos del portal Web (textos, gráficos, logos,
          animaciones, sonidos y bases de datos, entre otros) o bien hacen parte del patrimonio
          exclusivo de la organización o, en su caso, su titularidad es de terceros que
          autorizaron el uso de estos en el Sitio Web o es información pública que se rige por
          las leyes de acceso a la información pública de la jurisdicción. Los textos y elementos
          gráficos que constituyen la página Web, así como su presentación y montaje, o son
          titularidad exclusiva de la organización.
          Algunos de los materiales de este portal Web pueden estar protegidos por derechos
          de autor cuando así sea mencionado en el contenido. Por tanto, cualquier uso no
          autorizado, así como el incumplimiento de los términos, condiciones o avisos
          contenidos en ella, puede violar la normatividad nacional vigente al respecto.
        </p>
        <br>
        <p class="titulos_negritos">3. Información y sitios Web de terceros </p>
        <br>
        <p>
          El Portal de la Organización puede contener enlaces, cookies o acceso a sitios Web y
          contenidos de otras personas o entidades pero no se hace responsable de su
          contenido, no controla, refrenda ni garantiza el contenido incluido en dichos sitios,
          tampoco se responsabiliza del funcionamiento o accesibilidad de las páginas Web
          vinculadas; ni sugiere, invita o recomienda la visita a las mismas, por lo que tampoco
          será responsable del resultado obtenido, incluidos los cambios o actualizaciones
          realizados en el sitio enlazado o la exactitud o integridad de la información que se
          proporciona allí.
        </p>
        <br>
        <p>
          En consecuencia, los “Ciudadanos-Usuarios” aceptan que la organización no es
          responsable de ningún contenido, enlace asociado, recurso o servicio asociado al sitio
          de un tercero, ni será responsable de ninguna pérdida o daño de cualquier tipo que se
          derive del uso que se realice de los contenidos de terceros.
          El Portal de la Organización proporciona los enlaces para su conveniencia y la
          existencia de estos en nuestros sitios web no implica que la Organización apruebe o
          mantenga relaciones contractuales vigentes con las Organizaciones o compañías a la
          que se enlaza, o a sus productos o servicios y viceversa para las Organizaciones o
          compañías que se enlacen a los sitios del portal.
        </p>
        <br>
        <p class="titulos_negritos"> 4. Aviso Legal. </p>
        <p>
          <strong>1.</strong> La Organización se reserva el derecho de modificar, complementar o suspender
          total o parcialmente la aplicación y el contenido que se genere por el uso de la
          aplicación.
        </p>
        <br>
        <p>
          <strong>2.</strong> La Organización, se reserva el derecho de cambiar los términos y condiciones de
          Uso en cualquier momento, con vigencia inmediata a partir del momento que se
          actualiza la aplicación.
        </p>
        <br>
        <p>
          <strong>3.</strong> Se considerará que los Ciudadanos-Usuario han leído y aceptado los términos y
          condiciones de uso para usar, acceder, descargar, instalar, obtener o brindar
          información hacia la aplicación.
        </p>
        <br>
        <p>
          <strong>4.</strong> El Ciudadano - Usuario declara que es consciente de que el contenido insertado en
          las aplicaciones es de exclusiva responsabilidad de cada una de las entidades que lo
          publican.
        </p>
        <br>
        <p>
          <strong>5.</strong> El uso que el Ciudadano - Usuario haga del portal queda bajo su única
          responsabilidad se rechaza toda responsabilidad por la disponibilidad, oportunidad,
          seguridad y calidad de la aplicación o aplicación relacionada u otros productos,
          servicios e información obtenidos a través del portal, no somos responsables de la
          precisión o la fiabilidad de cualquier información o consejo transmitido a través de
          este.
        </p>
        <br>
        <p>
          <strong>6.</strong> Los sitios vinculados por enlace a la aplicación no están sometidos al control de la
          Organización, por lo que ésta no se responsabiliza del contenido de sitios vinculados
          ni de enlaces incluidos en el portal.
        </p>
        <br>
        <p class="titulos_negritos"> 5. Deberes y prohibiciones de los ciudadanos - usuarios.</p>
        <br>
        <p>
          El Ciudadano - Usuario se obliga a no introducir en el portal, información de carácter
          ofensivo o agraviante o que contenga amenazas, u otros programas perjudiciales o
          mecanismos para captar o distorsionar información contenida en la aplicación.
          El Ciudadano - Usuario no podrá cargar, publicar, enviar mensaje de correo
          electrónico, transmitir o de otro modo proporcionar contenido ilícito, nocivo, abusivo,
          hostil, difamatorio, discriminatorio, vulgar e injurioso, o cargar contenidos que puedan
          generar dificultades en la operación del sistema de la página web.
          Usuario - ciudadano de abstendrá de realizar declaraciones falsas o de otro modo
          erróneas de su vinculación con una persona física o jurídica o almacenar datos
          personales o de otros usuarios con los fines descritos como prohibición en el
          enunciado anterior.
        </p>
        <br>
        <p class="titulos_negritos"> 6. Aviso de privacidad.</p>
        <br>
        <p>
          Al utilizar los servicios del Portal de la Organización, usted reconoce y acepta que este
          portal puede acceder a la información de su cuenta, y preservarla, así como divulgar
          cualquier contenido asociado a dicha cuenta, si fuese necesario por razones legales, o
          bien si se considera de buena fe que el acceso, la conservación o la divulgación de
          dichos datos es razonablemente necesario para:
        </p>
        <br>
        <p> <strong>A.</strong> cumplir con leyes, regulaciones, procesos legales o solicitudes gubernamentales
          exigibles.
        </p>
        <br>
        <p>
          <strong>B.</strong> aplicar las Condiciones, incluida la investigación de posibles infracciones de las mismas.
        </p>
        <br>
        <p>
          <strong>C.</strong> detectar, prevenir o de cualquier modo abordar casos o situaciones de fraude,
          seguridad o cuestiones técnicas (incluyendo, sin limitarse a ello, el filtro de spam)
        </p>
        <br>
        <p>
          <strong>D.</strong> proteger contra todo daño inminente los derechos, propiedad o seguridad de la
          Organización sus usuarios y el público en la manera prevista o permitida por la ley.
          La Organización informa al Ciudadano–Usuario que la información solicitada y
          otorgada de manera libre y voluntaria por el Ciudadano–Usuario tiene como finalidad
          llevar el registro de participación ciudadana, el futuro envió de información relacionada con el Portal de la Organización, enviar notificaciones de actualización de este de
          acuerdo con los intereses indicados por el usuario al momento de registrarse.
          La Organización se reserva el derecho a distribuir el Contenido que usted envíe,
          publique o muestre a través de los servicios del Portal web, así como a utilizarlo en
          relación con cualquier otro servicio ofrecido por la Organización.
        </p>
        <br>
        <p>
          La Organización, se reserva el derecho de modificar las políticas de Protección de
          Datos personales y de Seguridad de la Información a fin de adaptarlas a nuevos
          requerimientos legislativos, jurisprudenciales, técnicos o todos aquellos que le
          permitan brindar mejores y más oportunos servicios y contenidos informativos, por lo
          cual se aconseja revisar estas normas periódicamente. Igualmente, se reserva el derecho a rechazar la admisión, publicación o transmisión
          de cualquier contenido a su discreción.
        </p>
        <br>
        <p class="titulos_negritos"> 7. Ley y jurisdicción aplicable.</p>
        <br>
        <p>
          Las condiciones generales que regulan el uso del Portal de la Organización se rigen
          por las leyes del país en su jurisdicción. 
          Cualquier disputa o conflicto que se genere entre el Usuario y la Organización, por el
          ingreso y/o uso del portal y de los servicios que allí se prestan, se llevará ante los
          jueces solo del país en su jurisdicción y será resuelto de acuerdo con las leyes de su
          jurisdicción sin tener efecto el conflicto con otras leyes de otros países o su estado de
          residencia actual. 
        </p>
        <br>
        <p>
          Si, por alguna razón, la corte de la Jurisdicción competente considera inaplicable
          alguna cláusula o parte de las Condiciones señaladas en los términos y condiciones
          señalados en alguna parte del presente anuncio el resto de las condiciones generales
          conservan su fuerza obligatoria, carácter vinculante y continuarán aplicándose en su
          total efecto.
        </p>
        <br>
        <p>
          Para cualquier efecto legal o judicial, el lugar de las presentes condiciones es en la
          dirección de su sede principal registrado en su registro mercantil principal basándose
          en su jurisdicción mediante los procesos internos establecidos por la organización sin
          infringir las normas y leyes legales del país de jurisdicción sin sen aplicables o demás leyes o normas de otras jurisdicciones , y cualquier controversia que surja de su
          interpretación o aplicación se someterá a las autoridades de su país de jurisdicción.
        </p>
        <br>
        <p class="titulos_negritos"> 8. Reportes Perfil Administrador.</p>
        <br>
        <p>
          EL perfil administrador en un Marketplace es una parte esencial del sistema, pues el
          administrador el encargado de administrar diversas funciones y configuraciones,
          acceder a la información necesaria y ejecutarla y transformarla en pro de la necesidad
          de clientes y colaboradores.
          El perfil administrador generalmente proporciona al área de desarrollo herramientas,
          listas de control, para supervisar las operaciones que se presentan en el Marketplace.
          Las principales características que deben encontrarse en el perfil administrador son:
          El administrador debe tener la facultad de generar todo tipo de informes sin dificultad,
          en estos informes deberían ser visibles (tanto en el sistema como la generación de un
          Excel) elementos importantes de observación y análisis como con tantas columnas
          sean necesarias con la información detallada de cada objeto:
        </p>
        <br>
        <p>
          - Artículos y cantidad vendidos.
        </p>
        <br>
        <p>
          - Valores Brutos.
        </p>
        <br>
        <p>
          - Comisiones.
        </p>
        <br>
        <p>
          - IVA.
        </p>
        <br>
        <p>
          - Valor de Transporte o Domicilio.
        </p>
        <br>
        <p>
          - Valor por pagar al cliente Vendedor.
        </p>
        <br>
        <p>
          - Categorías.
        </p>
        <br>
        <p>
          - Mayor venta del cliente vendedor.
        </p>
        <br>
        <p>
          - Zona
        </p>
        <br>
        <p>
          - Descuentos a clientes vendedores
        </p>
        <br>
        <p>
          - Margen de ganancia por cliente vendedor.
        </p>
        <br>
        <p>
          - Medios de pago
        </p>
        <br>
        <p class="titulos_negritos"> 8.1 Funciones Perfil Administrador.</p>
        <br>
        <p>
          El perfil administrador debe tener de igual manera la opción de revisar el catálogo
          general de productos unificado que indique los datos básicos y la empresa vendedora
          (el nombre de la empresa podría ser un enlace de acceso rápido al perfil corporativo).
        </p>
        <br>
        <p>
          El perfil administrador debe tener el permiso / habilidad para suprimir de manera
          inmediata elementos en venta que posean contenidos inapropiados, obscenos o que
          puedan ofender a alguno de nuestros clientes.
        </p>
        <br>
        <p>
          El perfil administrador debe permitirme generar informes en Excel, que posibiliten
          inicialmente la generación de análisis financieros para el área administrativa, contable
          y aquellas áreas pertinentes, que ayuden a tomar acción a dediciones
          organizacionales y de crecimiento acerca de productos vendidos, alta y baja rotación,
          para optimizar la oferta y la demanda.
        </p>
        <br>
        <p>
          El perfil administrador, debe tener acceso a los productos creados por los clientes
          vendedores, y así mismo, debe tener la opción de informarle a los clientes vendedores
          todo tipo de inconsistencias en la creación de productos publicados para la venta,
          como falta de imágenes, descripciones, y poder inhabilitarlos hasta que su registro y
          vinculación como producto esté completa. El mensaje opcional para el cliente podría
          ser “Tu publicación infringe las políticas internas de la organización por los siguientes
          causales:…”.
        </p>
        <br>
        <p>
          Por otro lado, el perfil administrador podrá tener acceso a consultar y verificar la base
          de datos en general de los vendedores y los clientes finales, sin infringir en la políticas
          de tratamientos de datos e información, con el fin de proporcionar una rápida gestión a
          consultas de datos especificos.
        </p>
        <br>
        <p>
          En cuanto a la revisión del perfil de colaboradores, debe tener la posibilidad de
          generar informes de repartidores, zonas de alta distribución, repartidores nuevos,
          retirados, comisión cobrada a repartidores, repartidores más activos y menos activos.
          En cuanto al perfil del cliente, el perfil administrador debe tener la potestad de vetar a
          un cliente que no cumpla con las políticas internas de la organización, que no respete
          los procesos internos y que incumpla los pagos (cuando sean en efectivo) o falte al
          respeto a la empresa vendedora o al colaborador/repartidor.
        </p>
        <div class="boton_cerrar_modal">
          <button class="cerrarBtn">
            Cerrar términos
            <div class="icon">
              <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
              </svg>
            </div>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="modalTratamientoTerminos" class="modal_terminos_condiciones">
    <div class="modal-contenido">
      <div class="contenido_preguntas">
        <span class="cerrarModal" id="closeModal">&times;</span>
        <h2>Tratamiento de Datos</h2>
        <div class="accordion">
          <p>Aquí puedes poner información sobre los tratamientos de datos.</p>
          <p>Por ejemplo: cómo se recopilan, almacenan y utilizan.</p>
        </div>
        <div class="boton_cerrar_modal">
          <button class="cerrarBtn" id="closeModal">
            Cerrar preguntas
            <div class="icon">
              <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
              </svg>
            </div>
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/script.js"></script>
  <script src="js/sololetras.js"></script>
  <script src="js/solonumeros2.js"></script>
  <script src="js/mostrar_contraseña1.js"></script>
  <script src="js/mostrar_contraseña2.js"></script>
  <script src="js/validar2.js"></script>
  <script src="js/valida_img.js"></script>
  <script src="js/modal_terminos.js"></script>
  <script src="js/preguntas.js"></script>
  <script src="js/modal_tratamiento.js"></script>
  <script src="js/validacion_register.js"></script>

  <script>
    // Verifica si se ha pasado un parámetro GET "alerta"
    var urlParams = new URLSearchParams(window.location.search);
    var alerta = urlParams.get('alerta');
    if (alerta == "usuario_no_encontrado") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Cuenta no encontrada'
      })

    }
    if (alerta == "cuenta_cliente_registrada") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
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
    if (alerta == "cuenta_vendedor_registrada") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'success',
        title: 'Cuenta como vendedor registrada, ya puedes iniciar sesión.'
      })

    }
    if (alerta == "cuenta_ya_existente") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'La cuenta ya fue registrada anteriormente.'
      })
    }
    if (alerta == "contraseña_incorrecta") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'error',
        title: 'El correo o la contraseña son incorrectos, vuelve a intentarlo.'
      })

    }
    if (alerta == "ban") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'warning',
        title: 'Cuenta suspendida por multiples reportes'
      })
    }
    if (alerta == "contraseña_actualizada") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'success',
        title: 'Tu contraseña ha sido actualizada con éxito.'
      })
    }
    if (alerta == "iniciar_sesion_primero") {
      // Muestra una alerta si el usuario no se encuentra
      Swal.mixin({
        toast: true,
        position: 'top-start', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      }).fire({
        icon: 'error',
        title: 'Debes iniciar sesión primero para poder seguir.'
      })
    }
    history.replaceState({}, document.title, window.location.pathname);
  </script>
</body>

</html>