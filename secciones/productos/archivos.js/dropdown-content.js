// Obtener todos los botones y menús desplegables
var dropdownBtns = document.querySelectorAll(".dropbtn");
var dropdowns = document.querySelectorAll(".dropdown-content");

// Agregar eventos clic a cada botón
dropdownBtns.forEach(function (btn, index) {
  btn.addEventListener("click", function() {
    if (dropdowns[index].style.display === "block") {
      dropdowns[index].style.display = "none";
    } else {
      dropdowns[index].style.display = "block";
    }
  });
});

// Cerrar los menús desplegables si el usuario hace clic fuera de ellos
document.addEventListener("click", function(event) {
  dropdownBtns.forEach(function (btn, index) {
    if (event.target !== btn && event.target !== dropdowns[index]) {
      dropdowns[index].style.display = "none";
    }
  });
});
