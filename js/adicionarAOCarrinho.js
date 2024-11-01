$(document).ready(function() {
    $('#btnAdicionarCarrinho').click(function() {
        var produtoID = $('#produtoID').val();
        var quantidade = $('#quantidade').val();

        console.log('Produto ID:', produtoID);
        console.log('Quantidade:', quantidade);

        $.ajax({
            type: 'POST',
            url: '../php/adicionarAOcarrinho.php', 
            data: {
                produtoID: produtoID,
                quantidade: quantidade
            },
            dataType: 'json', 
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    updateCartCount(); // Atualiza a contagem do carrinho, se necessário
                } else if (response.status === 'error') {
                    alert(response.message);
                } else {
                    alert('Resposta inesperada do servidor.');
                }
                console.log('Resposta do servidor:', response);
            },
            error: function(xhr, status, error) {
                console.log('Dados enviados:', { produtoID: produtoID, quantidade: quantidade });
                console.error('Detalhes do erro:', xhr.responseText);
                console.error('Código de status:', xhr.status);
                alert('Erro ao adicionar produto ao carrinho. Código: ' + xhr.status);
            }
        });
    });
});