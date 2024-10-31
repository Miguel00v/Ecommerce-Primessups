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
    <title>Primesupps - Contactos</title>
    <meta name="description" content="Entre em contato com a Primesupps para informações sobre produtos, suporte e muito mais. Enviar e-mail ou mensagem diretamente.">
    <meta name="keywords" content="Primesupps, contato Primesupps, suporte Primesupps, informações Primesupps, atendimento ao cliente Primesupps, email Primesupps, mensagem Primesupps">
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
     <link rel="stylesheet" href="../css/contactos.css">
</head>
<body>
    
<div id="header"></div>

<main>
    <div class="background"><h1>Contactos</h1></div>
            <div class="btnContacto"><a href="mailto:primesupps.pt@gmail.com" title="Enviar e-mail para PrimeSupps"><button type="button" id="enviarEmail"><p>Enviar e-mail</p></button></a></div>
            <div class="btnContacto"><a href="enviarMensagem.php" title="Enviar mensagem para PrimeSupps"><button type="button" id="enviarMensagem"><p>Enviar mensagem</p></button></a></div>
        <div>
            <h2 id="nossosContactos">Nossos Contactos</h2>
            <div class="bacgroundNossosContactos">
                <div class="formasContacto"><p class="p"><i class="fa-solid fa-envelope"></i> primesupps.pt@gmail.com</p></div>
                <div class="formasContacto"><p class="p"><i class="fa-solid fa-phone"></i> +351 0123 456 789</p></div>
                <div class="formasContacto"><p class="p"><i class="fa-solid fa-clock-rotate-left"></i> Segunda a sexta-feira das 9h00 ás 18h00</p></div>
            </div>
        </div>

</main>

   <div id="footer"></div>

</body>
</html>