$(document).ready(function() {
    $('#search_input_ventas').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras.php',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_ventas tbody').html(response);
            }
        });
    });
});