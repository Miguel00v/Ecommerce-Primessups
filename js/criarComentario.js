document.addEventListener('DOMContentLoaded', () => {
    const stars = Array.from(document.querySelectorAll('.rating input[type="radio"]'));

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const starValue = parseInt(star.value);
            
            stars.forEach((s, index) => {
                const label = s.nextElementSibling;
                if (index <= starValue) {
                    //Estrela selecionada e as estrelas à esquerda ficam com cor dourada
                    label.style.color = 'gold';
                    label.style.textShadow = '1px 1px #c60';
                } else {
                    //Estrela que não é selecionada e fica à direita da estrela seleciona fica cinza claro
                    label.style.color = 'lightgray';
                    label.style.textShadow = '1px 1px #bbb';
                }
            });
        });
    });
});

//carrega o nome dos produtos após utilizador selecionar uma categoria com ajax
$(document).ready(function() {
    $('#categoria').change(function() {
        var categoria = $(this).val();
        $.ajax({
            url: 'carregarProdutosAvaliacao.php', 
            method: 'POST',
            data: {categoria: categoria},
            success: function(response) {
                $('#nomeProduto').html('<option disabled selected style="display: none;">Nome do produto</option>' + response);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar produtos:', error);
            }
        });
    });
});