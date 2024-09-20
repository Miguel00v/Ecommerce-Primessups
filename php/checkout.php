<?php
session_start();

if (!isset($_SESSION['utilizadorID'])) {
    echo "<script> 
            alert('Não tem sessão iniciada.'); 
            window.location.href='iniciarSessao.php';
          </script>";
    exit(); 
}

$utilizadorID = $_SESSION['utilizadorID'];

include 'conexaobd.php';
require 'stripe-php-master/init.php';

//Selecionar nome e apelido
$sqlUtilizador = " SELECT nome, apelido FROM utilizadores WHERE utilizadorID = ? ";
$stmtUtilizador =mysqli_prepare($conn,$sqlUtilizador);
mysqli_stmt_bind_param($stmtUtilizador, "s", $utilizadorID);
mysqli_stmt_execute($stmtUtilizador);
mysqli_stmt_bind_result($stmtUtilizador, $nome, $apelido);
mysqli_stmt_fetch($stmtUtilizador);
mysqli_stmt_close($stmtUtilizador);

// Selecionar Endereço de envio principal
$sqlEndereco = "SELECT enderecoID, endereco, pais, codigoPostal, cidade FROM enderecos WHERE utilizadorID = ? AND predefinido = '1'";
$stmtEndereco = mysqli_prepare($conn, $sqlEndereco);

