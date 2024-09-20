function toggleForm(formId, button) {
    const form = document.getElementById(formId);
    const setaBaixo = button.querySelector('#setaBaixo');
    const setaDireita = button.querySelector('#setaDireita');

     // Fechar qualquer outro formulário aberto
     const allForms = document.getElementsByClassName('posicaoForms');
     const allButtons = document.getElementsByClassName('dropbtn');
     
     for (let i = 0; i < allForms.length; i++) {
         if (allForms[i].id !== formId) {
             allForms[i].classList.remove('show'); // Fecha outros formulários
 
             // Reseta os ícones de todos os outros botões
             const otherButtonSetaBaixo = allButtons[i].querySelector('#setaBaixo');
             const otherButtonSetaDireita = allButtons[i].querySelector('#setaDireita');
             otherButtonSetaBaixo.style.display = "block";
             otherButtonSetaDireita.style.display = "none";

             allButtons[i].classList.remove('active');
         }
     }
    
    // Alterna a visibilidade do formulário
    form.classList.toggle('show');
    
    // Alterna a seta apenas no botão clicado
    if (form.classList.contains('show')) {
        setaBaixo.style.display="none";
        setaDireita.style.display= "block";
        button.classList.add('active');
    } else {
        setaBaixo.style.display="block";
        setaDireita.style.display= "none";
        button.classList.remove('active');
    }
}

// Fecha os formulários e reseta as setas quando clicar fora
window.onclick = function(event) {
    // Verifica se o clique foi fora de qualquer botão dropbtn ou dos formulários abertos
    if (!event.target.closest('.dropbtn') && !event.target.closest('.posicaoForms')) {
        const forms = document.getElementsByClassName('posicaoForms');
        for (let i = 0; i < forms.length; i++) {
            forms[i].classList.remove('show'); // Fecha todos os formulários abertos
        }

        const allButtons = document.getElementsByClassName('dropbtn');
        for (let i = 0; i < allButtons.length; i++) {
            const setaBaixo = allButtons[i].querySelector('#setaBaixo');
            const setaDireita = allButtons[i].querySelector('#setaDireita');
            setaBaixo.style.display = "block";
            setaDireita.style.display = "none";
        }
    }
}

