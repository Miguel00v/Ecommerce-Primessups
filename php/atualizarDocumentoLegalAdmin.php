<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexaobd.php';

    $documentoID = $_POST['documentoID'];
    $newDocumento = htmlspecialchars($_POST['conteudo']);

    // Selecionar dados atuais para comparar aos novos dados
    $sql = "SELECT documento FROM documentos_legais WHERE documentoID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        echo "<script>alert('Prepare failed: " . htmlspecialchars(mysqli_error($conn)) . "');
            window.location.href='gerirDocumentosLegaisAdmin.php';
        </script>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $documentoID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $currentData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$currentData) {
        echo "<script>alert('Documento não encontrado.');
            window.location.href='gerirDocumentosLegaisAdmin.php';
        </script>";
        exit;
    }

    $currentDocumento = $currentData['documento'];

    $updates = [];
    $params = [];
    $types = '';

    if ($newDocumento !== $currentDocumento) {
        $updates[] = 'documento = ?';
        $params[] = $newDocumento;
        $types .= 's';
    }

    if (!empty($updates)) {
        $params[] = $documentoID;
        $types .= 'i';

        $sql = "UPDATE documentos_legais SET " . implode(', ', $updates) . " WHERE documentoID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            echo "<script>alert('Prepare failed: " . htmlspecialchars(mysqli_error($conn)) . "');
                window.location.href='gerirDocumentosLegaisAdmin.php';
            </script>";
            exit;
        }

        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Documento atualizado com sucesso.');
                window.location.href='gerirDocumentosLegaisAdmin.php';
            </script>";
        } else {
            echo "<script>alert('Erro ao atualizar documento: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "');
                window.location.href='gerirDocumentosLegaisAdmin.php';
            </script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Nenhuma alteração detectada.');
            window.location.href='gerirDocumentosLegaisAdmin.php';
        </script>";
    }

    mysqli_close($conn);
}
?>