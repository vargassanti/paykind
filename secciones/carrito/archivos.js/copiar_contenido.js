function copiarValor() {
    // Seleccionar el input por su ID
    var inputNumero = document.getElementById('numeroTransferencia');

    // Seleccionar el texto dentro del input
    inputNumero.select();

    // Copiar el texto seleccionado
    document.execCommand('copy');

    // Deseleccionar el texto
    window.getSelection().removeAllRanges();

    // Mostrar un mensaje o realizar alguna acción adicional
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'success',
        title: '¡Valor copiado al portapapeles!'
    })
}

function copiarOtroValor() {
    // Seleccionar el input por su ID
    var inputNumero = document.getElementById('OtroNumeroTransferencia');

    // Seleccionar el texto dentro del input
    inputNumero.select();

    // Copiar el texto seleccionado
    document.execCommand('copy');

    // Deseleccionar el texto
    window.getSelection().removeAllRanges();

    // Mostrar un mensaje o realizar alguna acción adicional
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'success',
        title: '¡Valor copiado al portapapeles!'
    })
}
