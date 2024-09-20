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

// Desativar chaves estrangeiras (se absolutamente necessário)
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Remove um método de pagamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['metodoID2'])) {
    $metodoID = intval($_POST['metodoID2']);

    // Prepare e execute a consulta para remover o método de pagamento
    $sql = "DELETE FROM metodos_pagamento WHERE utilizadorID = ? AND metodoID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ii', $utilizadorID, $metodoID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('Método de pagamento removido com sucesso.');
                window.location.href='metodosPagamento.php';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao remover método de pagamento.');
                window.location.href='metodosPagamento.php';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Erro na preparação da consulta.');
            window.location.href='metodosPagamento.php';
        </script>";
    }

    // Reativar chaves estrangeiras (se necessário)
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
}
?>