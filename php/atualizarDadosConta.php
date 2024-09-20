<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['utilizadorID'])) {
    include 'conexaobd.php';

    $utilizadorID = $_SESSION['utilizadorID'];
    $imagem = $_FILES['imagem']; 
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $apelido = mysqli_real_escape_string($conn, $_POST['apelido']);
    $dataNascimento = mysqli_real_escape_string($conn, $_POST['dataNascimento']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

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
    $imagemNome = !empty($imagemNome) ? $imagemNome : $imagemAntiga;

    // Atualizar os dados na bd
    $sqlUpdate = "UPDATE utilizadores SET nome = ?, apelido = ?, dataNascimento = ?, email = ?, imagem = ? WHERE utilizadorID = ?";
    if ($stmt = mysqli_prepare($conn, $sqlUpdate)) {
        mysqli_stmt_bind_param($stmt, 'sssssi', $nome, $apelido, $dataNascimento, $email, $destino, $utilizadorID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script> 
                    alert('Dados atualizados com sucesso.');
                    window.location.href = 'dadosConta.php'; 
                  </script>";
        } else {
            echo "<script> 
                    alert('Erro ao atualizar os dados: " . mysqli_stmt_error($stmt) . "');
                    window.location.href = 'dadosConta.php'; 
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