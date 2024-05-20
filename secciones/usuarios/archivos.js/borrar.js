function borrar(id, rol_usuario_e) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'warning',
        title: '¿Desea borrar este usuario?',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            // El usuario hizo clic en "Sí"
            window.location = "index.php?txtID=" + id + "&rol_usuario_e=" + rol_usuario_e;
        } else {
            // El usuario hizo clic en "No" o cerró la alerta
            // Puedes realizar alguna acción adicional aquí si es necesario
        }
    });
}