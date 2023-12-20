function eliminarReferencia(id1, id2) {
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
        title: '¿Estás seguro de eliminar esta referencia?',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            // El usuario hizo clic en "Sí"
            window.location = "eliminar_referencia.php?id_stock=" + id1 + "&id_producto=" + id2;
        } else {
            // El usuario hizo clic en "No" o cerró la alerta
            // Puedes realizar alguna acción adicional aquí si es necesario
        }
    });
}