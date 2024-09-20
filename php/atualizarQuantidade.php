<?php

    session_start();

// Verifica se a requisição é POST e se os parâmetros necessários estão presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produtoID']) && isset($_POST['quantidade']) && isset($_SESSION['carrinhoID'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include 'conexaobd.php';

    // Obtém os valores enviados via POST e da sessão
    $produtoID = $_POST['produtoID'];
    $quantidade = $_POST['quantidade'];
    $carrinhoID = $_SESSION['carrinhoID'];

    // Aqui você pode adicionar alguma validação adicional dos dados recebidos, se necessário

    // Atualizar a quantidade no banco de dados
    $sql = "UPDATE itens_carrinho SET quantidade = ? WHERE produtoID = ? AND carrinhoID = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $quantidade, $produtoID, $carrinhoID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Nenhuma linha foi atualizada.'));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Log para registro de informações
    error_log("Dados recebidos: produtoID = $produtoID, quantidade = $quantidade");
} else {
    // Caso não haja dados corretos enviados via POST ou sessão
    http_response_code(400); // Bad Request
    echo "Erro: Dados incorretos recebidos.";
}

?>