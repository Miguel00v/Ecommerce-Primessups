<?php
session_start();

include 'conexaobd.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>alert('Precisa de iniciar sessão para poder comprar!'); window.location.href='iniciarSessao.php';</script>";
    exit;
}

$utilizadorID = $_SESSION['utilizadorID'];

// Função para obter ou criar um carrinho
function obterOuCriarCarrinho($conn, $utilizadorID) {
    // Verificar se já existe um carrinho ativo na sessão
    if (!isset($_SESSION['carrinhoID'])) {
        // Procurar por um carrinho existente
        $sqlBuscarCarrinho = "SELECT carrinhoID FROM carrinhos WHERE utilizadorID = ? AND estado = 0 LIMIT 1";
        $stmtBuscarCarrinho = mysqli_prepare($conn, $sqlBuscarCarrinho);
        if ($stmtBuscarCarrinho) {
            mysqli_stmt_bind_param($stmtBuscarCarrinho, "i", $utilizadorID);
            mysqli_stmt_execute($stmtBuscarCarrinho);
            mysqli_stmt_store_result($stmtBuscarCarrinho);

            if (mysqli_stmt_num_rows($stmtBuscarCarrinho) > 0) {
                mysqli_stmt_bind_result($stmtBuscarCarrinho, $carrinhoID);
                mysqli_stmt_fetch($stmtBuscarCarrinho);
                $_SESSION['carrinhoID'] = $carrinhoID;
            } else {
                // Criar um novo carrinho
                $sqlInsertCarrinho = "INSERT INTO carrinhos (utilizadorID) VALUES (?)";
                $stmtInsertCarrinho = mysqli_prepare($conn, $sqlInsertCarrinho);
                if ($stmtInsertCarrinho) {
                    mysqli_stmt_bind_param($stmtInsertCarrinho, 'i', $utilizadorID);
                    mysqli_stmt_execute($stmtInsertCarrinho);

                    if (mysqli_stmt_affected_rows($stmtInsertCarrinho) > 0) {
                        $carrinhoID = mysqli_insert_id($conn);
                        $_SESSION['carrinhoID'] = $carrinhoID;
                    } else {
                        echo "<script>alert('Erro ao criar o carrinho.');</script>";
                        exit();
                    }
                    mysqli_stmt_close($stmtInsertCarrinho);
                } else {
                    die('Erro na consulta SQL: ' . mysqli_error($conn));
                }
            }
            mysqli_stmt_close($stmtBuscarCarrinho);
        } else {
            die('Erro na consulta SQL: ' . mysqli_error($conn));
        }
    }
    return $_SESSION['carrinhoID'];
}

$carrinhoID = obterOuCriarCarrinho($conn, $utilizadorID);

