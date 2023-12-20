function addProducto(txtID) {
    let url = '../../secciones/carrito/añadir_carrito.php';
    let formData = new FormData()
    formData.append('txtID', txtID)

    fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data => {
            if (data.ok) {
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
}

