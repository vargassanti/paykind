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

function cargarVistaRapidaCompras(id) {
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
    xhr.open('GET', 'vista_rapida_compras.php?id_compra=' + id, true);
    xhr.send();
}