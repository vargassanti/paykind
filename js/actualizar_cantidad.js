function actualizarCantidad(cantidad, txtID){
    let url = '../../secciones/carrito/actualizar_compras.php';
    let formData = new FormData()
    formData.append('action', 'agregar')
    formData.append('txtID', txtID)
    formData.append('cantidad', cantidad)

    fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data => {
            if (data.ok) {

                let divsubtotal = document.getElementById('subtotal_' + txtID)
                divsubtotal.innerHTML = data.sub
            }
        })
}