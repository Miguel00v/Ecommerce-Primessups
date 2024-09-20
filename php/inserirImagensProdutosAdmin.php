<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['produtoID'])) {
    $produtoID = $_GET['produtoID'];
    include 'conexaobd.php';

    if (mysqli_connect_errno()) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    $imagemDir = '../uploads/imagens'; // Certifique-se de que o diretório termina com '/'
    foreach ($_FILES['imagens']['tmp_name'] as $key => $tmpName) {
        
        if (!empty($tmpName)) { // Verifique se há uma imagem para processar
            $imagemNome = basename($_FILES['imagens']['name'][$key]);
            $imagemCaminho = $imagemDir . $imagemNome;

            // Mover o arquivo para o diretório de upload
            if (move_uploaded_file($tmpName, $imagemCaminho)) {
                // Inserir caminho da imagem na base de dados
                $sqlImagem = 'INSERT INTO imagens_produtos (produtoID, caminho) VALUES (?, ?)';
                $stmtImagem = mysqli_prepare($conn, $sqlImagem);
                mysqli_stmt_bind_param($stmtImagem, 'is', $produtoID, $imagemCaminho);
                if (!mysqli_stmt_execute($stmtImagem)) {
                    echo "<script>alert('Erro ao guardar a imagem na base de dados.');</script>";
                }
                mysqli_stmt_close($stmtImagem);
            } else {
                echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
            }
        }
    }
    mysqli_close($conn);
    echo "<script>alert('Imagens adicionadas com sucesso.');
        window.location.href='gerirProdutosAdmin.php';
    </script>";
}
?>