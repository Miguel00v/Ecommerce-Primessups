<?php
session_start();

$utilizadorID = $_SESSION['utilizadorID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include'conexaobd.php';
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $emails = isset($_POST['emails']) ? 1 : 0;

    $sql = "UPDATE permissoes SET receberNewsletter = ?, receberEmails = ? WHERE utilizadorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $newsletter, $emails, $utilizadorID);

    if ($stmt->execute()) {
        echo '<script>alert("Permissões atualizadas com sucesso");
            window.location.href="gerirDadosContaDesktop.php";
        </script>';
    } else {
        echo '<script>alert("Erro ao atualizar permissões");
            window.location.href="gerirDadosContaDesktop.php";
        </script>';
    }

    $stmt->close();
    $conn->close();
}
?>