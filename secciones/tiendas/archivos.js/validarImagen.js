function validarImagen(inputId) {
    const input = document.getElementById(inputId);
    const file = input.files[0];

    if (file) {
        // Verificar la extensión del archivo
        var extensiones = /(.jpg|.png|.jpeg)$/i;
        var extensionValida = extensiones.exec(file.name);

        if (!extensionValida) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: 'Debes subir solo imagenes tipo png, jpg o jpeg.'
            })
            input.value = ''; // Limpiar el input
        }
    }
}