function confirmarDesativacao() {
    if (confirm("Tem certeza que deseja desativar sua conta? Esta ação é irreversível.")) {
        //Se o usuário confirmar, envia o formulário de desativação
        document.getElementById('formDesativar').submit();
    } else {
        //Se o usuário clicar em "Cancelar" ou "Não"
        alert("Desativação da conta cancelada.");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var nomeInput = document.getElementById('nome');
    var apelidoInput = document.getElementById('apelido');
    var dataNascimentoInput = document.getElementById('dataNascimento');
    var emailInput = document.getElementById('email');
    var alterarDadosBotao = document.getElementById('btnAlterarDadosPessoais');

    // Elementos para mensagens de erro
    var erroNome = document.getElementById('erroNome');
    var erroApelido = document.getElementById('erroApelido');
    var erroDataNascimento = document.getElementById('erroDataNascimento');
    var erroEmail = document.getElementById('erroEmail');

    // Função para validar o formulário
    function validarFormulario() {
        var nomeValido = verificarNome();
        var apelidoValido = verificarApelido();
        var dataNascimentoValido = verificarDataNascimento();
        var emailValido = verificarEmail();

        aplicarEstilo(nomeInput, nomeValido, erroNome);
        aplicarEstilo(apelidoInput, apelidoValido, erroApelido);
        aplicarEstilo(dataNascimentoInput, dataNascimentoValido, erroDataNascimento);
        aplicarEstilo(emailInput, emailValido, erroEmail);

        // Habilita o botão se pelo menos um campo for válido e não houver campos inválidos
        alterarDadosBotao.disabled = !(nomeValido || apelidoValido || dataNascimentoValido || emailValido);
    }

    // Função para verificar o nome
    function verificarNome() {
        var nome = nomeInput.value.trim();
        if (nome.length >= 3) {
            erroNome.textContent = ''; // Limpa mensagem de erro
            return true;
        } else {
            erroNome.textContent = 'O nome deve ter pelo menos 3 caracteres.';
            return false;
        }
    }

    // Função para verificar o apelido
    function verificarApelido() {
        var apelido = apelidoInput.value.trim();
        if (apelido.length >= 3) {
            erroApelido.textContent = ''; // Limpa mensagem de erro
            return true;
        } else {
            erroApelido.textContent = 'O apelido deve ter pelo menos 3 caracteres.';
            return false;
        }
    }

    // Função para verificar a data de nascimento
    function verificarDataNascimento() {
        var dataNascimento = new Date(dataNascimentoInput.value);
        var dataAtual = new Date();

        if (isNaN(dataNascimento)) {
            erroDataNascimento.textContent = 'Por favor, insira uma data válida.';
            return false;
        }

        var idade = dataAtual.getFullYear() - dataNascimento.getFullYear();
        var mesAtual = dataAtual.getMonth();
        var mesNascimento = dataNascimento.getMonth();
        var diaAtual = dataAtual.getDate();
        var diaNascimento = dataNascimento.getDate();

        if (mesAtual < mesNascimento || (mesAtual === mesNascimento && diaAtual < diaNascimento)) {
            idade--;
        }

        if (idade >= 18) {
            erroDataNascimento.textContent = ''; // Limpa mensagem de erro
            return true;
        } else {
            erroDataNascimento.textContent = 'Você deve ter pelo menos 18 anos.';
            return false;
        }
    }

    // Função para verificar o email
    function verificarEmail() {
        var email = emailInput.value.trim();
        var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (pattern.test(email)) {
            erroEmail.textContent = ''; // Limpa mensagem de erro
            return true;
        } else {
            erroEmail.textContent = 'Por favor, insira um e-mail válido.';
            return false;
        }
    }

    // Função para aplicar estilo aos inputs e mensagens de erro
    function aplicarEstilo(input, valido, erroElemento) {
        if (input.value.trim().length === 0) {
            input.style.border = ''; // Remove a borda se o campo estiver vazio
            erroElemento.textContent = ''; // Remove mensagem de erro se o campo estiver vazio
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


document.addEventListener('DOMContentLoaded', function() {
    var inputFotoPerfil = document.getElementById('fotoPerfilDados');
    var previewImagem = document.getElementById('previewImagem');
    var previewImagemContainer = document.querySelector('.previewImagem');
    var btnAtualizarFotoPerfil = document.getElementById('btnAtualizarFotoPerfil');

    // Função para pré-visualizar a imagem selecionada
    function mostrarPreviewImagem() {
        var arquivo = inputFotoPerfil.files[0]; // Obtém o primeiro arquivo selecionado
        
        // Verifica se existe um arquivo e se é uma imagem
        if (arquivo && arquivo.type.startsWith('image/')) {
            var leitor = new FileReader(); // Cria um leitor de arquivos

            // Função para executar quando o leitor carregar a imagem
            leitor.onload = function(e) {
                previewImagem.src = e.target.result; // Define o src da imagem de pré-visualização
                previewImagem.style.display = 'block'; // Exibe a imagem
                previewImagemContainer.style.display = 'block'; // Exibe o container da pré-visualização
            };

            leitor.readAsDataURL(arquivo); // Lê o conteúdo da imagem selecionada
            btnAtualizarFotoPerfil.disabled = false; // Habilita o botão de submissão
        } else {
            // Se não houver imagem ou o arquivo não for do tipo correto
            previewImagem.src = ''; // Limpa o src da imagem
            previewImagemContainer.style.display = 'none'; // Esconde o container da pré-visualização
            btnAtualizarFotoPerfil.disabled = true; // Desabilita o botão
        }
    }

    // Função para verificar se uma imagem foi selecionada
    function verificarImagemSelecionada() {
        var arquivo = inputFotoPerfil.files[0];
        return arquivo && arquivo.type.startsWith('image/');
    }

    // Adiciona o event listener para pré-visualizar a imagem sempre que for selecionada
    inputFotoPerfil.addEventListener('change', function() {
        mostrarPreviewImagem(); // Chama a função para exibir a pré-visualização

        // Verifica se uma imagem foi selecionada e habilita/desabilita o botão
        if (verificarImagemSelecionada()) {
            btnAtualizarFotoPerfil.disabled = false; // Habilita o botão
        } else {
            btnAtualizarFotoPerfil.disabled = true; // Desabilita o botão
        }
    });
});