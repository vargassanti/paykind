document.addEventListener('DOMContentLoaded', function() {
    // Obtén una referencia al botón
    const redireccionarButton = document.getElementById('finalizarCompra');

    // Agrega un evento de clic al botón
    redireccionarButton.addEventListener('click', () => {
        // Especifica la URL de destino a la que deseas redirigir
        const urlDestino = 'finalizar_compra.php?id_compra'; // Reemplaza con tu URL de destino

        // Redirige el navegador a la URL de destino
        window.location.href = urlDestino;
    });
});