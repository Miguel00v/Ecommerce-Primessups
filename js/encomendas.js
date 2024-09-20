function filtrarEncomendas(){

    //verificar se algum campo foi introduzido
    $numeroEncomenda = document.getElementById("numeroEncomenda").value;
    $dataEncomenda = document.getElementById("dataEncomenda").value;
    if($numeroEncomenda !== '' || $dataEncomenda !==''){

        //butão filtrar fica habilitado
        document.getElementById("filtrar").disabled = false;

    } else {

        document.getElementById("filtrar").disabled = true;
    }
}

//chamada assincorna para exibir os resultados da pesquisa e esconder os existentes
$(document).ready(function() {
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();
        
        var queryEncomenda = $('#numeroEncomenda').val();
        var queryData = $('#dataEncomenda').val();
        
        $.ajax({
            url: 'pesquisaEncomendas.php',
            type: 'GET',
            data: {
                numero: queryEncomenda,
                data: queryData
            },
            success: function(response) {
                // Ocultar encomendas existentes
                $('#encomendasPadrao').hide();
                // Exibir os resultados da pesquisa
                $('#resultados').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Erro na solicitação AJAX:', status, error);
            }
        });
    });
    
    $('#limpar').on('click', function() {
        $('#numeroEncomenda').val('');
        $('#dataEncomenda').val('');
        $('#encomendasPadrao').show();
        $('#resultados').empty();
    });
});
