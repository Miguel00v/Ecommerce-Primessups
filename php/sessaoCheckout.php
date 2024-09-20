<?php
session_start();

require 'stripe-php-master/init.php';
\Stripe\Stripe::setApiKey('sk_test_51PfikOJGkzLnsntVhosScn3zldDDKRQ6eeCAcgALkvheEMvhF6V8aN6RZy2G10KNev0yyeH9B7e0b9hgb7GVaLTp00ABmuArz7');

include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['total'];
    $metodoID = $_POST['metodoID'];
    $carrinhoID = $_POST['carrinhoID'];
    $desconto = $_POST['desconto'];
    $cupaoID = $_POST['cupaoID'];
    $custoEnvio = $_POST['custoEnvio'];
    $endereco = $_POST['endereco'];


    // Verificar se os dados estão presentes
    if (empty($amount) || empty($metodoID) || empty($carrinhoID) || $endereco == null) {
        echo "<script>alert('Dados incompletos para processar o pagamento.');
        window.location.href='checkout.php';</script>";
        exit;
    }

    // Substituir vírgula por ponto
    $amount = str_replace(',', '.', $amount);

    // Garantir que o valor seja numérico
    if (!is_numeric($amount)) {
        echo "<script>alert('O valor do pagamento deve ser numérico.');</script>";
        exit;
    }

    // Converter o valor para centavos
    $amountCents = intval($amount * 100);

    // Criar um pagamento com Stripe
    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amountCents, // valor em centavos
            'currency' => 'eur',
            'payment_method' => $metodoID,
            'confirm' => true,
            'return_url' => 'http://localhost/Trabalho%20final/Desenvolvimento/php/pagamentoConfirmado.php'
        ]);

        $carrinhoID = urlencode($carrinhoID);
        $desconto = urlencode($desconto);

        // Redirecionar ou exibir mensagem de sucesso
        header("Location: pagamentoConfirmado.php?carrinhoID=$carrinhoID&desconto=$desconto&custoEnvio=$custoEnvio&cupaoID=$cupaoID");
        exit;
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $errorMessage = addslashes($e->getMessage()); // Escapar a mensagem de erro para uso em JavaScript
        echo "<script>alert('Erro ao processar o pagamento: $errorMessage');
            window.location.href='checkout.php';
        </script>";
    }
}
?>