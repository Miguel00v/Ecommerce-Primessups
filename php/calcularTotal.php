<?php
session_start();

include 'conexaobd.php';

if (isset($_SESSION['carrinhoID'])) {
    $carrinhoID = $_SESSION['carrinhoID'];

    // Consulta para calcular o total geral do carrinho
    $sql = "SELECT SUM(produtos.preco * itens_carrinho.quantidade) AS totalProdutos
            FROM itens_carrinho
            INNER JOIN produtos ON itens_carrinho.produtoID = produtos.produtoID
            WHERE itens_carrinho.carrinhoID = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $carrinhoID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalProdutos);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verificar o custo de envio
    $custoEnvio = 0.00; // Valor inicial
    $sqlCustoEnvio = "SELECT pais FROM enderecos WHERE utilizadorID = ? AND predefinido = '1'";
    $stmtCustoEnvio = mysqli_prepare($conn, $sqlCustoEnvio);
    mysqli_stmt_bind_param($stmtCustoEnvio, "i", $_SESSION['utilizadorID']);
    mysqli_stmt_execute($stmtCustoEnvio);
    mysqli_stmt_bind_result($stmtCustoEnvio, $pais);
    mysqli_stmt_fetch($stmtCustoEnvio);
    mysqli_stmt_close($stmtCustoEnvio); 

    if ($pais !== 'Portugal') {
        $custoEnvio = 2.99;
    }

    // Calcular o total geral somando o total dos produtos com o custo de envio
    $totalGeral = $totalProdutos + $custoEnvio;

    // Retornar o total geral formatado como JSON
    echo json_encode(array('totalGeral' => $totalGeral, 'subtotal' => $totalProdutos));

    mysqli_close($conn);
} else {
    http_response_code(400); // Bad Request
    echo "Erro: Carrinho não encontrado.";
}
?>