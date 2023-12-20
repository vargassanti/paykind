$(document).ready(function() {
    $('#search_input_pendientes').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=pendientes',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_pendientes tbody').html(response);
            }
         });
    });
});

$(document).ready(function() {
    $('#search_input_en_proceso').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=en_proceso',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_en_proceso tbody').html(response);
            }
         });
    });
});

$(document).ready(function() {
    $('#search_input_aprobados').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=aprobados',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_aprobados tbody').html(response);
            }
         });
    });
});

$(document).ready(function() {
    $('#search_input_espera_envio').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=espera_envio',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_espera_envio tbody').html(response);
            }
         });
    });
});

$(document).ready(function() {
    $('#search_input_en_transito').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=en_transito',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_en_transito tbody').html(response);
            }
         });
    });
});

$(document).ready(function() {
    $('#search_input_completado').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=completado',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_completado tbody').html(response);
            }
         });
    });
});

$(document).ready(function() {
    $('#search_input_cancelado').on('input', function() {
        var searchText = $(this).val().trim();

        $.ajax({
            type: 'POST',
            url: 'buscar_compras_estados.php?c=cancelado',
            data: {
                query: searchText
            },
            success: function(response) {
                $('#tabla_compras_cancelado tbody').html(response);
            }
         });
    });
});