if ($stmtEndereco === false) {
    die('Erro ao preparar a consulta: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmtEndereco, "i", $utilizadorID);
mysqli_stmt_execute($stmtEndereco);

// Armazenar o resultado para contagem de linhas e vinculação de resultados
mysqli_stmt_store_result($stmtEndereco);

if (mysqli_stmt_num_rows($stmtEndereco) > 0) {
    mysqli_stmt_bind_result($stmtEndereco, $enderecoID, $endereco, $pais, $codigoPostal, $cidade);
    mysqli_stmt_fetch($stmtEndereco); // Obter os resultados
} else {
    // Se não há resultados, definir as variáveis como null ou qualquer outro valor padrão
    $enderecoID = $endereco = $pais = $codigoPostal = $cidade = null;
}

mysqli_stmt_close($stmtEndereco);

//Selecionar metodo de pagamento principal
$sql = "SELECT metodoID, stripe_payment_method_id, nome_titular FROM metodos_pagamento WHERE utilizadorID = ? AND predefinido = '1'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $metodoID, $stripe_payment_method_id, $nomeTitular);

$paymentMethods = [];
while (mysqli_stmt_fetch($stmt)) {
    $paymentMethods[] = [
        'metodoID' => $metodoID,
        'stripe_payment_method_id' => $stripe_payment_method_id,
        'billing_details' => ['name' => $nomeTitular]
    ];
}
mysqli_stmt_close($stmt);

// Função para obter detalhes do cartão através da API do Stripe
function getCardDetails($stripePaymentMethodId) {
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

//Dados fiscais de faturação
$sqlDadosFiscais = " SELECT NIF, endereco, pais, codigoPostal, cidade, nome, apelido FROM dados_fiscais WHERE utilizadorID = ? AND predefinido = '1' ";
$stmtDadosFiscais = mysqli_prepare($conn, $sqlDadosFiscais);
mysqli_stmt_bind_param($stmtDadosFiscais,'i',$utilizadorID);
mysqli_stmt_execute($stmtDadosFiscais);
mysqli_stmt_bind_result($stmtDadosFiscais,$NIF,$enderecoFiscal,$paisFiscal,$codigoPostalFiscal,$cidadeFiscal,$nomeFiscal,$apelidoFiscal);
mysqli_stmt_fetch($stmtDadosFiscais);

mysqli_stmt_close($stmtDadosFiscais);

// Obter os itens do carrinho e contar o número total de produtos
$sql = "SELECT itens_carrinho.itemID, produtos.produtoID, produtos.nome, produtos.preco, itens_carrinho.quantidade, 
        MIN(imagens_produtos.caminho) AS caminho_imagem
        FROM itens_carrinho 
        INNER JOIN produtos ON itens_carrinho.produtoID = produtos.produtoID 
        LEFT JOIN imagens_produtos ON produtos.produtoID = imagens_produtos.produtoID
        WHERE itens_carrinho.carrinhoID = ?
        GROUP BY itens_carrinho.itemID, produtos.produtoID, produtos.nome, produtos.preco, itens_carrinho.quantidade";

$stmt = mysqli_prepare($conn, $sql);

$carrinhoID = $_SESSION['carrinhoID'];
mysqli_stmt_bind_param($stmt, "i", $carrinhoID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$carrinho = [];
while ($row = mysqli_fetch_assoc($result)) {
    $carrinho[] = $row;
}
mysqli_stmt_close($stmt);

$total = 0;

foreach ($carrinho as $item) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total += $subtotal;
}

// Define o custo de envio
$custoEnvio = ($pais !== 'Portugal') ? 2.99 : 0.00;

// Total inicial incluindo custo de envio
$totalComEnvio = $total + $custoEnvio;

$descontoCupao = 0;
//Cupão
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cupao'])) {
    $cupao = trim($_POST['cupao']); 
    $cupao = strtolower($cupao);
    $sqlCupao = "SELECT tipoValor, valor, codigo, cupaoID FROM cupoes WHERE codigo = ? AND estado = 'ATIVO'";
    $stmtCupao = mysqli_prepare($conn, $sqlCupao);
    mysqli_stmt_bind_param($stmtCupao, 's', $cupao);
    mysqli_stmt_execute($stmtCupao);
    mysqli_stmt_bind_result($stmtCupao, $tipoValor, $valor, $codigo, $cupaoID);
    mysqli_stmt_fetch($stmtCupao);
    mysqli_stmt_close($stmtCupao);


    $response = [];
    if ($codigo) {

        if (strtolower($tipoValor) == 'percentual') {
            $percentual = $valor; 
            $descontoCupao = $percentual * $total;
        } else if (strtolower($tipoValor) == 'fixo') {
            $descontoCupao = $valor;
        }

        $totalAtualizado = $total - $descontoCupao + $custoEnvio;

        $response['cupao'] = $cupao;
        $response['desconto'] = number_format($descontoCupao, 2, ',', '.');
        $response['total'] = number_format($totalAtualizado, 2, ',', '.');
        $response['cupaoID'] = $cupaoID;
    } else {
        $response['error'] = 'Cupão inválido ou inativo.';
    }

    echo json_encode($response);
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Checkout</title>
    <meta name="description" content="Finalize sua compra com segurança na Primesupps. Complete o checkout de forma rápida e eficiente e garanta seus suplementos nutricionais preferidos com facilidade.">
    <meta name="keywords" content="checkout, finalização de compra, Primesupps, suplementos, segurança, pagamento, compra online, produtos nutricionais">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detetarDispositivoCheckout.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/checkout.js"></script>
    <link rel="stylesheet" href="../css/checkout.css">
</head>
<body>

<div id="header"></div>

<main>
        <div class="tituloDesktop" id="tituloDesktop">
            <i class="fa-solid fa-cart-shopping"></i>
            <h1>Checkout</h1>
        </div>
    <div class="backgroundEndereco">
        <div class="posicionamento">
            <div><h2>Endereço de envio atual</h2></div>
            <?php if ($endereco !== null) { ?>
            <div><p><strong><?php echo htmlspecialchars($nome).' '.htmlspecialchars($apelido) ?></strong></p></div>
                <div><p><?php echo htmlspecialchars($endereco); ?></p></div>
                <div><p><?php echo htmlspecialchars($codigoPostal) . '/' . htmlspecialchars($cidade) . '/' . htmlspecialchars($pais); ?></p></div>
        </div>
        <div class="divOutroEndereco"><a class="linkOutroEndereco" href="listaEnderecos.php" title="Escolher outra morada"><button  class="btnOutroEndereco" type="button"><p>Escolher outra morada</p></button></a></div>
        <?php } else { ?>
            <div><p>Nenhuma morada de envio selecionada</p></div>
            <div class="divOutroEndereco"><a class="linkOutroEndereco" href="listaEnderecos.php" title="Adicionar morada de envio"><button class="btnOutroEndereco" type="button"><p>Adicionar</p></button></a></div>
        <?php } ?>
    </div>

    <div class="backgroundPagamento">
    <div class="posicionamento"><h2>Método de pagamento</h2></div>
    <?php if ($metodoID == null): ?>
        <div><p>Nenhum método de pagamento selecionado</p></div>
        <div class="divOutroPagamento"><a class="linkOutroPagamento" href="metodosPagamento.php" title="Adicionar método de pagamento"><button class="btnOutroPagamento" type="button"><p>Adicionar</p></button></a></div>
    <?php else: ?>
        <?php if (!empty($paymentMethods)): ?>
            <?php foreach ($paymentMethods as $method): ?>
                <?php
                // Obtém os detalhes do cartão usando a API do Stripe
                $cardDetails = getCardDetails($method['stripe_payment_method_id']);
                ?>
                <div>
                    <div class="posicionamento">
                        <div class="iconPagamento"><?php echo getPaymentMethodIcon($method['stripe_payment_method_id']); ?></div>
                        <div>
                            <!-- Exibe o número do cartão com parte oculta -->
                            <?php if ($cardDetails && $cardDetails->card): ?>
                                <div>
                                    <div><?php echo '**** **** **** ' . htmlspecialchars(substr($cardDetails->card->last4, 0, 4)); ?></div>
                                    <div><p>Nome titular : <strong><?php echo htmlspecialchars($nomeTitular) ?></strong></p></div>
                                </div>
                    </div>
                            <div class="divOutroPagamento"><a class="linkOutroPagamento" href="metodosPagamento.php" title="Escolher outro método de pagamento"><button class="btnOutroPagamento" type="button"><p>Escolher outro método de pagamento</p></button></a></div>
                        <?php else: ?>
                            <div>Número do cartão não disponível.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="backgroundFaturacao">

    <div class="posicionamento"><h2>Dados fiscais de faturação</h2></div>
                <?php if ($NIF == null){ ?>

                    <div id="posicaoTexto"><p>Nenhum dado fiscal para faturação selecionado</p></div>
                    <div id="btnDadoFiscalMobile" class="divOutroDadoFiscal"><a class="linkOutroDadoFiscal" href="dadosFiscais.php" title="Adicionar método de pagamento"><button class="btnOutroDadoFiscal" type="button"><p>Adicionar</p></button></a></div>
                    <div id="btnDadoFiscalDesktop" class="divOutroDadoFiscal"><a class="linkOutroDadoFiscal" href="gerirDadosContaDesktop.php" title="Adicionar método de pagamento"><button class="btnOutroDadoFiscal" type="button"><p>Adicionar</p></button></a></div>
                    <?php } else{ ?>

                        <div class="posicionamento"><p><?php echo htmlspecialchars($nomeFiscal.' '.$apelidoFiscal) ?></p></div>
                        <div class="posicionamento"><p><?php echo htmlspecialchars($enderecoFiscal) ?></p></div>
                        <div class="posicionamento"><p><?php echo htmlspecialchars($codigoPostalFiscal) ?></p></div>
                        <div class="posicionamento"><p><?php echo htmlspecialchars($cidadeFiscal.' '.$paisFiscal) ?></p></div>
                        <div class="posicionamento"><p> NIF : <?php echo htmlspecialchars($NIF) ?></p></div>
                        <div class="divOutroDadoFiscal"><a class="linkOutroDadoFiscal" href="dadosFiscais.php" title="Escolher outros dados"><button class="btnOutroDadoFiscal" type="button"><p>Escolher outros dados</p></button></a></div>
                        <?php } ?>

</div>
    <!-- Inserir cupão -->
<div class="backgroundCupao">
<div class="disposicaoCupao">
    <div class="flexBoxCupao">
        <div><i class="fa-solid fa-tag"></i></div>
        <div><h2>Inserir cupão</h2></div>
    </div>    
    <form method="post" id="formCupao">

            <input id="cupao" type="text" name="cupao" value="" aria-label="Cupão">
            <button id="btnSubmeterCupao" type="submit">Inserir</button>
            <div><p>Nenhum cupão selecionado</p></div>

    </form> 
</div>

</div>
        <!-- Produtos do carrinho -->
<div>

    <div><h2>Seu pedido</h2></div>
    <div>
    <?php
        foreach ($carrinho as $item):?>
            <div id="divProdutos" class="item divProdutos" data-produto-id="<?php echo htmlspecialchars($item['produtoID']); ?>">
                <div>
                    <img class='imagemProduto' src="<?php echo htmlspecialchars($item['caminho_imagem']); ?>" alt="Imagem de <?php echo htmlspecialchars($item['nome']); ?>">
                </div>
                
                    <div class="nomeProduto"><p><?php echo htmlspecialchars($item['nome']); ?></p></div>   
                    <div class="quantidadeProduto"><p>Quantidade : <?php echo htmlspecialchars($item['quantidade']); ?></p></div>       
                    <div class="preco"><p><?php echo number_format($item['preco'], 2, ',', '.'); ?> €</p></div>
            </div>
    <?php endforeach; ?>

</div>
                    <!-- Resumo da compra -->
    <div class="backgroundResumo">

            <div><h2>Resumo</h2></div> 
            <div>

            <div>
                <div class="flexResumo">
                    <div><p>Subtotal</p></div>
                    <div><p id="subtotal"><?php echo number_format($total, 2, ',', '.') ?> €</p></div>
                </div>
                <div class="flexResumo">
                    <div><p>Envio</p></div>
                    <div><p><?php echo number_format($custoEnvio, 2, ',', '.') ?> €</p></div>
                </div>
                <div class="flexResumo">
                    <div><p>Desconto</p></div>
                    <div id="descontoValor"><p>0,00 €</p></div>
                </div>
                <hr>
                <div class="flexResumo">
                    <div><p>Total</p></div>
                    <div id="totalValor">
                        <p><?php echo number_format($totalComEnvio, 2, ',', '.') ?> €</p>
                    </div>
                </div>

            </div>           

    </div>

    <div id="footerMobileCheckout">
            <form method="post"  action="sessaoCheckout.php">
                <input type="hidden" name="endereco" value="<?php echo $endereco ?>">
                <input type="hidden" name="custoEnvio" value="<?php echo number_format($custoEnvio, 2, ',', '.') ?>">
                <input id="cupaoID" type="hidden" name="cupaoID" value="">
                <input id="desconto" type="hidden" name="desconto" value="">
                <input type="hidden" name="metodoID" value="<?php echo $stripe_payment_method_id ?>">
                <input type="hidden" name="carrinhoID" value="<?php echo $carrinhoID ?>">
                <input id="totalPagar" type="hidden" name="total" value="<?php echo number_format($totalComEnvio, 2, ',', '.') ?>">
                <button id="btnConfirmar" type="submit"><p>Confirmar compra</p></button>
            </form>
    </div>

</main>
</body>
</html>