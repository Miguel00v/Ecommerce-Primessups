$(document).ready(function() {
    $('input[type="checkbox"]').change(function() {
        var $checkbox = $(this);
        var $form = $checkbox.closest('form');
        var dadosFiscaisID = $form.find('input[name="dadosFiscaisID"]').val();

        if ($checkbox.is(':checked')) {
            $('input[type="checkbox"]').not($checkbox).prop('checked', false);
        }

        var data = {
            dadosFiscaisPredefinida: $checkbox.is(':checked') ? 1 : 0,
            dadosFiscaisID: dadosFiscaisID
        };

        console.log("Data to be sent:", data);

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: data,
            success: function(response) {
                console.log('Dado fiscal atualizado com sucesso.', response);
            },
            error: function(xhr, status, error) {
                console.error('Ocorreu um erro ao atualizar o dado fiscal:', error);
            }
        });
    });
});