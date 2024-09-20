$(document).ready(function() {
    $('input[type="checkbox"]').change(function() {
        var $checkbox = $(this);
        var $form = $checkbox.closest('form');
        var metodoID = $form.find('input[name="metodoID1"]').val();
        var $checkboxes = $('input[type="checkbox"]');

        // Desmarcar todas as outras checkboxes
        if ($checkbox.is(':checked')) {
            $checkboxes.not($checkbox).prop('checked', false);
        }

        var data = {
            pagamentoPredefinida: $checkbox.is(':checked') ? 1 : 0,
            metodoID: metodoID
        };

        console.log('Dados enviados:', data); // Verifique o que está sendo enviado

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log('Resposta do servidor:', response); // Adicione esta linha
                if (response.status === 'success') {
                    console.log('Sucesso:', response.message);
                } else {
                    console.error('Erro:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição AJAX:', error);
                console.log('Resposta do servidor (erro):', xhr.responseText); // Adicione esta linha para ver a resposta em erro
            }
        });
    });
});
