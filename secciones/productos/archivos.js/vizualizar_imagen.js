function mostrarImagenPreview(inputId, previewId, actualizarBtnId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const actualizarBtn = document.getElementById(actualizarBtnId);

    const file = input.files[0];

    if (file) {
        // Verificar la extensión del archivo
        var extensiones = /(.jpg|.png|.jpeg|.gif)$/i;
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
            actualizarBtn.disabled = true; // Desactivar el botón de actualización
            preview.innerHTML = ''; // Limpiar la vista previa
        } else {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    // Calcula las dimensiones de la imagen
                    const aspectRatio = img.width / img.height;
                    let newWidth, newHeight;

                    // Decide si redimensionar la imagen según el ancho o la altura
                    if (aspectRatio >= 1) {
                        newWidth = 300;
                        newHeight = 300 / aspectRatio;
                    } else {
                        newWidth = 200 * aspectRatio;
                        newHeight = 200;
                    }

                    // Establece las dimensiones calculadas en la vista previa
                    preview.style.width = newWidth + 'px';
                    preview.style.height = newHeight + 'px';

                    // Muestra la imagen en la vista previa
                    preview.innerHTML = '';
                    preview.appendChild(img);
                };
            };

            reader.readAsDataURL(file);

            actualizarBtn.disabled = false; // Habilitar el botón de actualización si la extensión es válida
        }
    } else {
        // Limpiar la vista previa si no se selecciona ningún archivo
        preview.innerHTML = '';
        actualizarBtn.disabled = false; // Habilitar el botón de actualización
    }
}
