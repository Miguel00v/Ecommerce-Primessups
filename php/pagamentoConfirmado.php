<?php 

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;
include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];
$carrinhoID = $_GET['carrinhoID'];
$custoEnvio = $_GET['custoEnvio'];
$desconto = $_GET['desconto'];
$cupaoID = $_GET['cupaoID'];

if ($cupaoID == '') {
    $cupaoID = null;
}

// Colocar o carrinhoID como finalizado
$sqlCarrinho = "UPDATE carrinhos SET estado = '1' WHERE carrinhoID = ?";
$stmtCarrinho = mysqli_prepare($conn, $sqlCarrinho);
mysqli_stmt_bind_param($stmtCarrinho, "i", $carrinhoID);
mysqli_stmt_execute($stmtCarrinho);
mysqli_stmt_close($stmtCarrinho);
//Remover da sessao
unset($_SESSION['carrinhoID']);

// Selecionar email para envio de fatura
$sql = "SELECT email, nome, apelido FROM utilizadores WHERE utilizadorID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $email, $nome, $apelido);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Dados fiscais de faturação
$sqlDadosFiscais = "SELECT dadosFiscaisID, NIF, endereco, pais, codigoPostal, cidade, nome, apelido FROM dados_fiscais WHERE utilizadorID = ? AND predefinido = '1'";
$stmtDadosFiscais = mysqli_prepare($conn, $sqlDadosFiscais);
if ($stmtDadosFiscais) {
    mysqli_stmt_bind_param($stmtDadosFiscais, 'i', $utilizadorID);
    mysqli_stmt_execute($stmtDadosFiscais);
    mysqli_stmt_bind_result($stmtDadosFiscais, $dadosFiscaisID, $NIF, $enderecoFiscal, $paisFiscal, $codigoPostalFiscal, $cidadeFiscal, $nomeFiscal, $apelidoFiscal);
    mysqli_stmt_fetch($stmtDadosFiscais);
    mysqli_stmt_close($stmtDadosFiscais);
} else {
    die("Erro na preparação da consulta: " . mysqli_error($conn));
}

// Selecionar método de pagamento principal
$sqlMethoPagamento = "SELECT metodoID FROM metodos_pagamento WHERE utilizadorID = ? AND predefinido = '1'";
$stmtMethoPagamento = mysqli_prepare($conn, $sqlMethoPagamento);
mysqli_stmt_bind_param($stmtMethoPagamento, 'i', $utilizadorID);
mysqli_stmt_execute($stmtMethoPagamento);
mysqli_stmt_bind_result($stmtMethoPagamento, $metodoPagamentoID);
mysqli_stmt_fetch($stmtMethoPagamento);
mysqli_stmt_close($stmtMethoPagamento);

// Selecionar Endereço de envio principal
$sqlEndereco = "SELECT enderecoID, endereco, pais, codigoPostal, cidade FROM enderecos WHERE utilizadorID = ? AND predefinido = '1'";
$stmtEndereco = mysqli_prepare($conn, $sqlEndereco);
mysqli_stmt_bind_param($stmtEndereco, "i", $utilizadorID);
mysqli_stmt_execute($stmtEndereco);
mysqli_stmt_store_result($stmtEndereco);

if (mysqli_stmt_num_rows($stmtEndereco) > 0) {
    mysqli_stmt_bind_result($stmtEndereco, $enderecoID, $endereco, $pais, $codigoPostal, $cidade);
    mysqli_stmt_fetch($stmtEndereco);
} else {
    $enderecoID = $endereco = $pais = $codigoPostal = $cidade = null;
}
mysqli_stmt_close($stmtEndereco);

// Selecionar produtos
$sqlProdutos = "SELECT itens_carrinho.itemID, produtos.produtoID, produtos.nome, produtos.preco, itens_carrinho.quantidade, 
    MIN(imagens_produtos.caminho) AS caminho_imagem
    FROM itens_carrinho 
    INNER JOIN produtos ON itens_carrinho.produtoID = produtos.produtoID 
    LEFT JOIN imagens_produtos ON produtos.produtoID = imagens_produtos.produtoID
    WHERE itens_carrinho.carrinhoID = ?
    GROUP BY itens_carrinho.itemID, produtos.produtoID, produtos.nome, produtos.preco, itens_carrinho.quantidade";

