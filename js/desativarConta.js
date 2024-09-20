function confirmarDesativacao() {
    if (confirm("Tem certeza que deseja desativar sua conta? Esta ação é irreversível.")) {
        //Se o usuário confirmar, envia o formulário de desativação
        document.getElementById('formDesativar').submit();
    } else {
        //Se o usuário clicar em "Cancelar" ou "Não"
        alert("Desativação da conta cancelada.");
    }
}