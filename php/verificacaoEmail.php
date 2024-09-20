<?php

    include'conexaobd.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica o token no banco de dados
    $sql = "SELECT utilizadorID FROM utilizadores WHERE token = ? AND emailConfirmado = 0";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Atualiza o usuário para verificado
        $sql = "UPDATE utilizadores SET emailConfirmado= 1, token = NULL WHERE token = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<script> alert('E-mail verificado com sucesso! Você pode agora fazer login.');
        window.location.href='iniciarSessao.php'; </script>";
    } else {
        echo "<script>alert('Token inválido ou conta já verificada.');
        window.location.href='iniciarSessao.php'; </script>";
    }
} else {
    echo "<script>alert('Token não fornecido.');</script>";
}
?>