$stmtProdutos = mysqli_prepare($conn, $sqlProdutos);
mysqli_stmt_bind_param($stmtProdutos, "i", $carrinhoID);
mysqli_stmt_execute($stmtProdutos);
$result = mysqli_stmt_get_result($stmtProdutos);

$carrinho = [];
while ($row = mysqli_fetch_assoc($result)) {
    $carrinho[] = $row;
}
mysqli_stmt_close($stmtProdutos);

$total = 0;
foreach ($carrinho as $item) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total += $subtotal;
}

// Remover vírgulas e converter para float
$custoEnvio = str_replace(',', '.', $custoEnvio);
$desconto = str_replace(',', '.', $desconto);
$custoEnvio = is_numeric($custoEnvio) ? floatval($custoEnvio) : 0;
$desconto = is_numeric($desconto) ? floatval($desconto) : 0;
$valorFinal = $total + $custoEnvio - $desconto;

$dataFormatada = date('Y-m-d H:i:s');
$randomNumber = mt_rand(10000, 99999);
$numeroEncomenda = 'PS' . $randomNumber;
$estado = 'Processando';

// Inserir encomenda na tabela encomendas
$sqlEncomenda = "INSERT INTO encomendas (enderecoID, utilizadorID, data, total, estado, numeroEncomenda, cupaoID, dadosFiscaisID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmtEncomenda = mysqli_prepare($conn, $sqlEncomenda);
mysqli_stmt_bind_param($stmtEncomenda, "iissssii", $enderecoID, $utilizadorID, $dataFormatada, $valorFinal, $estado, $numeroEncomenda, $cupaoID, $dadosFiscaisID);
mysqli_stmt_execute($stmtEncomenda);
mysqli_stmt_close($stmtEncomenda);

//Inserir itens na tabela itens_encomenda
$encomendaID = mysqli_insert_id($conn);
$sqlItemEncomenda = "INSERT INTO itens_encomenda (encomendaID, produtoID, quantidade) VALUES (?, ?, ?)";

$stmtItemEncomenda = mysqli_prepare($conn, $sqlItemEncomenda);
if (!$stmtItemEncomenda) {
    die("Erro na preparação da consulta: " . mysqli_error($conn));
}

foreach ($carrinho as $item) {
    $produtoID = $item['produtoID'];
    $quantidade = $item['quantidade'];
    mysqli_stmt_bind_param($stmtItemEncomenda, "iii", $encomendaID, $produtoID, $quantidade);
    mysqli_stmt_execute($stmtItemEncomenda);

    if (mysqli_stmt_error($stmtItemEncomenda)) {
        echo "Erro ao inserir item: " . mysqli_stmt_error($stmtItemEncomenda);
    }
}

mysqli_stmt_close($stmtItemEncomenda);

//Atualizar stock
$sqlAtualizarStock = "UPDATE produtos SET stock = stock - ? WHERE produtoID = ?";
$stmtAtualizarStock = mysqli_prepare($conn, $sqlAtualizarStock);

foreach ($carrinho as $item) {
    mysqli_stmt_bind_param($stmtAtualizarStock, "ii", $item['quantidade'], $item['produtoID']);
    mysqli_stmt_execute($stmtAtualizarStock);
}

// Fechar o statement após atualizar o Stock
mysqli_stmt_close($stmtAtualizarStock);


//Criar pdf
require '../php/dompdf/vendor/autoload.php';

// Função para capturar o HTML da fatura
function get_fatura_html($nome, $apelido, $numeroEncomenda, $carrinho, $desconto, $valorFinal,$NIF, 
$enderecoFiscal, $paisFiscal, $codigoPostalFiscal, $cidadeFiscal, $nomeFiscal, $apelidoFiscal, $endereco, $pais, $codigoPostal, $cidade) {
    ob_start();
    include 'fatura.php';
    return ob_get_clean();
}

