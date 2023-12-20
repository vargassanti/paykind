$(document).ready(function() {
    $('#search_input_tiendas').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_tiendas.php',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_tiendas tbody').html(response);
            }
        });
    });
});