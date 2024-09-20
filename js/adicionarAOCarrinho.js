$(document).ready(function() {
    $('#btnAdicionarCarrinho').click(function() {
        var produtoID = $('#produtoID').val();
        var quantidade = $('#quantidade').val();

        $.ajax({
            type: 'POST',
            url: 'adicionarAoCarrinho.php',
            data: {
                produtoID: produtoID,
                quantidade: quantidade
            },
            dataType: 'json', 
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    updateCartCount();
                } else if (response.status === 'error') {
                    alert(response.message);
                } else {
                    alert('Resposta inesperada do servidor.');
                }
                console.log('Resposta do servidor:', response);
            },
            error: function(xhr, status, error) {
                alert('Erro ao adicionar produto ao carrinho.');
                console.error('Detalhes do erro:', xhr.responseText);
            }
        });
    });
});