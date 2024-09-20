<?php
session_start();

if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>
        alert('Precisa de iniciar sessão para aceder a esta página.');
        window.location.href='iniciarSessao.php';
    </script>";
    exit();
}

include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];

// Remove um método de pagamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dadosFiscaisID'])) {
    $dadosFiscaisID = intval($_POST['dadosFiscaisID']);

    //Desativar chaves estrangeiras
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

    // Remover dados fiscais do banco de dados
    $sql = "DELETE FROM dados_fiscais WHERE utilizadorID = ? AND dadosFiscaisID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $utilizadorID, $dadosFiscaisID);
    mysqli_stmt_execute($stmt);

    if(mysqli_stmt_affected_rows($stmt)>0){

        echo "<script> alert('Dados fiscais removidos com sucesso.');
            window.location.href='dadosFiscais.php';
        </script>";

    } else{

        echo " <script> alert('Erro ao remover dados fiscais.'); 
            window.location.href='dadosFiscais.php';
        </script> ";

    }

    mysqli_stmt_close($stmt);

    //Reativar chaves estrangeiras
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

}
?>