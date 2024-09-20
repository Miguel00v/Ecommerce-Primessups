<?php 

    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['utilizadorID'])) {
        include 'conexaobd.php';

        $utilizadorID = $_SESSION['utilizadorID'];
        $imagem = $_FILES['fotoPerfilDados'];
        // Inicialmente, definir a imagem como vazia
        $imagemNome = '';

        // Verificar se o campo da imagem foi preenchido
    if ($imagem['error'] == UPLOAD_ERR_OK) {
        $imagemTmp = $imagem['tmp_name'];
        $imagemInfo = getimagesize($imagemTmp);

        if ($imagemInfo !== false) {
            // É uma imagem válida, processar o upload
            $imagemNome = mysqli_real_escape_string($conn, basename($imagem['name']));
            $destino = '../uploads/imagens' . $imagemNome;

            if (!move_uploaded_file($imagemTmp, $destino)) {
                die("Erro ao mover a imagem para o destino.");
            }
        } else {
            die("O arquivo enviado não é uma imagem válida.");
        }
    } elseif ($imagem['error'] != UPLOAD_ERR_NO_FILE) {
        // Se não for um erro de arquivo não enviado, informar o erro
        die("Erro no upload da imagem: " . $imagem['error']);
    }

    $sqlUpdate = "UPDATE utilizadores SET imagem = ? WHERE utilizadorID = ?";

    if ($stmt = mysqli_prepare($conn, $sqlUpdate)) {
        mysqli_stmt_bind_param($stmt, 'si', $destino, $utilizadorID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script> 
                    alert('Fotografia de perfil atualizada com sucesso.');
                    window.location.href = 'gerirDadosContaDesktop.php'; 
                  </script>";
        } else {
            echo "<script> 
                    alert('Erro ao atualizar fotografia de perfil: " . mysqli_stmt_error($stmt) . "');
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