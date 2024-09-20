<?php
session_start();

require 'stripe-php-master/init.php';
\Stripe\Stripe::setApiKey('sk_test_51PfikOJGkzLnsntVhosScn3zldDDKRQ6eeCAcgALkvheEMvhF6V8aN6RZy2G10KNev0yyeH9B7e0b9hgb7GVaLTp00ABmuArz7');

include 'conexaobd.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>
        alert('Precisa de iniciar sessão para aceder a esta página.');
        window.location.href='iniciarSessao.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stripeToken'])) {
        // Dados do token do Stripe
        $stripeToken = $_POST['stripeToken'];
        $nomeTitular = ucwords(strtolower(trim($_POST['nome_titular'])));

        // Criar método de pagamento com Stripe
        try {
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => ['token' => $stripeToken],
                'billing_details' => ['name' => $nomeTitular],
            ]);

            $paymentMethodID = $paymentMethod->id;

            // Inserir método de pagamento no banco de dados
            $sqlCartao = "INSERT INTO metodos_pagamento (utilizadorID, stripe_payment_method_id, nome_titular) VALUES (?, ? ,?)";
            $stmtCartao = mysqli_prepare($conn, $sqlCartao);

            if ($stmtCartao) {
                $metodo = 'Credit Card'; // Defina conforme necessário
                mysqli_stmt_bind_param($stmtCartao, "iss", $_SESSION['utilizadorID'], $paymentMethodID, $nomeTitular);
                mysqli_stmt_execute($stmtCartao);

                if (mysqli_stmt_affected_rows($stmtCartao) > 0) {
                    echo "<script>alert('Método de pagamento guardado com sucesso!'); window.location.href='metodosPagamento.php';</script>";
                } else {
                    echo "<script>alert('Erro ao guardar método de pagamento!'); window.location.href='novoMetodoPagamento.php';</script>";
                }

                mysqli_stmt_close($stmtCartao);
            } else {
                echo "<script>alert('Erro na preparação da consulta.'); window.location.href='novoMetodoPagamento.php';</script>";
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo "<script>alert('Erro ao criar método de pagamento: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='novoMetodoPagamento.php';</script>";
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primessups - Adcionar novo método de pagamento</title>
    <meta name="description" content="Adicione um novo método de pagamento na Primessups. Escolha entre diferentes opções de pagamento e preencha os detalhes do seu cartão para começar a usar novos métodos de pagamento em sua conta.">
    <meta name="keywords" content="adicionar método de pagamento, novo cartão, opções de pagamento, gerenciar pagamentos, Primessups">
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
    <link rel="stylesheet" href="../css/novoMetodoPagamento.css">
    <script type="text/javascript" src="../js/novoMetodoPagamento.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    
<div id="header"></div>

<main>
<div class="background1">

<div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
        <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
        <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
        <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
        <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
        <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

</div>
<div class="background2"><h1>Novo método de pagamento</h1></div>
    <div id="backgroundCard">
        <form id="payment-form" method="post" action="novoMetodoPagamento.php">
            <div class="form-group">
                <label class="labels" for="card-element"><h2>Cartão de Crédito</h2></label>
                <div id="card-element" class="form-control"></div>
                <div id="card-errors" role="alert"></div>
            </div>
            <div class="form-group">
                <input type="text" id="nome_titular" class="form-control" name="nome_titular" placeholder="Nome do titular" aria-label="Nome do titular" required>
            </div>
            </div>
            <button id="btnAdicionar" type="submit" class="btn btn-primary"><p>Adicionar</p></button>
        </form>

        <div class="posicaoDesktop">
            <div id="flexBoxSafeIcons">
                <div><i class="fa-brands fa-expeditedssl"></i></div>
                <div><i class="fa-brands fa-cc-visa"></i></div>
                <div><i class="fa-brands fa-cc-mastercard"></i></div>
                <div><i class="fa-brands fa-cc-amex"></i></div>
            </div>
        </div>
</main>

<div id="footer"></div>

</body>
</html>