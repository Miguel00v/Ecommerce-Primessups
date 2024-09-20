function formatarCodigoPostal() {
    let input = document.getElementById('codigoPostal');
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    if (value.length > 4) {
        input.value = value.slice(0, 4) + '-' + value.slice(4, 7);
    } else {
        input.value = value;
    }
}