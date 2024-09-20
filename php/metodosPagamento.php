<?php
session_start();

// Redireciona para a página anterior, se disponível, ou para a página inicial
$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>
        alert('Precisa de iniciar sessão para aceder a esta página.');
        window.location.href='iniciarSessao.php';
    </script>";
    exit();
}

include 'conexaobd.php';
require 'stripe-php-master/init.php';

$utilizadorID = $_SESSION['utilizadorID'];

// Recupera métodos de pagamento
$sql = "SELECT metodoID, stripe_payment_method_id, predefinido, nome_titular FROM metodos_pagamento WHERE utilizadorID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $metodoID, $stripe_payment_method_id, $predefinido, $nomeTitular);

$paymentMethods = [];
while (mysqli_stmt_fetch($stmt)) {
    $paymentMethods[] = [
        'metodoID' => $metodoID,
        'stripe_payment_method_id' => $stripe_payment_method_id,
        'billing_details' => ['name' => $nomeTitular],
        'predefinido' =>$predefinido
    ];
}
mysqli_stmt_close($stmt);

// Função para obter detalhes do cartão através da API do Stripe
function getCardDetails($stripePaymentMethodId) {
    // Configure a biblioteca Stripe
    \Stripe\Stripe::setApiKey('sk_test_51PfikOJGkzLnsntVhosScn3zldDDKRQ6eeCAcgALkvheEMvhF6V8aN6RZy2G10KNev0yyeH9B7e0b9hgb7GVaLTp00ABmuArz7'); // Substitua pela sua chave secreta do Stripe
    try {
        $paymentMethod = \Stripe\PaymentMethod::retrieve($stripePaymentMethodId);
        return $paymentMethod;
    } catch (Exception $e) {
        // Em caso de erro, você pode querer registrar o erro ou lidar com ele de outra forma
        return null;
    }
}

function getPaymentMethodIcon($stripePaymentMethodId) {
    // Configure a biblioteca Stripe
    \Stripe\Stripe::setApiKey('sk_test_51PfikOJGkzLnsntVhosScn3zldDDKRQ6eeCAcgALkvheEMvhF6V8aN6RZy2G10KNev0yyeH9B7e0b9hgb7GVaLTp00ABmuArz7'); // Substitua pela sua chave secreta do Stripe

    try {                                                      
        $paymentMethod = \Stripe\PaymentMethod::retrieve($stripePaymentMethodId);
        $cardBrand = $paymentMethod->card->brand;

        // Retorna o ícone baseado na marca do cartão
        switch ($cardBrand) {
            case 'visa':
                return '<i class="fa-brands fa-cc-visa"></i>';
            case 'mastercard':
                return '<i class="fa-brands fa-cc-mastercard"></i>';
            case 'amex':
                return '<i class="fa-brands fa-cc-amex"></i>';
            case 'maestro':
                return '<i class="fa-brands fa-cc-maestro"></i>'; // Supondo que você tenha um ícone para Maestro
            default:
                return '<i class="fa-solid fa-credit-card"></i>'; // Ícone genérico
        }
    } catch (Exception $e) {
        // Em caso de erro, você pode querer registrar o erro ou lidar com ele de outra forma
        return '<i class="fa-solid fa-credit-card"></i>'; // Ícone genérico em caso de erro
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primessups - Métodos de pagamento</title>
    <meta name="description" content="Gerencie seus métodos de pagamento de forma fácil e segura com a Primessups. Veja todos os métodos guardados e escolha o seu método de pagamento predefinido.">
    <meta name="keywords" content="métodos de pagamento, pagamentos online, gerenciar cartões, predefinir pagamento, Primessups">
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
    <script type="text/javascript" src="../js/metodosPagamento.js"></script>
    <link rel="stylesheet" href="../css/metodosPagamento.css">
</head>
<body>

<div id="header"></div>

<main>
<div class="background2"><h1>Meus métodos de pagamento</h1></div>

<div class="background1">

<div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
        <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
        <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
        <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
        <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
        <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

</div>
    <?php if (!empty($paymentMethods)): ?>
        <?php foreach ($paymentMethods as $method): ?>
            <?php
            // Obtém os detalhes do cartão usando a API do Stripe
            $cardDetails = getCardDetails($method['stripe_payment_method_id']);
            ?>
            <div id="background">
                <div id="containerInfoCard">
                    <div id="iconePagamento"><?php echo getPaymentMethodIcon($method['stripe_payment_method_id']); ?></div>
                    <div>
                        <!-- Exibe o número do cartão com parte oculta -->
                        <?php if ($cardDetails && $cardDetails->card): ?>
                            <div class="conteudoSensivel">
                                <div class="oculto" id="cartao-<?php echo $method['metodoID']; ?>">
                                    <?php echo '**** **** **** ' . htmlspecialchars(substr($cardDetails->card->last4, 0, 4)); ?>
                            </div>
                            <div><p>Nome do titular :<?php echo'  '. htmlspecialchars($nomeTitular) ?></p></div>
                            </div>
                        <?php else: ?>
                            <div><p>Número do cartão não disponível.</p></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <form method="post" action="atualizarMetodoPagamentoPredefinido.php">
                            <input type="hidden" name="metodoID1" value="<?php echo htmlspecialchars($method['metodoID']); ?>">
                            <div id="flexboxCheckbox">
                                <input type="checkbox" name="pagamentoPredefinida" <?php echo ($method['predefinido'] ? 'checked' : ''); ?>>
                                <label>Forma de pagamento predefinida</label>
                            </div>
                        </form>
                    </div>
                    <div>
                        <form method="post" action="removerMetodoPagamento.php">
                            <input type="hidden" name="metodoID2" value="<?php echo htmlspecialchars($method['metodoID']); ?>">
                            <button id="btnRemover" type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>
            <div id="semPagamentos"><h2>Não tem métodos de pagamento guardados.</h2></div>
        </div>
    <?php endif; ?>
    <a id="btnAdicionarPagamento" href="novoMetodoPagamento.php" title="Adicionar método de pagamento"><button type="button"><p>Novo método de pagamento</p></button></a>
</main>

<div id="footer"></div>

</body>
</html>