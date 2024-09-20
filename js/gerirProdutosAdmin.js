function filtrarEncomendas(){

    //verificar se algum campo foi introduzido
    nome = document.getElementById("nome").value;
    categoria = document.getElementById("categoria").value;
    destaque = document.getElementById("destaque").value;
    if(nome !== '' || categoria !==''|| destaque !==''){

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

        var queryNome = $('#nome').val();
        var queryCategoria = $('#categoria').val();
        var queryDestaque = $('#destaque').val();
        $.ajax({
            url: 'pesquisaProdutosAdmin.php',
            type: 'GET',
            data: {
                nome: queryNome,
                categoria: queryCategoria,
                destaque: queryDestaque
            },
            success: function(response) {
                // Ocultar 
                $('#produtosPadrao').hide();
                // Exibir os resultados da pesquisa
                $('#resultados').html(response);
            }
        });
    });

    //Limpar filtragem feita
$('#limpar').on('click', function() {
    // Limpar campos do formulário
    $('#nome').val('');
    $('#categoria').val('Categoria');
    $('#destaque').val('Destaque');
    // Exibir encomendas existentes novamente
    $('#produtosPadrao').show();
    // Limpar resultados da pesquisa
    $('#resultados').empty();
});

});