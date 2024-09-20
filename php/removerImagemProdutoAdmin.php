<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['imagemID'])) {
    include 'conexaobd.php';

    $imagemID = $_POST['imagemID'];

    // Desativar chaves estrangeiras
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    if ($stmt = mysqli_prepare($conn, "DELETE FROM imagens_produtos WHERE imagemID = ?")) {
        mysqli_stmt_bind_param($stmt, "i", $imagemID);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao remover imagem do banco de dados.']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao preparar a declaração: ' . mysqli_error($conn)]);
    }

    // Reativar chaves estrangeiras
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida ou imagemID ausente.']);
}
?>