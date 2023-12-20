function soloLetras(event) {
  var charCode = event.which || event.keyCode;
  var charTyped = String.fromCharCode(charCode);

  // Verificar si el carácter presionado es una letra o espacio en blanco
  if (/^[a-zA-Z ]+$/.test(charTyped)) {
    return true;
  } else if (event.type === 'paste') {
    // Si se está pegando contenido, verificar el contenido del portapapeles
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedText = clipboardData.getData('text');
    if (/^[a-zA-Z ]+$/.test(pastedText)) {
      return true;
    }
  }

  // Si el carácter o el contenido pegado no es una letra o espacio en blanco, no permitir que se ingrese
  event.preventDefault();
  return false;
}
