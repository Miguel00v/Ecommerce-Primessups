function removerImagem(imagemID) {
    $.ajax({
        url: 'removerImagemProdutoAdmin.php',
        type: 'POST',
        data: { imagemID: imagemID },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {
                $('#imagem-' + imagemID).remove();
                alert('Imagem removida com sucesso.');
            } else {
                alert(data.message || 'Erro ao remover imagem.');
            }
        },
        error: function(xhr, status, error) {
            alert('Erro ao processar a solicitação.');
        }
    });
}

function validateImages(input) {
    const maxTotalSize = 7 * 1024 * 1024; // 7MB em bytes
    const files = input.files;
    let totalSize = 0;
    const maxFiles = 10; // Defina o número máximo de arquivos que deseja permitir
    const fileInfo = document.getElementById('fileInfo');
    const submitBtn = document.getElementById('submitBtn');
    
    // Verificar se o número de arquivos selecionados excede o limite
    if (files.length > maxFiles) {
        fileInfo.textContent = `Você pode selecionar no máximo ${maxFiles} arquivos.`;
        input.value = ''; // Limpa a seleção de arquivos
        submitBtn.disabled = true; // Desativa o botão de envio
        return;
    }

    // Calcular o tamanho total dos arquivos
    for (let i = 0; i < files.length; i++) {
        totalSize += files[i].size;
    }

    // Verificar se o tamanho total excede o limite
    if (totalSize > maxTotalSize) {
        fileInfo.textContent = `O tamanho total dos arquivos não pode exceder 7MB.`;
        input.value = ''; // Limpa a seleção de arquivos
        submitBtn.disabled = true; // Desativa o botão de envio
    } else {
        fileInfo.textContent = `Total de arquivos: ${files.length}, Tamanho total: ${(totalSize / 1024 / 1024).toFixed(2)} MB`;
        submitBtn.disabled = false; // Ativa o botão de envio
    }
}