$(document).ready(function() {
    $('#search_input_clientes').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_clientes.php',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_clientes tbody').html(response);
            }
        });
    });
});