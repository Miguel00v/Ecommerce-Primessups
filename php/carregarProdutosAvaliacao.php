<?php
if (isset($_POST['categoria'])) {
    include 'conexaobd.php'; 

    $categoria = $_POST['categoria'];
    $sqlProdutos = "SELECT nome FROM produtos WHERE categoria = ?";
    $stmtProdutos = mysqli_prepare($conn, $sqlProdutos);
    mysqli_stmt_bind_param($stmtProdutos, "s", $categoria);
    mysqli_stmt_execute($stmtProdutos);
    mysqli_stmt_bind_result($stmtProdutos, $nome);

    $options = '';
    while (mysqli_stmt_fetch($stmtProdutos)) {
        $options .= "<option>$nome</option>";
    }

    mysqli_stmt_close($stmtProdutos);
    mysqli_close($conn); // Fechar conexão com o banco de dados

    echo $options;
}
?>