// Definição da função dropLupa no escopo global
function dropLupa() {
    var dropdown = document.getElementById("myDropdown_lupa");
    dropdown.classList.toggle("show");
}

// Fechar o dropdown se clicar fora dele
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn_lupa')) {
        var dropdowns = document.getElementsByClassName("dropdown-contentLupa");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show') && !event.target.closest('.dropdown_lupa')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

//Envio do formulario quando uma tecla é pressionada
$(document).ready(function() {
    $('#pesquisa').on('keyup', function() {
        console.log('Evento keyup detectado');
        var pesquisa = $(this).val();
        console.log('Texto digitado:', pesquisa);

        if (pesquisa.length > 2) {
            $.ajax({
                url: '../php/pesquisaHeader.php',
                method: 'GET',
                data: { q: pesquisa },
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    try {
                        var results = JSON.parse(response);
                        console.log('Resultados analisados:', results);
                        let output = '';
                        results.forEach(function(result) {
                            //Resultado nome do produto e link para página do mesmo
                            output += '<div class="resultItem"><a href="../php/paginaProdutos.php?id=' + result.produtoID + '">' + result.nome + '</a></div>';
                        });
                        $('#results').html(output).show();
                    } catch (e) {
                        console.error('Erro ao analisar JSON:', e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar produtos:', error);
                }
            });
        } else {
            $('#results').html('').hide();
        }
    });
});