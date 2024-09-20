//função para visualizar password inserida
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