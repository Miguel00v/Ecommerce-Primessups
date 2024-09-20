// Função para criar uma mensagem de erro abaixo do input
function criarMensagemErro(input, mensagem) {
    var spanErro = input.nextElementSibling;
    if (!spanErro || !spanErro.classList.contains('erro-mensagem')) {
        spanErro = document.createElement('span');
        spanErro.className = 'erro-mensagem';
        input.parentNode.insertBefore(spanErro, input.nextSibling);
    }
    spanErro.textContent = mensagem;
}

// Função para remover a mensagem de erro
function removerMensagemErro(input) {
    var spanErro = input.nextElementSibling;
    if (spanErro && spanErro.classList.contains('erro-mensagem')) {
        spanErro.remove();
    }
}

// Função para verificar o nome
function verificarNome() {
    var nome = document.getElementById("nome");

    if (nome.value == '') {
        criarMensagemErro(nome, 'Por favor insira o seu primeiro nome.');
        nome.style.borderColor = "red";
        nome.style.color = "red";
        return false;
    } else if (nome.value.length < 3) {
        criarMensagemErro(nome, 'Por favor insira um nome válido.');
        nome.style.borderColor = "red";
        nome.style.color = "red";
        return false;
    } else {
        removerMensagemErro(nome);
        nome.style.borderColor = "green";
        nome.style.color = "green";
        return true;
    }
}

// Evento para restaurar a aparência padrão quando o input ao ganhar foco novamente
function voltarNormalNome() {
    var nome = document.getElementById("nome");
    removerMensagemErro(nome);
    nome.style.borderColor = "";
    nome.style.color = "";
}

// Função para verificar o apelido
function verificarApelido() {
    var apelido = document.getElementById("apelido");

    if (apelido.value == '') {
        criarMensagemErro(apelido, 'Por favor insira o seu último nome.');
        apelido.style.borderColor = "red";
        apelido.style.color = "red";
        return false;
    } else if (apelido.value.length < 3) {
        criarMensagemErro(apelido, 'Por favor insira um apelido válido.');
        apelido.style.borderColor = "red";
        apelido.style.color = "red";
        return false;
    } else {
        removerMensagemErro(apelido);
        apelido.style.borderColor = "green";
        apelido.style.color = "green";
        return true;
    }
}

// Evento para restaurar a aparência padrão quando o input ao ganhar foco novamente
function voltarNormalApelido() {
    var apelido = document.getElementById("apelido");
    removerMensagemErro(apelido);
    apelido.style.borderColor = "";
    apelido.style.color = "";
}

// Função para verificar a data de nascimento
function verificarDataNascimento() {
    var dataNascimentoInput = document.getElementById("dataNascimentoDate");
    var dataNascimento = new Date(dataNascimentoInput.value);

    if (!dataNascimentoInput.value) {
        criarMensagemErro(dataNascimentoInput, 'Por favor insira uma data de nascimento válida.');
        dataNascimentoInput.style.borderColor = "red";
        dataNascimentoInput.style.color = "red";
        return false;
    }

    var dataAtual = new Date();
    var idade = dataAtual.getFullYear() - dataNascimento.getFullYear();
    var mesAtual = dataAtual.getMonth() + 1;
    var mesNascimento = dataNascimento.getMonth() + 1;
    var diaAtual = dataAtual.getDate();
    var diaNascimento = dataNascimento.getDate();

    if (mesAtual < mesNascimento || (mesAtual === mesNascimento && diaAtual < diaNascimento)) {
        idade--;
    }

    if (idade >= 18 && idade < 80) {
        removerMensagemErro(dataNascimentoInput);
        dataNascimentoInput.style.borderColor = "green";
        dataNascimentoInput.style.color = "green";
        return true;
    } else {
        criarMensagemErro(dataNascimentoInput, 'Você deve ter pelo menos 18 anos para se cadastrar.');
        dataNascimentoInput.style.borderColor = "red";
        dataNascimentoInput.style.color = "red";
        return false;
    }
}

