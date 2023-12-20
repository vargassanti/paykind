document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search_input');
    const resultadosContainer = document.getElementById('resultados-en-tiempo-real');

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value;
        if (searchTerm.length >= 1) {
            // Realizar una solicitud AJAX para buscar en tiempo real
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'buscar_productos.php?q=' + searchTerm + '&partial=true', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar el contenedor de resultados en tiempo real con la parte específica de la respuesta
                    resultadosContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        } else {
            xhr.open('GET', 'buscar_productos.php');
            resultadosContainer.innerHTML = ''; // Borrar los resultados si la búsqueda es muy corta
        }
    });
});

