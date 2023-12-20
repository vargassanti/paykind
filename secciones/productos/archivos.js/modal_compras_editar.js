function mostrarModal() {
    var modal = document.getElementById('modal');
    var body = document.body;

    modal.style.display = 'block';
    body.classList.add('modal-open');
}

function cerrarModal() {
    var modal = document.getElementById('modal');
    var body = document.body;

    modal.style.display = 'none';
    body.classList.remove('modal-open');
}

function cargarVistaRapidaComprasPend(id) {
    // Realiza una solicitud AJAX para cargar los detalles del producto
    // y muestra los detalles en el contenedor 'vista-rapida-content'
    var vistaRapidaContent = document.getElementById('vista-rapida-content');
    vistaRapidaContent.innerHTML = 'Cargando...';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            vistaRapidaContent.innerHTML = xhr.responseText;
            mostrarModal();
        }
    };
    xhr.open('GET', 'vista_rapida_compras_editar.php?id_carrito=' + id + '&c=pendiente', true);
    xhr.send();
}


function cargarVistaRapidaEditarP(id) {
    // Realiza una solicitud AJAX para cargar los detalles del producto
    // y muestra los detalles en el contenedor 'vista-rapida-content'
    var vistaRapidaContent = document.getElementById('vista-rapida-content');
    vistaRapidaContent.innerHTML = 'Cargando...';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            vistaRapidaContent.innerHTML = xhr.responseText;
            mostrarModal();
        }
    };
    xhr.open('GET', 'vista_rapida_compras_editar.php?id_compra=' + id + '&c=proceso', true);
    xhr.send();
}

function cargarVistaRapidaEditarA(id) {
    // Realiza una solicitud AJAX para cargar los detalles del producto
    // y muestra los detalles en el contenedor 'vista-rapida-content'
    var vistaRapidaContent = document.getElementById('vista-rapida-content');
    vistaRapidaContent.innerHTML = 'Cargando...';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            vistaRapidaContent.innerHTML = xhr.responseText;
            mostrarModal();
        }
    };
    xhr.open('GET', 'vista_rapida_compras_editar.php?id_compra=' + id + '&c=aprobados', true);
    xhr.send();
}

function cargarVistaRapidaEditarEsp(id) {
    // Realiza una solicitud AJAX para cargar los detalles del producto
    // y muestra los detalles en el contenedor 'vista-rapida-content'
    var vistaRapidaContent = document.getElementById('vista-rapida-content');
    vistaRapidaContent.innerHTML = 'Cargando...';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            vistaRapidaContent.innerHTML = xhr.responseText;
            mostrarModal();
        }
    };
    xhr.open('GET', 'vista_rapida_compras_editar.php?id_compra=' + id + '&c=espera_envio', true);
    xhr.send();
}

function cargarVistaRapidaEditarEts(id) {
    // Realiza una solicitud AJAX para cargar los detalles del producto
    // y muestra los detalles en el contenedor 'vista-rapida-content'
    var vistaRapidaContent = document.getElementById('vista-rapida-content');
    vistaRapidaContent.innerHTML = 'Cargando...';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            vistaRapidaContent.innerHTML = xhr.responseText;
            mostrarModal();
        }
    };
    xhr.open('GET', 'vista_rapida_compras_editar.php?id_compra=' + id + '&c=en_transito', true);
    xhr.send();
}

function cargarVistaRapidaEditarEnt(id) {
    // Realiza una solicitud AJAX para cargar los detalles del producto
    // y muestra los detalles en el contenedor 'vista-rapida-content'
    var vistaRapidaContent = document.getElementById('vista-rapida-content');
    vistaRapidaContent.innerHTML = 'Cargando...';

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            vistaRapidaContent.innerHTML = xhr.responseText;
            mostrarModal();
        }
    };
    xhr.open('GET', 'vista_rapida_compras_editar.php?id_compra=' + id + '&c=entregado', true);
    xhr.send();
}
