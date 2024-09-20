function verificarEntradaCupao() {
    var cupao = document.getElementById("cupao").value;
    var mensagem = document.getElementById('selecaoCupao');

    if (cupao === '') {
        mensagem.textContent = 'Não selecionou nenhum cupão';
    } else {
        mensagem.textContent = 'Cupão selecionado';
    }
}

//Inserção de cupões
$(document).ready(function() {
    $('#formCupao').on('submit', function(e) {
        e.preventDefault();

        var cupao = $('#cupao').val();

        $.ajax({
            type: 'POST',
            url: 'checkout.php',
            data: { cupao: cupao },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    $('#descontoValor p').html('0,00 €'); // Exibir 0,00 € se houver erro
                    $('#totalValor p').html($('#totalValor p').data('default'));
                } else {
                    $('#cupao').prop('disabled', true);
                    $('#formCupao button[type="submit"]').prop('disabled', true);
                    $('#formCupao div p').html('Cupão aplicado: ' + response.cupao);
                    $('#descontoValor p').html(response.desconto + ' €');
                    $('#totalValor p').html(response.total + ' €');
                    $('#totalPagar').val(response.total);
                    $('#desconto').val(response.desconto);
                    $('#cupaoID').val(response.cupaoID);
                }
            },
            error: function(xhr, status, error) {
                alert('Erro ao processar o cupão.');
                console.error(xhr.responseText);
            }
        });
    });
});

//Formulário de verificação de identidade método de pagamento
function revelarForm(id) {
    const form = document.getElementById('confirmacaoIdentidade-' + id);
    const oculto = document.getElementById('cartao-' + id);
    const dados = document.getElementById('dados-cartao-' + id);
    const button = document.querySelector('#dados-cartao-' + id + ' + button');
    const buttonIcon = button.querySelector('i');

    if (button.dataset.confirmed === 'true') {
        // Alternar a exibição dos dados se a senha já foi confirmada
        if (dados.style.display === 'none' || dados.style.display === '') {
            oculto.style.display = 'none';
            dados.style.display = 'block';
            buttonIcon.classList.remove('fa-eye-slash');
            buttonIcon.classList.add('fa-eye');
        } else {
            dados.style.display = 'none';
            oculto.style.display = 'block';
            buttonIcon.classList.remove('fa-eye');
            buttonIcon.classList.add('fa-eye-slash');
        }
    } else {
        // Exibir ou ocultar o formulário de confirmação de identidade
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
}