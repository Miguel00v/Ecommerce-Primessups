function validarEmail(email) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
/*
function requisicao() {
    var requisicao = prompt("Para efetuar a recuperação da sua password, por favor insira o email da sua conta!", "Coloque aqui o seu email");

    if (requisicao !== null && requisicao !== "") {
        var email = requisicao;

        if (validarEmail(email)) {
            $.ajax({
                url: 'recuperarSenha.php',
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                    } else {
                        alert(response.message);
                        window.location.href = 'iniciarSessao.php';
                    }
                },
                error: function(xhr, status, error) {
                    alert('Erro na solicitação AJAX: ' + error);
                }
            });
        } else {
            alert("O formato do e-mail é inválido. Por favor, insira um e-mail válido.");
            window.location.href='recuperarSenha.php';
        }

    } else {
        alert("Email não foi inserido, não poderá recuperar a sua password!");
        window.location.href = 'iniciarSessao.php';
    }
}
*/
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

function codigoVisibility() {
    var senhaInput = document.getElementById("codigo");
    var toggleIcon = document.getElementById("toggleCodigo");

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


// Função para restaurar o campo de senha para o tipo "password"
function voltarNormalPassword() {
    var password = document.getElementById("password");
    removerMensagemErro(password);
    password.type = "password";
}

// Função para restaurar o campo de confirmação de senha para o tipo "password"
function voltarNormalConfirmPassword() {
    var confirmPassword = document.getElementById("codigo");
    removerMensagemErro(confirmPassword);
    confirmPassword.type = "password";
}


// Função para restaurar o campo de confirmação de senha para o tipo "password"
function voltarNormalConfirmPassword() {
    var confirmPassword = document.getElementById("confirmPassword");
    removerMensagemErro(confirmPassword);
    confirmPassword.type = "password";
}


// Função para criar uma mensagem de erro abaixo do input
// Função para criar uma mensagem de erro abaixo do input
function criarMensagemErro(input, mensagem) {
    var spanErro = input.nextElementSibling;
    if (!spanErro || !spanErro.classList.contains('error-message')) {
        spanErro = document.createElement('span');
        spanErro.className = 'error-message';
        input.parentNode.insertBefore(spanErro, input.nextSibling);
    }
    spanErro.textContent = mensagem;
}

// Função para remover a mensagem de erro
function removerMensagemErro(input) {
    var spanErro = input.nextElementSibling;
    if (spanErro && spanErro.classList.contains('error-message')) {
        spanErro.remove();
    }
}

// Function to validate password
function verificarPassword() {
    const password = document.getElementById("password");
    const pattern = /^(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-])(?=.*\d)(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-]{8,}$/;

    if (password.value === "") {
        criarMensagemErro(password, 'Por favor insira uma senha.');
        password.style.borderColor = "red";
        return false;
    }

    if (!pattern.test(password.value)) {
        criarMensagemErro(password, 'A senha deve ter pelo menos 8 caracteres, um caractere especial, uma letra maiúscula e um número.');
        password.style.borderColor = "red";
        return false;
    }

    removerMensagemErro(password);
    password.style.borderColor = "green";
    return true;
}

// Function to validate confirm password
function verificarConfirmPassword() {
    const confirmPassword = document.getElementById("confirmPassword");
    const password = document.getElementById("password");

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

function atualizarBotao() {
    var btnAlterar = document.getElementById("btnAlterar");
    var passwordValido = verificarPassword();
    var confirmPasswordValido = verificarConfirmPassword();
    var codigo = document.getElementById("codigo").value;

    if (passwordValido && confirmPasswordValido && codigo.length === 4) {
        btnAlterar.disabled = false; // Enable button
    } else {
        btnAlterar.disabled = true;
    }
}
document.getElementById("password").addEventListener('input', atualizarBotao);
document.getElementById("confirmPassword").addEventListener('input', atualizarBotao);
document.getElementById("codigo").addEventListener("input", atualizarBotao);

//Reenviar código
function ReenviarCodigo() {
    $.ajax({
        url: 'reenviarCodigoRecupercao.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
            } else {
                alert("Falha ao reenviar o código: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert("Erro ao tentar reenviar o código. Por favor, tente novamente.");
            console.error("Erro na requisição AJAX:", status, error);
        }
    });
}