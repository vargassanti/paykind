function mostrarOcultarCampos() {
    var camposOcultos = document.querySelectorAll('#camposOcultos');

    camposOcultos.forEach(function(campo) {
        if (campo.style.display === 'none') {
            campo.style.display = 'block';
        } else {
            campo.style.display = 'none';
        }
    });

    // Guardar estado en el almacenamiento local (localStorage)
    var camposVisibles = camposOcultos[0].style.display === 'none' ? 'false' : 'true';
    localStorage.setItem('camposVisibles', camposVisibles);
}

// Recuperar el estado del almacenamiento local al cargar la página
window.onload = function() {
    var camposVisibles = localStorage.getItem('camposVisibles');
    if (camposVisibles === 'true') {
        mostrarOcultarCampos();
    }
};