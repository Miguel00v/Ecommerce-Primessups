<?php

    session_start();

    include'conexaobd.php';

    //selecionar documento da base de dados
    $sql = " SELECT documento FROM documentos_legais WHERE nome = 'Sobre nós' ";
    $result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Sobre nós</title>
    <meta name="description" content="Conheça a Primesupps: descubra nossa história, missão e valores. Saiba como nos dedicamos a oferecer produtos de qualidade superior para promover sua saúde e bem-estar.">
    <meta name="keywords" content="sobre nós, Primesupps, história, missão, valores, produtos de qualidade, saúde, bem-estar">
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
     <link rel="stylesheet" href="../css/documentosLegais.css">
     <link rel="stylesheet" href="../css/sobreNos.css">
</head>
<body>

<div id="header"></div>

    <main>
                <img id="imagemLogo" src="../imagens/identidadeVisual/Nossa missão.png" alt="Primesupps - Logo">

        <div>

        <?php

            if ($result) {
                // Obter o resultado da consulta
                $row = mysqli_fetch_assoc($result);
                
                // Verificar se encontrou algum documento
                if ($row) {
                    $documento =  nl2br(htmlspecialchars($row['documento'], ENT_QUOTES, 'UTF-8'));;
                    echo "<div class='documento'><h1>Sobre nós</h1><p>".$documento."</p></div>";
                } else {
                    echo "<script> alert('Erro ao carregar página!'); 
                        window.location.href='../index.php';
                    </script>";
                }

                mysqli_free_result($result);
            } else {
                echo "<script> alert('Erro ao carregar página!'); 
                        window.location.href='../index.php';
                    </script>";
            }

            mysqli_close($conn);

            ?>


        </div>

    </main>

    <div id="footer"></div>

</body>
</html>