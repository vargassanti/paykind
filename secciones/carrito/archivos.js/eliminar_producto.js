function eliminarProducto() {
    const botonEliminar = event.target.closest("a");
    const idProducto = botonEliminar.getAttribute("data-id");

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
        title: '¿Deseas este producto del carrito?',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            // En este punto, "idProducto" contiene el ID del producto seleccionado
            window.location.href = "eliminar_producto.php?id_carrito=" + idProducto;
        } else {}
    });
}