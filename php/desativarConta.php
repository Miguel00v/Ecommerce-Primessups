<?php
session_start();


// Verificar se o utilizador está autenticado
if (!isset($_SESSION['utilizadorID'])) {
    header('Location: ../index.php');
    exit; 
}

// Verificar se o pedido é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include 'conexaobd.php'; // Inclua o arquivo de conexão com o banco de dados

    // ID do utilizador a ser removido (assumindo que está na sessão)
    $utilizadorID = $_SESSION['utilizadorID'];

    // Desativar chaves estrangeiras temporariamente para evitar conflitos
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    // Arrays de tabelas relacionadas ao utilizador
    $tables = array(
        'alteracoes_password',
        'avaliacoes',
        'dados_fiscais',
        'enderecos',
        'permissoes',
        'metodos_pagamento',
        'encomendas',
        'utilizadores'
    );

    $success = true; // Variável para verificar se todas as deleções foram bem-sucedidas

    // Preparar e executar as declarações de exclusão
    foreach ($tables as $table) {
        $stmt = $conn->prepare("DELETE FROM $table WHERE utilizadorID = ?");
        $stmt->bind_param("i", $utilizadorID); 
        $stmt->execute();
        
        // Verificar se ocorreu um erro na execução da declaração
        if ($stmt->error) {
            $success = false;
        }
        
        $stmt->close();
    }

    // Reativar chaves estrangeiras
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    // Verificar se todas as deleções foram bem-sucedidas
    if ($success) {
        // Todas as operações foram bem-sucedidas
        echo "<script> alert('Conta removida com sucesso!');" .session_destroy()."
        window.location.href='../index.php'; </script>";
    } else {
        // Alguma operação falhou
        echo "<script>alert('Erro ao remover conta!');</script>";
    }

    // Fechar conexão
    $conn->close();

}
?>

<!DOCTYPE html>
<html lang="PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Desativar conta</title>
    <meta name="description" content="Página para desativar sua conta na Primesupps. Siga as instruções para desativar sua conta permanentemente.">
    <meta name="keywords" content="Primesupps, desativar conta, excluir conta, encerrar conta, cancelamento de conta">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
<script type="text/javascript" src="../js/desativarConta.js"></script>
<link rel="stylesheet" href="../css/desativarConta.css">
</head>
</head>
<body>
    
<?php include'headerMobile.php'; ?>

<main>

    <div>
        <p>Ao desativares a tua conta vais perder todos os benefícios de seres nosso cliente, além de perderes a possibilidade de efetuar compras em primesupps.pt</p>
        <form id="formDesativar" method="post">
            <button id="btnDesativar" type="button" onclick="confirmarDesativacao()"><p>Desativar conta</p></button>
        </form>
    </div>

</main>

<?php include'footerMobile.php'; ?>

</body>
</html>