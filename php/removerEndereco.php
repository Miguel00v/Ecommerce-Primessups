<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>alert('Precisa de iniciar sessão para remover um endereço!'); 
          window.location.href='index.php';</script>";
    exit; // Termina a execução do script se o utilizador não estiver autenticado
}

include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];
//Desativar chaves estrangeiras
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Verificar se o formulário foi submetido e se o campo enderecoID está definido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enderecoID'])) {
    $enderecoID = $_POST['enderecoID'];

    // Iniciar uma transação para garantir consistência
    mysqli_begin_transaction($conn);

    try {
        // Excluir o endereço especificado
        $sqlDelete = "DELETE FROM enderecos WHERE enderecoID = ? AND utilizadorID = ?";
        $stmtDelete = mysqli_prepare($conn, $sqlDelete);
        mysqli_stmt_bind_param($stmtDelete, "ii", $enderecoID, $utilizadorID);
        mysqli_stmt_execute($stmtDelete);

        // Verificar se a exclusão foi bem-sucedida
        if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
            mysqli_commit($conn);
            echo "<script>alert('Endereço removido com sucesso!'); 
                  window.location.href='listaEnderecos.php';</script>";
        } else {
            mysqli_rollback($conn);
            echo "<script>alert('Erro ao remover endereço!'); 
                  window.location.href='listaEnderecos.php';</script>";
        }

        mysqli_stmt_close($stmtDelete);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Erro ao remover endereço: " . $e->getMessage() . "'); 
              window.location.href='listaEnderecos.php';</script>";
    }

//Reativar chaves estrangeiras
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

    mysqli_close($conn);
} else {
    // Redirecionar para a lista de endereços se o formulário não for submetido corretamente
    header('Location: listaEnderecos.php');
    exit;
}
?>