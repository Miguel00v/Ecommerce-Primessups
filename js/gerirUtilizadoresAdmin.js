function filtrarEncomendas(){

    //verificar se algum campo foi introduzido
    $nome = document.getElementById("nome").value;
    $apelido = document.getElementById("apelido").value;
    $email = document.getElementById("email").value;
    $funcao = document.getElementById("funcao").value;
    if($nome !== '' || $apelido !=='' || $email !==''  || $funcao !==''){

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
        var queryApelido = $('#apelido').val();
        var queryEmail = $('#email').val();
        var queryFuncao = $('#funcao').val();

        $.ajax({
            url: 'pesquisaUtilizadoresAdminDesktop.php',
            type: 'GET',
            data: {
                nome: queryNome,
                apelido: queryApelido,
                email: queryEmail,
                funcao: queryFuncao
            },
            success: function(response) {
                // Ocultar 
                $('#utilizadoresPadrao').hide();
                // Exibir os resultados da pesquisa
                $('#resultado').html(response);
            }
        });
    });

    //Limpar filtragem feita
$('#limpar').on('click', function() {
    // Limpar campos do formulário
    $('#nome').val('');
    $('#apelido').val('');
    $('#email').val('');
    $('#funcao').val('');
    // Exibir encomendas existentes novamente
    $('#utilizadoresPadrao').show();
    // Limpar resultados da pesquisa
    $('#resultado').empty();
});

});

function confirmarDesativacao(url) {
    if (confirm("Tem certeza que deseja eliminar esta conta? Esta ação é irreversível.")) {
        window.location.href = url;
    } else {
        alert("Desativação da conta cancelada.");
    }
}