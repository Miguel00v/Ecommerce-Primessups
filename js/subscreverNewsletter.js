function verificarEmail() {
    const email = document.getElementById('email').value;
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!pattern.test(email)) {
        alert('Por favor, insira um endereço de email válido.');
        document.getElementById('email').focus();
        return false;
    }
    return true;
}
