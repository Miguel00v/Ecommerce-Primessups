function exibirDocumento() {
    var queryNomeDocumento = document.getElementById("nomeDocumento").value;

    console.log("Selected document type: " + queryNomeDocumento); // Debug output

    $.ajax({
        url: 'gerirDocumentosLegaisAdmin.php', // Update with your PHP script path
        type: 'POST',
        data: {
            nome: queryNomeDocumento
        },
        success: function(response) {
            console.log("AJAX response: ", response); // Debug output

            var data = JSON.parse(response);

            if (data.error) {
                console.error(data.error);
                alert('Documento não encontrado');
            } else {
                $('#formConteudo').show();
                $('input[name="documentoID"]').val(data.documentoID);
                $('input[name="tituloDocumento"]').val(data.titulo);
                $('textarea[name="conteudo"]').val(data.conteudo);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro na solicitação AJAX:', status, error);
        }
    });
}
