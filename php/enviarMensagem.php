<?php 

    session_start();

    //Link para rederecionar para página anterior se definida, senão vai para página inicial
    $anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        include 'conexaobd.php';
    
        //Captura dos dados do formulário
        $nomeInput = $_POST['nome'];
        $emailInput = $_POST['email'];
        $assuntoInput = $_POST['assunto'];
        $mensagemInput = $_POST['mensagem'];
        $dataEnvio = date('Y-m-d H:i:s');
    
        //sanitizar os dados
        $nome = mysqli_real_escape_string($conn, htmlspecialchars($nomeInput));
        $email = mysqli_real_escape_string($conn, filter_var($emailInput, FILTER_SANITIZE_EMAIL));
        $assunto = mysqli_real_escape_string($conn, htmlspecialchars($assuntoInput));
        $mensagem = mysqli_real_escape_string($conn, htmlspecialchars($mensagemInput));
    
        //Verifica se um arquivo foi enviado
        if (isset($_FILES['ficheiro']) && $_FILES['ficheiro']['error'] == UPLOAD_ERR_OK) {
            $destino = '../uploads/formularios/' . $_FILES['ficheiro']['name'];
            move_uploaded_file($_FILES['ficheiro']['tmp_name'], $destino);
            $ficheiro = $destino;  //Salvar o caminho do arquivo no banco de dados
        } else {
            $ficheiro = ''; //Caso nenhum arquivo tenha sido enviado
        }
    
        // Consulta SQL para obter o utilizadorID com base no nome
        $sql = "SELECT utilizadorID FROM utilizadores WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
    
        //Verifica se a preparação da consulta teve sucesso
        if ($stmt) {
    
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $utilizadorID);
    
            //Verifica se algum resultado foi obtido
            if (mysqli_stmt_fetch($stmt)) {
    
                //Insere mensagem com utilizadorID
                mysqli_stmt_close($stmt); //Fecha o statement antes de criar um novo
    
                $sqlInsert = "INSERT INTO mensagens_suporte (utilizadorID, assunto, mensagem, dataEnvio, ficheiro, email) VALUES (?, ?, ?, ?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $sqlInsert);
    
                mysqli_stmt_bind_param($stmtInsert, 'isssss', $utilizadorID, $assunto, $mensagem, $dataEnvio, $ficheiro, $email);
                mysqli_stmt_execute($stmtInsert);
    
                // Verifica se houve erro na execução da inserção
                if (mysqli_stmt_error($stmtInsert)) {
                    echo "<script>alert('Erro ao enviar mensagem!');</script>";
                } else {
                    echo "<script>alert('Mensagem enviada com sucesso!');
                        window.location.href='../index.php';
                    </script>";
                }
    
                mysqli_stmt_close($stmtInsert); //Fecha o statement após o uso
    
            } else {
                //Insere mensagem sem utilizadorID
                mysqli_stmt_close($stmt); //Fecha o statement antes de criar um novo
    
                $sqlInsertSemID = "INSERT INTO mensagens_suporte (assunto, mensagem, dataEnvio, ficheiro, email) VALUES (?, ?, ?, ?, ?)";
                $stmtInsertSemID = mysqli_prepare($conn, $sqlInsertSemID);
    
                mysqli_stmt_bind_param($stmtInsertSemID, 'sssss', $assunto, $mensagem, $dataEnvio, $ficheiro, $email);
                mysqli_stmt_execute($stmtInsertSemID);
    
                //Verifica se houve erro na execução da inserção
                if (mysqli_stmt_error($stmtInsertSemID)) {
                    echo "<script>alert('Erro ao enviar mensagem!');</script>";
                } else {
                    echo "<script>alert('Mensagem enviada com sucesso!');
                        window.location.href='../index.php';
                    </script>";
                }
    
                mysqli_stmt_close($stmtInsertSemID); //Fecha o statement após o uso
            }
    
        } else {
            echo "<script>alert('Erro ao enviar mensagem!');</script>";
        }
    
        mysqli_close($conn); //Fecha a conexão com o banco de dados
    
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Enviar mensagem</title>
    <meta name="description" content="Entre em contato conosco enviando uma mensagem através deste formulário.">
    <meta name="keywords" content="Primesupps, enviar mensagem, contato, formulário de contato, suporte ao cliente, mensagem de suporte, atendimento ao cliente, dúvidas, feedback, ajuda, suporte técnico, informações de produtos">
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
     <link rel="stylesheet" href="../css/enviarMensagem.css">
</head>
<body>
    
<div id="header"></div>

<main>
    <div class="background"><h1>Enviar mensagem</h1></div>
    <form method="post" enctype="multipart/form-data">

        <input class="inputs" type="text" name="nome" value="" placeholder="Nome" aria-label="Nome" required>
        <input class="inputs" type="email" name="email" value="" placeholder="Endereço de e-mail" aria-label="Endereço de e-mail" required>
        <select class="inputs custom-select" name="assunto" aria-label="Por favor, escolha um assunto" required>
            <option value="" disabled selected style="display: none;">Por favor, escolha um assunto</option>
            <option value="Dúvidas sobre pedidos">Dúvidas sobre pedidos</option>
            <option value="Reclamações">Reclamações</option>
            <option value="Problemas técnicos">Problemas técnicos</option>
            <option value="Informações sobre produtos">Informações sobre produtos</option>
            <option value="Solicitação de devolução">Solicitação de devolução</option>
            <option value="Solicitação de troca">Solicitação de troca</option>
            <option value="Outros assuntos">Outros assuntos</option>
        </select> 
        <textarea class="inputs" name="mensagem" placeholder="Aqui pode escrever a sua mensagem para a nossa equipa" required></textarea>
        <div class="flexbox">
        <input class="inputs item1 semBorda" type="file" name="ficheiro" placeholder="Anexar ficheiro" aria-label="Anexar ficheiro" accept=".pdf,.doc,.docx,.jpg,.png"> 
        <p class="item2 inputs semBorda p">Limite máximo: 7MB</p>
        </div>
        <button id="btnEnviar" class="btnEnviar" type="submit"><p>Enviar mensagem</p></button>

    </form>

</main>

    <div id="footer"></div>

</body>
</html>