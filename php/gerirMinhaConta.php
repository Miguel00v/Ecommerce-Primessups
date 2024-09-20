<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Gerir a minha conta</title>
    <meta name="description" content="Gerencie suas informações pessoais, detalhes de pedidos e preferências na sua conta Primesupps. Acesse suas configurações e atualize suas informações de forma segura e fácil.">
    <meta name="keywords" content="gerenciar conta, configurações de conta, informações pessoais, pedidos, preferências, Primesupps">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/gerirMinhaConta.css">
</head>
<body>
    
<?php include'headerMobile.php'; ?>

    <main>

                <a class="flexContainer" href="dadosConta.php" title="Ver dados da conta">
                    <div><h2>Ver dados da conta</h2></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                </a>

                <a class="flexContainer" href="dadosFiscais.php" title="Dados fiscais">
                    <div><h2>Dados fiscais</h2></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                </a>

                <a class="flexContainer" href="listaEnderecos.php" title="Meus endereços">
                    <div><h2>Meus endereços</h2></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                </a>

                <a class="flexContainer" href="metodosPagamento.php" title="Métodos de pagamento">
                    <div><h2>Métodos de pagamento</h2></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                </a>

                <a class="flexContainer" href="gerirPermissoes.php" title="Gerir permissões">
                    <div><h2>Gerir permissões</h2></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                </a>

                <a class="flexContainer" href="desativarConta.php" title="Desativar conta">
                    <div><h2>Desativar conta</h2></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                </a>
            

    </main>

    <?php include'footerMobile.php'; ?>

</body>
</html>