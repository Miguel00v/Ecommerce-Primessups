function reenviarCodigo() {
    console.log('Reenviar código button clicked');
    fetch('../php/gerarCodigoAcessoAdministrador.php')  // Ensure this path is correct
        .then(response => {
            console.log('Fetch response received');
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
}
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