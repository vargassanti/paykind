document.addEventListener("DOMContentLoaded", function () {
    // Obtener la URL actual
    const urlActual = window.location.href;

    // Obtener todos los elementos 'a' dentro de '.opciones'
    const botones = document.querySelectorAll('.opciones a');

    // Recorrer los enlaces y comparar con la URL actual
    botones.forEach(boton => {
        const enlace = boton.getAttribute('href');

        // Si la URL actual coincide con el enlace, marcar como activo
        if (urlActual.includes(enlace)) {
            boton.querySelector('.botones_sc').classList.add('activo');
        }
    });
});