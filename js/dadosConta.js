function editarDados() {
    // Mostra os elementos com a classe 'escondido'
    var elementosEscondidos = document.getElementsByClassName('escondido');
    for (var i = 0; i < elementosEscondidos.length; i++) {
        elementosEscondidos[i].style.display = 'block';
    }

    // Esconde os elementos com a classe 'padrao'
    var elementosPadrao = document.getElementsByClassName('padrao');
    for (var j = 0; j < elementosPadrao.length; j++) {
        elementosPadrao[j].style.display = 'none';
    }

    // Habilita os inputs com a classe 'edicaoInput' e limpa seus valores
    var elementosEdicaoInput = document.getElementsByClassName('edicaoInput');
    for (var k = 0; k < elementosEdicaoInput.length; k++) {
        elementosEdicaoInput[k].disabled = false;
        elementosEdicaoInput[k].value = ''; // Limpa o valor atual do input
    }
}

//Validar campos de entrada
document.addEventListener('DOMContentLoaded', function() {
    var nomeInput = document.getElementById('nome');
    var apelidoInput = document.getElementById('apelido');
    var dataNascimentoInput = document.getElementById('dataNascimento');
    var emailInput = document.getElementById('email');
    var imagemInput = document.getElementById('inputImagem');
    var alterarDadosBotao = document.getElementById('alterarDadosConta');
    var previewImagem = document.getElementById('previewImagem');

    // Função para mostrar a pré-visualização da imagem selecionada
    function mostrarPreviewImagem() {
        var file = imagemInput.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            previewImagem.src = e.target.result;
            previewImagem.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

    // Evento de mudança no input de imagem
    imagemInput.addEventListener('change', function() {
        if (imagemInput.files && imagemInput.files[0]) {
            mostrarPreviewImagem();
        }
        validarFormulario();
    });

    // Função para validar o formulário
    function validarFormulario() {
        var nomeValido = verificarNome();
        var apelidoValido = verificarApelido();
        var dataNascimentoValido = verificarDataNascimento();
        var emailValido = verificarEmail();
        var imagemValida = imagemSelecionada();

        aplicarEstilo(nomeInput, nomeValido);
        aplicarEstilo(apelidoInput, apelidoValido);
        aplicarEstilo(dataNascimentoInput, dataNascimentoValido);
        aplicarEstilo(emailInput, emailValido);

        // Habilita o botão se pelo menos um campo for válido e não houver campos inválidos
        if ((nomeInput.value.trim() === '' || nomeValido) &&
            (apelidoInput.value.trim() === '' || apelidoValido) &&
            (dataNascimentoInput.value.trim() === '' || dataNascimentoValido) &&
            (emailInput.value.trim() === '' || emailValido) &&
            (imagemInput.files.length === 0 || imagemValida)) {
            
            alterarDadosBotao.disabled = !(nomeValido || apelidoValido || dataNascimentoValido || emailValido || imagemValida);
        } else {
            alterarDadosBotao.disabled = true;
        }
    }

    // Função para verificar se uma imagem foi selecionada
    function imagemSelecionada() {
        return imagemInput.files !== null && imagemInput.files.length > 0;
    }

    // Função para verificar o nome
    function verificarNome() {
        var nome = nomeInput.value.trim();
        return nome.length >= 3;
    }

    // Função para verificar o apelido
    function verificarApelido() {
        var apelido = apelidoInput.value.trim();
        return apelido.length >= 3;
    }

    // Função para verificar a data de nascimento
    function verificarDataNascimento() {
        var dataNascimento = new Date(dataNascimentoInput.value);
        var dataAtual = new Date();
        var idade = dataAtual.getFullYear() - dataNascimento.getFullYear();
        var mesAtual = dataAtual.getMonth();
        var mesNascimento = dataNascimento.getMonth();
        var diaAtual = dataAtual.getDate();
        var diaNascimento = dataNascimento.getDate();

        if (mesAtual < mesNascimento || (mesAtual === mesNascimento && diaAtual < diaNascimento)) {
            idade--;
        }

        return idade >= 18;
    }

    // Função para verificar o email
    function verificarEmail() {
        var email = emailInput.value.trim();
        var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return pattern.test(email);
    }

    // Função para aplicar estilo aos inputs
    function aplicarEstilo(input, valido) {
        if (input.value.trim().length === 0) {
            input.style.border = ''; // Remove a borda se o campo estiver vazio
        } else if (valido) {
            input.style.border = '2px solid green'; // Aplica a borda verde se o campo for válido
        } else {
            input.style.border = '2px solid red'; // Aplica a borda vermelha se o campo for inválido
        }
    }

    // Adicionar event listeners para os inputs
    nomeInput.addEventListener('input', validarFormulario);
    apelidoInput.addEventListener('input', validarFormulario);
    dataNascimentoInput.addEventListener('input', validarFormulario);
    emailInput.addEventListener('input', validarFormulario);
});