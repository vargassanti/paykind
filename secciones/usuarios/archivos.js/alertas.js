// Verifica si se ha pasado un parámetro GET "alerta"
var urlParams = new URLSearchParams(window.location.search);
var alerta = urlParams.get('alerta');
if (alerta == "usuario_no_encontrado") {
    // Muestra una alerta si el usuario no se encuentra
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
        icon: 'warning',
        title: 'Cuenta no encontrada'
    })

}
if (alerta == "cuenta_cliente_registrada") {
    // Muestra una alerta si el usuario no se encuentra
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'success',
        title: 'Cuenta como usuario cliente registrada, ya puedes iniciar sesión.'
    })

}
if (alerta == "cuenta_vendedor_registrada") {
    // Muestra una alerta si el usuario no se encuentra
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'success',
        title: 'Cuenta como vendedor registrada, ya puedes iniciar sesión.'
    })

}
if (alerta == "cuenta_ya_existente") {
    // Muestra una alerta si el usuario no se encuentra
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'warning',
        title: 'El correo electrónico ya fue registrado anteriormente.'
    })
}
if (alerta == "contraseña_incorrecta") {
    // Muestra una alerta si el usuario no se encuentra
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'error',
        title: 'La contraseña ingresa es incorrecta, vuelve a intentarlo.'
    })

}
if (alerta == "ban") {
    // Muestra una alerta si el usuario no se encuentra
    Swal.mixin({
        toast: true,
        position: 'top-end', // Cambia la posición a la izquierda
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'warning',
        title: 'Cuenta suspendida por multiples reportes'
    })

}
history.replaceState({}, document.title, window.location.pathname);