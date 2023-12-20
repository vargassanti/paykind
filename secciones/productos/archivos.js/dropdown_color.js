document.getElementById("color").addEventListener("click", function() {
    var opciones = this.options;
    for (var i = 0; i < opciones.length; i++) {
        opciones[i].addEventListener("mousedown", function(e) {
            e.preventDefault();
            this.selected = !this.selected;
            return false;
        });
    }
});