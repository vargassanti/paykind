const genero = document.getElementById('genero_adicional');
const categoria = document.getElementById('categoria_ropa_adicional');
const talla = document.getElementById('talla');

const categoriasMujer = [
    "Ropa interior Mujer",
    "Camisas de deporte Mujer",
    "Pantalones de deporte Mujer",
    "Calzado",
    "Camisas",
    "Chaquetas",
    "Vestidos",
    "Blusas",
    "Faldas",
    "Pantalones",
    "Leggings",
]

const categoriaHombre = [
    "Camisas de deporte Hombre",
    "Pantalones de deporte Hombre",
    "Ropa interior Hombre",
    "Calzado",
    "Camisas",
    "Polos",
    "Camisetas",
    "Chaquetas",
    "Pantalones",
    "Sudaderas",
]

const tallas_camisas = [
    "XXS",
    "XS",
    "S",
    "M",
    "L",
    "XL",
    "XXL",
    "XXXL",
]

const tallas_pantalones = [
    "26-28",
    "28-30",
    "30-32",
    "33-34",
    "36-37",
    "38-40",
    "42-44",
    "46-48",
    "50-52",
]

const calzado = [
    "35",
    "36",
    "37",
    "38",
    "39",
    "40",
    "41",
    "42",
    "43",
    "44",
    "45",
    "46",
    "47",
]

function categorias(genero_adicional) {
    opcionesFiltradas = []

    let options = `<option value=""selected hidden>Selecciona una opcion</option>`
    if (genero_adicional == "Mujer") {
        for (var i = 0; i < categoriasMujer.length; i++) {
            var opcion = categoriasMujer[i];

            opcionesFiltradas.push(opcion)

            options += `<option value="${opcion}">${opcion}</option>`
        }
    } else if (genero_adicional == "Hombre") {
        for (var i = 0; i < categoriaHombre.length; i++) {
            var opcion = categoriaHombre[i];

            opcionesFiltradas.push(opcion)

            options += `<option value="${opcion}">${opcion}</option>`
        }
    }

    categoria.innerHTML = options;

}
genero.addEventListener("change", e => {
    categorias(e.target.value)
})


function tallas(categoria){
    opcionesFiltradas = []

    let options = `<option value=""selected hidden>Selecciona una opcion</option>`
    if (categoria == "Camisas de deporte Mujer" || categoria == "Camisas" || categoria == "Chaquetas" || categoria == "Vestidos" || categoria == "Blusas" || categoria == "Camisas de deporte Hombre" || categoria == "Polos" || categoria == "Camisetas")  {
        for (var i = 0; i < tallas_camisas.length; i++) {
            var opcion = tallas_camisas[i];

            opcionesFiltradas.push(opcion)

            options += `<option value="${opcion}">${opcion}</option>`
        }
    } else if (categoria == "Pantalones de deporte Mujer" || categoria == "Leggings" || categoria == "Pantalones" || categoria == "Ropa interior Mujer" || categoria == "Faldas" || categoria == "Pantalones de deporte Hombre" || categoria == "Ropa interior Hombre" || categoria == "Sudaderas") {
        for (var i = 0; i < tallas_pantalones.length; i++) {
            var opcion = tallas_pantalones[i];

            opcionesFiltradas.push(opcion)

            options += `<option value="${opcion}">${opcion}</option>`
        }
    } else if (categoria == "Calzado"){
        for (var i = 0; i < calzado.length; i++) {
            var opcion = calzado[i];

            opcionesFiltradas.push(opcion)

            options += `<option value="${opcion}">${opcion}</option>`
        }
    }

    talla.innerHTML = options;

}
categoria.addEventListener("change", e => {
    tallas(e.target.value)
})