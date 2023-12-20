const id_categoria = document.getElementById("id_categoria");
const id_sub_categoria = document.getElementById("id_sub_categoria");
const id_sub_categoria2 = document.getElementById("id_sub_categoria2");

let opcionesFiltradas = [];

function sub_categoria(categoria){
    opcionesFiltradas = []

    let options = `<option value=""selected hidden></option>`
    for(var i = 0; i< id_sub_categoria2.options.length; i++){
        var opcion = id_sub_categoria2.options[i];
        var id_cat = opcion.getAttribute('data-categoria')
        if(id_cat === categoria){
            var opcionObj = {
                nombre: opcion.textContent,
                id: opcion.value,
                id_categoria: id_cat
            };
            opcionesFiltradas.push(opcionObj)

            options += `<option value="${opcionObj.id}">${opcionObj.nombre}</option>`
        }
    }
    id_sub_categoria.innerHTML = options;
    
}
id_categoria.addEventListener("change", e =>{
    sub_categoria(e.target.value)
})