// Função para verificar o email
function verificarEmail() {
    var email = document.getElementById("email");
    var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (email.value === "") {
        criarMensagemErro(email, "Por favor insira um email.");
        email.style.borderColor = "red";
        email.style.color = "red";
        return false;
    } else if (!pattern.test(email.value)) {
        criarMensagemErro(email, "Por favor insira um email válido.");
        email.style.borderColor = "red";
        email.style.color = "red";
        return false;
    } else {
        removerMensagemErro(email);
        email.style.borderColor = "green";
        email.style.color = "green";
        return true;
    }
}

// Evento para restaurar a aparência padrão quando o input ao ganhar foco novamente
function voltarNormalEmail() {
    var email = document.getElementById("email");
    removerMensagemErro(email);
    email.style.borderColor = "";
    email.style.color = "";
}

// Função para visualizar password inserida
function togglePasswordVisibility() {
    var senhaInput = document.getElementById("password");
    var toggleIcon = document.getElementById("togglePassword");

    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        senhaInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
}

// Função para visualizar password inserida
function toggleConfirmPasswordVisibility() {
    var senhaInput = document.getElementById("confirmPassword");
    var toggleIcon = document.getElementById("toggleConfirmPassword");

    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        senhaInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
}

// Função para verificar a senha
function verificarPassword() {
    var password = document.getElementById("password");
    var pattern = /^(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-])(?=.*\d)(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-]{8,}$/;

    if (password.value === "") {
        criarMensagemErro(password, 'Por favor insira uma senha.');
        password.style.borderColor = "red";
        return false;
    }

    if (!pattern.test(password.value)) {
        criarMensagemErro(password, 'Por favor insira uma senha com pelo menos 8 caracteres, um caractere especial, uma letra maiúscula e um número.');
        password.style.borderColor = "red";
        password.type = "text";
        return false;
    }

    removerMensagemErro(password);
    password.style.borderColor = "green";
    return true;
}

// Função para restaurar o campo de senha para o tipo "password"
function voltarNormalPassword() {
    var password = document.getElementById("password");
    removerMensagemErro(password);
    password.type = "password";
}

// Função para verificar a confirmação de senha
function verificarConfirmPassword() {
    var confirmPassword = document.getElementById("confirmPassword");
    var password = document.getElementById("password");

    if (confirmPassword.value === "") {
        criarMensagemErro(confirmPassword, 'Por favor confirme sua senha.');
        confirmPassword.style.borderColor = "red";
        return false;
    }

    if (password.value !== confirmPassword.value) {
        criarMensagemErro(confirmPassword, 'As senhas não coincidem.');
        confirmPassword.style.borderColor = "red";
        password.style.borderColor = "red";
        return false;
    }

    removerMensagemErro(confirmPassword);
    confirmPassword.style.borderColor = "green";
    password.style.borderColor = "green";
    return true;
}

// Função para restaurar o campo de confirmação de senha para o tipo "password"
function voltarNormalConfirmPassword() {
    var confirmPassword = document.getElementById("confirmPassword");
    removerMensagemErro(confirmPassword);
    confirmPassword.type = "password";
}

// Verificar função
function verificarFuncao() {
    var funcao = document.getElementById("funcao");

    if (funcao.value === '') {
        criarMensagemErro(funcao, 'Por favor selecione uma função.');
        funcao.style.borderColor = "red";
        return false;
    } else {
        removerMensagemErro(funcao);
        funcao.style.borderColor = "green";
        return true;
    }
}

// Verifica todos os campos do formulário
function verificarForm() {
    var checkBox = document.getElementById("aceitarTermos");
    var formularioValido = verificarNome() && verificarApelido() && verificarDataNascimento() && verificarEmail() && verificarPassword() && verificarConfirmPassword() && verificarFuncao() && checkBox.checked;

    if (!formularioValido) {
        alert("Preencha todos os campos corretamente");
    }
}

// Adicionando eventos de foco para restaurar a aparência padrão
document.getElementById("nome").addEventListener("focus", voltarNormalNome);
document.getElementById("apelido").addEventListener("focus", voltarNormalApelido);
document.getElementById("email").addEventListener("focus", voltarNormalEmail);
document.getElementById("password").addEventListener("focus", voltarNormalPassword);
document.getElementById("confirmPassword").addEventListener("focus", voltarNormalConfirmPassword);
document.getElementById("funcao").addEventListener("focus", function () {
    removerMensagemErro(this);
    this.style.borderColor = "";
});