document.addEventListener('DOMContentLoaded', function() {
    // Obtén una referencia al botón
    const redireccionarButton = document.getElementById('finalizar_compra');

    // Agrega un evento de clic al botón
    redireccionarButton.addEventListener('click', () => {
        // Especifica la URL de destino a la que deseas redirigir
        const urlDestino = 'compra_terminada.php'; // Reemplaza con tu URL de destino

        // Redirige el navegador a la URL de destino
        window.location.href = urlDestino;
    });
});