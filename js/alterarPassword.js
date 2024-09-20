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

function toggleNovaPasswordVisibility() {
    var senhaInput = document.getElementById("novaPassword");
    var toggleIcon = document.getElementById("toggleNovaPassword");

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

function toggleConfirmarNovaPasswordVisibility() {
    var senhaInput = document.getElementById("confirmarNovaPassword");
    var toggleIcon = document.getElementById("toggleConfirmarNovaPassword");

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

function verificarPassword() {
    var password = document.getElementById("password");
    var pattern = /^(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-])(?=.*\d)(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-]{8,}$/;

    if (!pattern.test(password.value)) {
        password.style.borderColor = "red";
        return false;
    }

    password.style.borderColor = "green";
    validarBotao();
    return true;
}

function voltarNormalPassword() {
    var password = document.getElementById("password");
    password.style.borderColor = "";
}

function verificarNovaPassword() {
    var novaPassword = document.getElementById("novaPassword");
    var pattern = /^(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-])(?=.*\d)(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-]{8,}$/;

    if (!pattern.test(novaPassword.value)) {
        novaPassword.style.borderColor = "red";
        return false;
    }

    novaPassword.style.borderColor = "green";
    validarBotao();
    return true;
}

function voltarNormalNovaPassword() {
    var novaPassword = document.getElementById("novaPassword");
    novaPassword.style.borderColor = "";
}

function verificarConfirmPassword() {
    var confirmarNovaPassword = document.getElementById("confirmarNovaPassword");
    var novaPassword = document.getElementById("novaPassword");

    if (novaPassword.value !== confirmarNovaPassword.value) {
        confirmarNovaPassword.style.borderColor = "red";
        return false;
    }

    confirmarNovaPassword.style.borderColor = "green";
    validarBotao();
    return true;
}

function voltarNormalConfirmPassword() {
    var confirmarNovaPassword = document.getElementById("confirmarNovaPassword");
    confirmarNovaPassword.style.borderColor = "";
}

function validarBotao() {
    var password = document.getElementById("password");
    var novaPassword = document.getElementById("novaPassword");
    var confirmarNovaPassword = document.getElementById("confirmarNovaPassword");

    if (password.style.borderColor === 'green' && novaPassword.style.borderColor === 'green' && confirmarNovaPassword.style.borderColor === 'green') {
        document.getElementById("alterarBtn").disabled = false;
    } else {
        document.getElementById("alterarBtn").disabled = true;
    }
}

// Chame validarBotao para definir o estado inicial do botão
validarBotao();