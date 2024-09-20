<?php

session_start();

$utilizadorID=$_SESSION['utilizadorID'];

include 'conexaobd.php';
header('Content-Type: application/json'); // Definir o cabeçalho JSON


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pagamentoPredefinida']) && isset($_POST['metodoID'])) {
    $utilizadorID = $_SESSION['utilizadorID'] ?? null; // Exemplo de recuperação da sessão

    if ($utilizadorID && is_numeric($utilizadorID)) {
        $metodoID = intval($_POST['metodoID']);

        mysqli_begin_transaction($conn);

        try {
            // Remove o método de pagamento predefinido existente
            $sql = "UPDATE metodos_pagamento SET predefinido = 0 WHERE utilizadorID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Define o novo método de pagamento como predefinido
            $sql = "UPDATE metodos_pagamento SET predefinido = 1 WHERE utilizadorID = ? AND metodoID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'ii', $utilizadorID, $metodoID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Commit da transação
            mysqli_commit($conn);

            // Enviar resposta JSON válida
            echo json_encode(['status' => 'success', 'message' => 'Método de pagamento atualizado com sucesso.']);
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo json_encode(['status' => 'error', 'message' => 'Falha ao atualizar o método de pagamento.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuário inválido.']);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Requisição inválida.']);
}
?>
