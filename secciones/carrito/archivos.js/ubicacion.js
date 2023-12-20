const municipio = document.getElementById("municipio");
const comuna = document.getElementById("comuna");
const comuna2 = document.getElementById("comuna2");
const barrio = document.getElementById("barrio");
const barrio2 = document.getElementById("barrio2");

let opcionesfiltradas = [];

function comunas(municipios){
    opcionesfiltradas = []
    let options = `<option selected hidden>Selecciona una comuna:</option>`

    for (var i = 0; i < comuna2.options.length; i++){
        var opcion = comuna2.options[i];
        var muni = opcion.getAttribute('data-comuna')
        if (muni === municipios){
            var opcionObj = {
                nombre: opcion.textContent,
                id: opcion.value,
                id_municipio: muni
            };
            opcionesfiltradas.push(opcionObj)
            options +=`<option value="${opcionObj.id}">${opcionObj.nombre}</option>`
        }
    }
    comuna.innerHTML = options;

}

municipio.addEventListener("change", e=>{
    comunas(e.target.value)
})

let opcionesfiltradas2 = [];

function barrios(comunas){
    opcionesfiltradas2 = []
    let options = `<option selected hidden>Selecciona un barrio:</option>`

    for (var i = 0; i < barrio2.options.length; i++){
        var opcion = barrio2.options[i];
        // console.log(opcion);
        var comu = opcion.getAttribute('data-barrio')
        if (comu === comunas){
            var opcionObj = {
                nombre: opcion.textContent,
                id: opcion.value,
                id_comuna: comu
            };
            opcionesfiltradas2.push(opcionObj)
            options +=`<option value="${opcionObj.id}">${opcionObj.nombre}</option>`
        }
    }
    barrio.innerHTML = options;

}

comuna.addEventListener("change", e=>{
    // console.log(e.target.value);
    barrios(e.target.value)
})