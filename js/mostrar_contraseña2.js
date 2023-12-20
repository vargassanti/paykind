const contrasenaInput = document.getElementById('contrasena');
const toggleButton = document.getElementById('toggleButton');

toggleButton.addEventListener('click', () => {
  if (contrasenaInput.type === 'password') {
    contrasenaInput.type = 'text';
    toggleButton.src = 'img/mostrar_contraseña.png'; // Cambiar a la imagen de ojo abierto
  } else {
    contrasenaInput.type = 'password';
    toggleButton.src = 'img/ocultar_contraseña.png'; // Cambiar a la imagen de ojo cerrado
  }
});