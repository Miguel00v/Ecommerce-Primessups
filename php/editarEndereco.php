<?php

    session_start();

//Inserir os dados de edição
if($_SERVER['REQUEST_METHOD']=='POST'){

    include'conexaobd.php';

    //Selecionar dados antigos
    $sqlSelect ="SELECT * FROM enderecos WHERE enderecoID = ?";
        $stmtSelect = mysqli_prepare($conn,$sqlSelect);
        mysqli_stmt_bind_param($stmtSelect, "i", $enderecoID);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $enderecoIDAntigo, $enderecoAntigo, $paisAntigo, $utilizadorID, $codigoPostalAntigo, $cidadeAntiga, $predefinidoAntigo);
        mysqli_stmt_fetch($stmtSelect);
        mysqli_stmt_close($stmtSelect);

    $enderecoIDEditar = $_POST['enderecoID'];
    $enderecoEditar = htmlspecialchars($_POST['endereco']);
    $cidadeEditar = ucfirst(strtolower(htmlspecialchars($_POST['cidade']))); // Primeira letra maiúscula
    $codigoPostalEditar = formatarCodigoPostalEditar($_POST['codigoPostal']); // Formato 0000-000
    $paisEditar = ucfirst(strtolower(htmlspecialchars($_POST['pais']))); // Primeira letra maiúscula
    $enderecoPrincipalEditar = isset($_POST['enderecoPrincipal']) ? 1 : 0; // 1 se marcado, 0 se não

        // Adicionar "Rua" no início do endereço se não estiver especificado
    if (!startsWithRuaEditar($enderecoEditar)) {
        $enderecoEditar = "Rua " . $enderecoEditar;
    }

    // Verificar se o código postal está no formato correto
    if (!$codigoPostalEditar) {
        echo "<script>alert('Código postal inválido! Deve estar no formato 0000-000.');</script>";
    } else {
        // Iniciar transação para garantir consistência
        mysqli_autocommit($conn, false);

        $enderecoEditar = !empty($enderecoEditar) ? $enderecoEditar : $enderecoAntigo;
        $codigoPostalEditar = !empty($codigoPostalEditar) ?  $codigoPostalEditar : $codigoPostalAntigo;
        $paisEditar = !empty($paisEditar) ? $paisEditar : $paisAntigo;
        $cidadeEditar = !empty($cidadeEditar) ? $cidadeEditar : $cidadeAntiga;

        // Atualizar o endereço existente
        $sqlEditar = "UPDATE enderecos SET endereco = ?, pais = ?, codigoPostal = ?, cidade = ?, predefinido = ? WHERE enderecoID = ?";
        $stmtEditar = mysqli_prepare($conn, $sqlEditar);
        mysqli_stmt_bind_param($stmtEditar, "ssssii", $enderecoEditar, $paisEditar, $codigoPostalEditar, $cidadeEditar, $enderecoPrincipalEditar, $enderecoIDEditar);
        mysqli_stmt_execute($stmtEditar);

        // Verificar se a atualização foi bem-sucedida
        if (mysqli_stmt_affected_rows($stmtEditar) > 0) {
            // Se a checkbox de endereço principal estiver marcada, atualizar predefinido para este endereço
            if ($enderecoPrincipalEditar == 1) {
                // Desmarcar todos os outros endereços como não predefinidos
                $sqlUnsetPredefinido = "UPDATE enderecos SET predefinido = 0 WHERE utilizadorID = ? AND enderecoID <> ?";
                $stmtUnsetPredefinido = mysqli_prepare($conn, $sqlUnsetPredefinido);
                mysqli_stmt_bind_param($stmtUnsetPredefinido, "ii", $utilizadorID, $enderecoIDEditar);
                mysqli_stmt_execute($stmtUnsetPredefinido);
                mysqli_stmt_close($stmtUnsetPredefinido);
            }

            // Commit da transação
            mysqli_commit($conn);

            echo "<script>alert('Endereço atualizado com sucesso!');
            window.location.href='listaEnderecos.php';
            </script>";
        } else {
            mysqli_rollback($conn);

            echo "<script>alert('Erro ao atualizar endereço!');</script>";
        }

        mysqli_stmt_close($stmtEditar);
    }

    mysqli_close($conn);
}

function formatarCodigoPostalEditar($codigoPostal) {
    // Remove todos os caracteres não numéricos
    $codigoPostal = preg_replace('/\D/', '', $codigoPostal);

    // Verifica se o código postal tem 7 dígitos numéricos
    if (strlen($codigoPostal) !== 7) {
        return false; // Retorna falso se não tiver 7 dígitos
    }

    // Formata para o padrão 0000-000
    $codigoPostalFormatado = substr($codigoPostal, 0, 4) . '-' . substr($codigoPostal, 4, 3);

    return $codigoPostalFormatado;
}

function startsWithRuaEditar($enderecoEditar) {
    return (substr($enderecoEditar, 0, 3) === "Rua");
}


?>