<?php

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        include 'conexaobd.php';
    
        $nomeInput = $_POST['nome'];
        $emailInput = $_POST['email'];
        $nomeProdutoInput = $_POST['nomeProduto'];
        $categoriaInput = $_POST['categoria'];
        $estrela = $_POST['estrela'];
        $criticaInput = $_POST['critica'];
        date_default_timezone_set('Europe/Lisbon');
        $data = date('Y-m-d'); 
    
        // Sanitizar os dados
        $nome = mysqli_real_escape_string($conn, htmlspecialchars($nomeInput));
        $email = mysqli_real_escape_string($conn, filter_var($emailInput, FILTER_SANITIZE_EMAIL));
        $nomeProduto = mysqli_real_escape_string($conn, htmlspecialchars($nomeProdutoInput));
        $categoria = mysqli_real_escape_string($conn, htmlspecialchars($categoriaInput));
        $critica = mysqli_real_escape_string($conn, htmlspecialchars($criticaInput));
        
    
        // Verificar se o email está associado a alguma conta
        $sql = "SELECT utilizadorID FROM utilizadores WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
    
        if ($stmt) {
    
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $utilizadorID);
    
            if (mysqli_stmt_fetch($stmt)) {
    
                // Fechar o statement após buscar o utilizadorID
                mysqli_stmt_close($stmt);
    
                // Verificar o ID do produto
                $sqlprodutoID = "SELECT produtoID FROM produtos WHERE nome = ?";
                $stmtprodutoID = mysqli_prepare($conn, $sqlprodutoID);
                mysqli_stmt_bind_param($stmtprodutoID, 's', $nomeProduto);
                mysqli_stmt_execute($stmtprodutoID);
                mysqli_stmt_bind_result($stmtprodutoID, $produtoID);
    
                if (mysqli_stmt_fetch($stmtprodutoID)) {
    
                    // Fechar o statement após buscar o produtoID
                    mysqli_stmt_close($stmtprodutoID);
    
                    // Inserir dados na base de dados
                    $sqlComentario = "INSERT INTO avaliacoes (utilizadorID, produtoID, data, comentario, avaliacao) VALUES (?, ?, ?, ?, ?)";
                    $stmtComentario = mysqli_prepare($conn, $sqlComentario);
                    mysqli_stmt_bind_param($stmtComentario, 'iisss', $utilizadorID, $produtoID, $data, $critica, $estrela);
                    mysqli_stmt_execute($stmtComentario);
    
                    // Verificar se a inserção foi bem-sucedida
                    if (mysqli_stmt_affected_rows($stmtComentario) > 0) {
    
                        echo "<script>alert('Comentário inserido com sucesso'); 
                        window.location.href='index.php';
                        </script>";
    
                    } else {
    
                        echo "<script>alert('Erro ao inserir comentário');</script>";
    
                    }
    
                    // Fechar statement de inserção
                    mysqli_stmt_close($stmtComentario);
    
                } else {
    
                    echo "<script>alert('Erro ao buscar o produto');</script>";
    
                }
    
            } else {
    
                echo "<script>alert('O email que introduziu não está associado a uma conta!');</script>";
    
            }
    
            // Fechar statement inicial
            mysqli_stmt_close($stmt);
    
        } else {
    
            echo "<script>alert('Ocorreu um erro ao efetuar o seu comentário!');</script>";
    
        }
    
        // Fechar conexão
        mysqli_close($conn);
    }
    

    //Link para rederecionar para página anterior se definida, senão vai para página inicial
    $anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Criar comentário</title>
    <meta name="description" content="Crie um comentário sobre produtos da Primesupps. Avalie e comente sobre vitaminas, suplementos, proteínas e mais.">
    <meta name="keywords" content="criar comentário, Primesupps, avaliações de produtos, comentários de suplementos, avaliações de vitaminas, proteínas, suplementos alimentares, produtos de nutrição, feedback de clientes, opiniões de produtos, suplementos esportivos">
     <!-- Inserir em todas as páginas -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detecaoDispositivo.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/criarComentario.css">
    <script type="text/javascript" src="../js/criarComentario.js"></script>
</head>
<body>
    
<div id="header"></div>

<main>
    <div class="background"><h1>Comentário</h1></div>

    <form method="post">

        <input class="inputs" type="text" name="nome" placeholder="Nome" aria-label="Nome" required>
        <input class="inputs" type="email" name="email" placeholder="Endereço de e-mail" aria-label="Endereço de e-mail" required>
        <select class="inputs custom-select" name="categoria" id="categoria" aria-label="Categoria do produto" required>
        <option disabled selected style="display: none;"><p>Categoria do produto</p></option>
        <option value="Vitaminas e minerais"><p>Vitaminas e minerais</p></option>
        <option value="Emagrecimento"><p>Emagrecimento</p></option>
        <option value="Proteínas"><p>Proteínas</p></option>
        <option value="Aminoácidos"><p>Aminoácidos</p></option>
        <option value="Pré-treino e pós-treino"><p>Pré-treino e pós-treino</p></option>
        <option value="Outros suplementos"><p>Outros suplementos</p></option>
    </select>

    <select class="inputs custom-select" name="nomeProduto" id="nomeProduto" aria-label="Nome do produto" required>
        <option disabled selected style="display: none;"><p>Nome do produto</p></option>
    </select>
        <div id="semBorda" class="inputs">
        <label>Classificação geral</label>
            <div class="rating">
                <input type="radio" name="estrela" id="estrela0" value="0" checked style="display:none;">
                <input type="radio" name="estrela" id="estrela1" value="1" required><label for="estrela1" title="1 estrelas"><i class="fa-solid fa-star"></i></label>
                <input type="radio" name="estrela" id="estrela2" value="2"><label for="estrela2" title="2 estrelas"><i class="fa-solid fa-star"></i></label>
                <input type="radio" name="estrela" id="estrela3" value="3"><label for="estrela3" title="3 estrelas"><i class="fa-solid fa-star"></i></label>
                <input type="radio" name="estrela" id="estrela4" value="4"><label for="estrela4" title="4 estrelas"><i class="fa-solid fa-star"></i></label>
                <input type="radio" name="estrela" id="estrela5" value="5"><label for="estrela5" title="5 estrela"><i class="fa-solid fa-star"></i></label>
            </div>
        </div>
        <textarea class="inputs" name="critica" placeholder="Aqui pode escrever a sua critica" aria-label="Aqui pode escrever a sua critica" required></textarea>
        <button id="btnEnviar" class="btnEnviar" type="submit"><p>Enviar comentário</p></button>

    </form>
</main>

<div id="footer"></div>

</body>
</html>