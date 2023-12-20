$(document).ready(function() {
    $('#search_input_vendedores').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_vendedores.php',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_vendedores tbody').html(response);
            }
        });
    });
});