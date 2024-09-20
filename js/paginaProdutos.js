// Esperar até que a página e todas as imagens sejam carregadas
$(window).on('load', function() {
    // Chamar a função verificarStock após o carregamento completo da página e das imagens
    verificarStock();
});

// Função para verificar o estoque e desabilitar elementos se necessário
function verificarStock() {
    var stock = parseInt($('#stock').val());
    var inputQuantidade = $('#visualizarQuantidade');
    var btns = $('.quantidade-btn');
    var btnAdicionarCarrinho = $('#btnAdicionarCarrinho');
    var imagem = $('#imagemProduto');

    if (stock === 0) {
        alert('Produto atualmente indisponível, pedimos desculpa.');
        inputQuantidade.prop('disabled', true);
        inputQuantidade.val('Sem stock');
        btns.prop('disabled', true); // Desabilitar todos os botões de quantidade
        btnAdicionarCarrinho.prop('disabled', true); // Desabilitar botão de adicionar ao carrinho

        // Aplicar estilo de imagem em tons de cinza
        imagem.css('filter', 'grayscale(100%)');
    }
}

$(document).ready(function() {
    $('.avaliacao-estrelas').each(function() {
        var rating = parseFloat($(this).attr('data-avaliacao'));
        var stars = '';
        for (var i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fas fa-star"></i>';
            } else {
                stars += '<i class="far fa-star"></i>';
            }
        }
        $(this).html(stars);
    });
});

$(document).ready(function() {
    //Definindo o valor máximo e mínimo
    var maxQuantidade = parseInt($('#stock').val()); 
    var minQuantidade = 1; 

    // Aumentar quantidade
    $('#aumentarQuantidade').on('click', function() {
        var quantidade = parseInt($('#visualizarQuantidade').val());

        if (quantidade < maxQuantidade) {
            $('#visualizarQuantidade').val(quantidade + 1);
            $('#quantidade').val(quantidade + 1); 
        } else {
            alert("A quantidade que selecionou excede o nosso stock deste produto, pedimos desculpa.");
        }
    });

    // Diminuir quantidade
    $('#diminuirQuantidade').on('click', function() {
        var quantidade = parseInt($('#visualizarQuantidade').val());

        if (quantidade > minQuantidade) {
            $('#visualizarQuantidade').val(quantidade - 1);
            $('#quantidade').val(quantidade - 1); 
        }
    });

    // Verificar a quantidade ao alterar 
    $('#visualizarQuantidade').on('change', function() {
        var quantidade = parseInt($(this).val());

        if (quantidade > maxQuantidade) {
            alert("A quantidade que selecionou excede o nosso stock deste produto, pedimos desculpa.");
            //Reset para o máximo
            $(this).val(maxQuantidade);
            $('#quantidade').val(maxQuantidade); 
        } else if (quantidade < minQuantidade) {
            $(this).val(minQuantidade);
            $('#quantidade').val(minQuantidade); 
        } else {
            $('#quantidade').val(quantidade); 
        }
    });
});

