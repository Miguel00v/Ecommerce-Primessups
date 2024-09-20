<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['utilizadorID'])) {
    include 'conexaobd.php';

    $utilizadorID = $_SESSION['utilizadorID'];
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $apelido = mysqli_real_escape_string($conn, $_POST['apelido']);
    $dataNascimento = mysqli_real_escape_string($conn, $_POST['dataNascimento']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Selecionar dados antigos
    $sql = "SELECT nome, apelido, dataNascimento, email, imagem FROM utilizadores WHERE utilizadorID = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $nomeAntigo, $apelidoAntigo, $dataNascimentoAntiga, $emailAntigo, $imagemAntiga);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die("Erro ao preparar a declaração: " . mysqli_error($conn));
    }

    // Usar os novos dados apenas se não estiverem vazios, caso contrário usar os antigos
    $nome = !empty($nome) ? $nome : $nomeAntigo;
    $apelido = !empty($apelido) ? $apelido : $apelidoAntigo;
    $dataNascimento = !empty($dataNascimento) ? $dataNascimento : $dataNascimentoAntiga;
    $email = !empty($email) ? $email : $emailAntigo;

    // Atualizar os dados na bd
    $sqlUpdate = "UPDATE utilizadores SET nome = ?, apelido = ?, dataNascimento = ?, email = ? WHERE utilizadorID = ?";
    if ($stmt = mysqli_prepare($conn, $sqlUpdate)) {
        mysqli_stmt_bind_param($stmt, 'ssssi', $nome, $apelido, $dataNascimento, $email, $utilizadorID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script> 
                    alert('Dados atualizados com sucesso.');
                    window.location.href = 'gerirDadosContaDesktop.php'; 
                  </script>";
        } else {
            echo "<script> 
                    alert('Erro ao atualizar os dados: " . mysqli_stmt_error($stmt) . "');
                    window.location.href = 'gerirDadosContaDesktop.php'; 
                  </script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Erro ao preparar a declaração de atualização: " . mysqli_error($conn));
    }

    // Fechar a conexão
    mysqli_close($conn);
}
?>