// Obter itens do carrinho
$sql = "SELECT itens_carrinho.itemID, produtos.produtoID, produtos.nome, produtos.preco, itens_carrinho.quantidade, imagens_produtos.caminho AS caminho_imagem
FROM itens_carrinho 
INNER JOIN produtos ON itens_carrinho.produtoID = produtos.produtoID 
LEFT JOIN imagens_produtos ON produtos.produtoID = imagens_produtos.produtoID
WHERE itens_carrinho.carrinhoID = ?
GROUP BY itens_carrinho.produtoID";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $carrinhoID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $itens = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $totalProdutos = mysqli_num_rows($result);

    mysqli_stmt_close($stmt);
} else {
    echo "Erro na consulta: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Carrinho de Compras</title>
    <meta name="description" content="Confira os itens no seu carrinho de compras e finalize sua compra na nossa loja online. Oferecemos uma ampla variedade de produtos a preços acessíveis.">
    <meta name="keywords" content="compras online, carrinho de compras, suplementos, Primesupps, loja online">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detetarDispositivoCarrinho.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/carrinho.js"></script>
    <link rel="stylesheet" href="../css/carrinho.css">
</head>
<body>

<div id="header"></div>

<main id="mainCheio">
<?php if ($itens): ?>
    <?php if($totalProdutos == 1): ?>
        <p>1 produto</p>
    <?php else: ?>
        <p><?php echo $totalProdutos; ?> produtos</p>
    <?php endif; ?>

    <?php
    $total = 0;
    foreach ($itens as $item):
        $subtotal = $item['preco'] * $item['quantidade'];
        $total += $subtotal;
    ?>
        <div id="itens" class="item" data-produto-id="<?php echo htmlspecialchars($item['produtoID']); ?>">
                <img class="imagemProduto" id="imagemProduto" src="<?php echo htmlspecialchars($item['caminho_imagem']); ?>" alt="Imagem de <?php echo htmlspecialchars($item['nome']); ?>">
            <div>
                <div id="nomeProduto"><p><?php echo htmlspecialchars($item['nome']); ?></p></div>
                <div>
                    <form method="post" action="removerProdutoCarrinho.php">
                        <input type="hidden" name="produtoID" value="<?php echo htmlspecialchars($item['produtoID']); ?>">
                        <input type="hidden" name="carrinhoID" value="<?php echo htmlspecialchars($carrinhoID) ?>">
                        <button id="btnRemoverProduto" type="submit"><i class="fa-solid fa-x"></i></button>
                    </form>
                </div>
                <div>
                    <div>
                        <?php 
                            $sqlProduto = "SELECT stock FROM produtos WHERE produtoID = ?";
                            $stmtProduto = mysqli_prepare($conn, $sqlProduto);
                            mysqli_stmt_bind_param($stmtProduto, "i", $item['produtoID']);
                            mysqli_stmt_execute($stmtProduto);
                            mysqli_stmt_bind_result($stmtProduto, $stock);
                            mysqli_stmt_fetch($stmtProduto);
                            mysqli_stmt_close($stmtProduto);
                        ?>
                        <form class="formAdicionarAoCarrinho">
                            <div class="btnsQntd">
                                <button type="button" class="quantidade-btn diminuirQuantidade"><p>-</p></button>
                                <input type="text" class="visualizarQuantidade" name="visualizarQuantidade" value="<?php echo htmlspecialchars($item['quantidade']); ?>" readonly>
                                <button type="button" class="quantidade-btn aumentarQuantidade"><p>+</p></button>
                            </div>
                            <input type="hidden" class="produtoID" name="produtoID" value="<?php echo htmlspecialchars($item['produtoID']); ?>">
                            <input type="hidden" class="stock" name="stock" value="<?php echo htmlspecialchars($stock); ?>">
                        </form>
                    </div>
                    <div id="precoProduto"><p class="preco"><?php echo number_format($item['preco'], 2, ',', '.'); ?> €</p></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div id="resumoCompra" class="resumoDaCompra">
        <div><h2>Resumo</h2></div>
        <div class="resumoFlexbox">
            <div><p>Subtotal</p></div>
            <div><p class="subtotal"><?php echo number_format($total, 2, ',', '.'); ?> €</p></div>
        </div>
        <div class="resumoFlexbox">
            <div><p>Envio</p></div>
            <div>
                <?php
                    $sqlCustoEnvio = "SELECT pais FROM enderecos WHERE utilizadorID = ? AND predefinido = '1'";
                    $stmtCustoEnvio = mysqli_prepare($conn, $sqlCustoEnvio);
                    mysqli_stmt_bind_param($stmtCustoEnvio, "i", $utilizadorID);
                    mysqli_stmt_execute($stmtCustoEnvio);
                    mysqli_stmt_bind_result($stmtCustoEnvio, $pais);
                    mysqli_stmt_fetch($stmtCustoEnvio);
                    mysqli_stmt_close($stmtCustoEnvio); 

                    $custoEnvio = ($pais !== 'Portugal') ? 2.99 : 0.00;
                ?>
                <p id="custoEnvio"><?php echo number_format($custoEnvio, 2, ',', '.'); ?> €</p>
            </div>
        </div>
        <hr>
        <div class="resumoFlexbox">
            <div><p>Total</p></div>
            <div>
                <p class="total-geral"><?php echo number_format($total + $custoEnvio, 2, ',', '.'); ?> €</p>
            </div>
        </div>
    </div>
</main>
<footer class="footerVazio">
    <div>
        <a class="btnComprar" href="checkout.php" title="Finalizar compra"><button class="btnCompra" type="button"><p>Finalizar compra</p></button></a>
    </div>
</footer>

<?php else: ?>
    <main id="mainVazio">
        <div><p>0 produtos</p></div>
        <div class="backgroundCarrinho"><i id="cartVazio" class="fa-solid fa-cart-shopping"></i></div>
        <h1 class="alinharTitulo">Seu carrinho está vazio!</h1>
        <div class="alinharSmile"><i class="fa-solid fa-face-sad-tear"></i></div>
    </main>
    <footer class="footerVazio">
        <div>
            <a class="btnComprar" href="../index.php" title="Comprar agora"><button class="btnCompra" type="button"><p>Comprar agora</p></button></a>
        </div>
    </footer>
<?php endif; ?>

</body>
</html>