// Capture o HTML em uma variável
$html = get_fatura_html($nome, $apelido, $numeroEncomenda, $carrinho, $desconto, $valorFinal,$NIF,
 $enderecoFiscal, $paisFiscal, $codigoPostalFiscal, $cidadeFiscal, $nomeFiscal, $apelidoFiscal, $endereco, $pais, $codigoPostal, $cidade);

// Configurações do Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Salve o PDF em uma variável
$pdfOutput = $dompdf->output();
$pdfFilePath = 'fatura.pdf';
file_put_contents($pdfFilePath, $pdfOutput);;

// Enviar email
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/Exception.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'primesupps.pt@gmail.com';
    $mail->Password = 'nyjh klzg usde zont';
    $mail->Port = 587;

    $mail->setFrom('primesupps.pt@gmail.com', 'Primesupps');
    $mail->addAddress($email, $nome . ' ' . $apelido);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Confirmação de compra';
    $mail->Body = '<h1>Primesupps</h1><p>Obrigado pela sua compra!</p>';

    $mail->addAttachment($pdfFilePath);

    $mail->send();
    echo "<script>alert('Pagamento bem sucedido. Foi-lhe enviada a fatura para o seu email.');</script>";
} catch (Exception $e) {
    echo "<script>alert('O pagamento foi bem sucedido. Ocorreu um erro ao enviar email: " . addslashes($mail->ErrorInfo) . "');</script>";
}
unlink($pdfFilePath);

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Pagamento bem sucedido</title>
    <meta name="description" content="Pagamento efetuado com sucesso na Primesupps.">
    <meta name="keywords" content="primesupps, pagamento, sucesso">
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
    <link rel="stylesheet" href="../css/pagamentoConfirmado.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script type="text/javascript" src="../js/pagamentoConfirmado.js"></script>
</head>
<body onload="startConfetti()">

    <div id="header"></div>

    <main>
    <div class="imagemConfirmacao"><img class="imagemII" src="../imagens/outras/pagamentoConfirmado.svg" alt="Pagamento Confirmado" ></div>
        <div class="background">

            <div class="titulo"><h2>Seu pedido foi realizado com sucesso</h2></div>
        <!-- Produtos do pedido -->
            <div class="container">
                <?php
                    foreach ($carrinho as $item):?>
                    <div id="divProdutos" class="item divProdutos" data-produto-id="<?php echo htmlspecialchars($item['produtoID']); ?>">
                <div>
                    <img class="imagemProduto" id="imagemProduto" src="<?php echo htmlspecialchars($item['caminho_imagem']); ?>" alt="Imagem de <?php echo htmlspecialchars($item['nome']); ?>">
                </div>
                
                    <div class="nomeProduto"><p><?php echo htmlspecialchars($item['nome']); ?></p></div>   
                    <div class="quantidadeProduto"><p>Quantidade : <?php echo htmlspecialchars($item['quantidade']); ?></p></div>       
                    <div class="preco"><p><?php echo number_format($item['preco'], 2, ',', '.'); ?> €</p></div>
            </div>
            <?php endforeach; ?>

        <!-- Preço da compra -->
         <div class="backgroundResumo">

            <div><h3>Resumo</h3></div>
            <div>

                    <div class="flexResumo">
                        <div><p>Subtotal</p></div>
                        <div><p><?php echo number_format($total, 2, ',', '.') ?> €</p></div>
                    </div>
                    <div class="flexResumo">
                        <div><p>Envio</p></div>
                        <div><p><?php echo number_format($custoEnvio, 2, ',', '.') ?> €</p></div>
                    </div>
                    <div class="flexResumo">
                        <div><p>Desconto</p></div>
                        <div><p><?php echo number_format($desconto, 2, ',', '.') ?> €</p></div>
                    </div>
                    <hr>
                    <div class="flexResumo">
                        <div><p>Total</p></div>
                        <div><p><?php echo number_format($valorFinal, 2, ',', '.') ?> €</p></div>
                    </div>
         </div>

         </div>
         <hr>
            <div class="flexboxEmail">
                <div><i class="fa-solid fa-envelope"></i></div>
                <div><p>Foi enviado um email para <strong><?php echo htmlspecialchars($email) ?></strong>, com todas as informações do pedido.</p></div>
            </div>

    </main>

    <div id="footer"></div>
</body>
</html>
