const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('togglePassword');

togglePassword.addEventListener('click', () => {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    togglePassword.src = 'img/mostrar_contraseña.png'; // Cambiar a la imagen de ojo abierto
  } else {
    passwordInput.type = 'password';
    togglePassword.src = 'img/ocultar_contraseña.png'; // Cambiar a la imagen de ojo cerrado
  }
});