function validarFormularioEstado() {
    var estadoSeleccionado = document.getElementById('estado_carrito').value;
    if (estadoSeleccionado === "") {
        alert("Por favor, selecciona un estado para la compra.");
        return false; // Evita que el formulario se envíe si no se ha seleccionado un estado
    }
    return true; // Envía el formulario si se ha seleccionado un estado
}