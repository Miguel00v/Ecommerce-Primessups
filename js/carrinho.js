$(document).ready(function() {

    // Aumentar quantidade
    $('.aumentarQuantidade').on('click', function() {
        var $form = $(this).closest('form');
        var produtoID = $form.find('.produtoID').val();
        var estoque = parseInt($form.find('.stock').val());
        var quantidade = parseInt($form.find('.visualizarQuantidade').val());

        if (quantidade < estoque) {
            quantidade++;
            $form.find('.visualizarQuantidade').val(quantidade);
            $form.find('.quantidade').val(quantidade);

            var preco = parseFloat($form.closest('div').find('.p').text().replace(',', '.'));
            var subtotal = calcularSubtotal(preco, quantidade);
            $form.closest('div').find('.subtotal').text(subtotal.toFixed(2).replace('.', ','));

            atualizarTotais();
            atualizarQuantidadeNoServidor(produtoID, quantidade);
        } else {
            alert("A quantidade selecionada excede nosso estoque deste produto.");
        }
    });

    // Diminuir quantidade
    $('.diminuirQuantidade').on('click', function() {
        var $form = $(this).closest('form');
        var produtoID = $form.find('.produtoID').val();
        var quantidade = parseInt($form.find('.visualizarQuantidade').val());

        if (quantidade > 1) {
            quantidade--;
            $form.find('.visualizarQuantidade').val(quantidade);
            $form.find('.quantidade').val(quantidade);

            var preco = parseFloat($form.closest('div').find('.p').text().replace(',', '.'));
            var subtotal = calcularSubtotal(preco, quantidade);
            $form.closest('div').find('.subtotal').text(subtotal.toFixed(2).replace('.', ','));

            atualizarTotais();
            atualizarQuantidadeNoServidor(produtoID, quantidade);
        }
    });

    // Função para calcular subtotal
    function calcularSubtotal(preco, quantidade) {
        return preco * quantidade;
    }

    // Função para atualizar os totais na página
    function atualizarTotais() {
        var totalGeral = 0;
        
        $('.subtotal').each(function() {
            var subtotal = parseFloat($(this).text().replace(',', '.'));
            totalGeral += subtotal;
        });

        $('.total-geral').text(totalGeral.toFixed(2).replace('.', ',') + ' €');
    }

    // Função para atualizar quantidade no servidor
    function atualizarQuantidadeNoServidor(produtoID, quantidade) {
        $.ajax({
            url: 'atualizarQuantidade.php',
            method: 'POST',
            data: { produtoID: produtoID, quantidade: quantidade },
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    atualizarTotaisNaPagina();
                } else {
                    console.error('Erro ao atualizar quantidade:', jsonResponse.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro ao atualizar quantidade:', error);
            }
        });
    }

    // Função para atualizar totais na página após atualização no servidor
    function atualizarTotaisNaPagina() {
        $.ajax({
            url: 'calcularTotal.php', 
            method: 'GET',
            success: function(response) {
                try {
                    var jsonResponse = JSON.parse(response);
        
                    // Verifica se o totalGeral é um número válido
                    if (!isNaN(jsonResponse.totalGeral) && !isNaN(jsonResponse.subtotal)) {
                        var totalGeralNum = parseFloat(jsonResponse.totalGeral); 
                        var subtotalGeralNum = parseFloat(jsonResponse.subtotal);
        
                        var totalGeralFormatado = totalGeralNum.toFixed(2).replace('.', ',');
                        var subtotalGeralFormatado = subtotalGeralNum.toFixed(2).replace('.', ',');
        
                        $('.total-geral').text(totalGeralFormatado + ' €');
                        $('.subtotal').text(subtotalGeralFormatado + ' €');
                    } else {
                        console.error('Erro: Total geral não é um número válido.');
                    }
                } catch (e) {
                    console.error('Erro ao fazer parsing da resposta JSON:', e);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro ao calcular total:', error);
            }
        });
    }
})