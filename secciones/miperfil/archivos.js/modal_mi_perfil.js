function mostrarModal() {
    var modal = document.getElementById('miModal');
    var body = document.querySelector('body');

    modal.style.display = 'block';
    body.classList.add('no-scroll');

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            body.classList.remove('no-scroll');
        }
    };
}

function cerrarModal() {
    var modal = document.getElementById('miModal');
    var body = document.querySelector('body');

    modal.style.display = 'none';
    body.classList.remove('no-scroll');
}