document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("mostrarProductos").addEventListener("click", function() {
        var productosRelacionados = document.getElementById("productosRelacionados");
        if (productosRelacionados.style.display === "none") {
            productosRelacionados.style.display = "block";
        } else {
            productosRelacionados.style.display = "none";
        }
    });
});