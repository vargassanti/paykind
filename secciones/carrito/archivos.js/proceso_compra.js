const pasos = document.querySelectorAll('.container-paso1, .container-paso2, .container-paso3, .container-paso4');

pasos.forEach((paso) => {
    const siguienteBtn = paso.querySelector('.cssbuttons-io-button');

    siguienteBtn.addEventListener('click', function () {
        const siguientePasoNum = parseInt(this.getAttribute('data-paso'));

        // Ocultar mensaje específico del paso actual si existe
        const actualMensajeEspecifico = paso.querySelector('.mensaje-especifico');
        if (actualMensajeEspecifico) {
            actualMensajeEspecifico.style.display = 'none';
        }

        const siguientePaso = document.querySelector(`.container-paso${siguientePasoNum}`);
        const siguienteMensajeEspecifico = siguientePaso.querySelector('.mensaje-especifico');

        // Mostrar mensaje específico en el siguiente paso si existe
        if (siguienteMensajeEspecifico) {
            siguienteMensajeEspecifico.style.display = 'block';
        }

        paso.style.display = 'none'; // Ocultar el paso actual
        siguientePaso.style.display = 'block';
    });

    // Resto del código para manejar los botones "Anterior" si es necesario...
});
