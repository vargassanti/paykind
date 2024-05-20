function mostrarImagenSeleccionada(event) {
    const imagenSeleccionada = event.target.files[0];
    const imagenTag = document.getElementById('imagen_perfil');
    const labelFotoPerfil = document.getElementById('label_fotoPerfil');
    
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i; // Expresión regular para las extensiones permitidas

    if (imagenSeleccionada) {
        if (!allowedExtensions.exec(imagenSeleccionada.name)) {
            // Verificar si la extensión de la imagen no está permitida
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
                title: 'Por favor, selecciona una imagen con formato JPG, JPEG o PNG.'
            })
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            imagenTag.src = e.target.result;
        };

        reader.readAsDataURL(imagenSeleccionada);
        labelFotoPerfil.textContent = 'Imagen seleccionada';
    } else {
        imagenTag.src = '../../imagen/Avatar-No-Background.png'; // Imagen predeterminada si no se selecciona ninguna imagen
        labelFotoPerfil.textContent = 'Foto de perfil:';
    }
}

const previzualizarImagen = document.getElementById('previzualizar_imagen');
previzualizarImagen.addEventListener('click', function() {
    const inputFotoPerfil = document.getElementById('fotoPerfil');
    inputFotoPerfil.click();
});
