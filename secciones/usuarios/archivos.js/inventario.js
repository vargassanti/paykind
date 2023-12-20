$(document).ready(function() {
    $('#search_input_inventario').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_inventario.php',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_inventario tbody').html(response);
            }
        });
    });
});