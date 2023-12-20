const togglePassword1 = document.getElementById('togglePassword1');
const togglePassword2 = document.getElementById('togglePassword2');

togglePassword1.addEventListener('click', () => {
    togglePassword('password1', togglePassword1);
});

togglePassword2.addEventListener('click', () => {
    togglePassword('password2', togglePassword2);
});

function togglePassword(passwordId, toggleButton) {
    const passwordInput = document.getElementById(passwordId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.src = '../img/mostrar_contraseña.png'; // Cambiar a la imagen de ojo abierto
    } else {
        passwordInput.type = 'password';
        toggleButton.src = '../img/ocultar_contraseña.png'; // Cambiar a la imagen de ojo cerrado
    }
}
