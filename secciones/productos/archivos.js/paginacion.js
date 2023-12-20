const registrosPorPagina = 10; // Número de registros por página
    const tabla = document.getElementById('tabla_compras');
    const filas = tabla.getElementsByTagName('tr');
    const totalRegistros = filas.length - 1; // Restamos 1 para excluir la fila de encabezado

    // Función para mostrar la página deseada
    function mostrarPagina(pagina) {
        const inicio = (pagina - 1) * registrosPorPagina;
        const fin = inicio + registrosPorPagina;

        for (let i = 1; i < filas.length; i++) {
            if (i > inicio && i <= fin) {
                filas[i].style.display = '';
            } else {
                filas[i].style.display = 'none';
            }
        }
    }

    // Función para crear los botones de paginación
    function crearBotonesPaginacion() {
        const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);

        const paginacion = document.getElementById('paginacion');
        if (totalPaginas <= 1) {
            paginacion.style.display = 'none'; // Ocultar el contenedor de paginación si solo hay una página
        } else {
            for (let i = 1; i <= totalPaginas; i++) {
                const boton = document.createElement('button');
                boton.innerText = i;
                boton.addEventListener('click', function() {
                    mostrarPagina(i);
                });
                paginacion.appendChild(boton);
            }
        }
    }

// Mostrar la primera página al cargar la tabla
mostrarPagina(1);
// Crear botones de paginación
crearBotonesPaginacion();