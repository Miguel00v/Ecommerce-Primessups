<?php

    session_start();

    //Link para rederecionar para página anterior se definida, senão vai para página inicial
    $anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Ajuda</title>
    <meta name="description" content="Página de ajuda da Primesupps. Encontre informações sobre suporte, termos e condições, devoluções e trocas, política de privacidade, perguntas frequentes e como nos contactar.">
   <!-- Inserir em todas as páginas -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/ajuda.css">
</head>
</head>
<body>

<?php include'headerMobile.php'; ?>

    <main>
        <div class="gridBtn">
            <div id="btn1"><a href="enviarMensagem.php" title="Enviar mensagem de suporte"><button type="button"><p>Enviar mensagem</p></button></a></div>
            <div id="btn2"><a href="termosCondicoes.php" title="Termos e condições"><button type="button"><p>Termos e condições</p></button></a></div>
            <div id="btn3"><a href="devolucoesTrocas" title="Políticas de devoluções e trocas"><button type="button"><p>Devoluções e trocas</p></button></a></div>   
            <div id="btn4"><a href="FAQ.php" title="Política de privacidade"><button type="button"><p>Politica de privacidade</p></button></a></div>
            <div id="btn5"><a href="preEposTreino.php" title="Página de Pré-treino e pós-treino"><button type="button"><p>Perguntas frequentes</p></button></a></div>
            <div id="btn6"><a href="contactos.php" title="Como nos contactar"><button type="button"><p>Contactar</p></button></a></div>
        </div>
    </main>

    <?php include'footerMobile.php'; ?>

</body>