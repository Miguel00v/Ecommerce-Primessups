<?php
session_start();

// Função para obter detalhes do produto e suas avaliações pelo ID
function getProdutoID($produtoID) {
    include 'conexaobd.php'; // Incluir arquivo de conexão com o banco de dados

    // Consulta para obter detalhes do produto e suas avaliações
    $sql = "SELECT p.*, ip.caminho, a.*, u.nome AS nome_utilizador, u.apelido AS apelido_utilizador
        FROM produtos p 
        LEFT JOIN imagens_produtos ip ON p.produtoID = ip.produtoID
        LEFT JOIN avaliacoes a ON p.produtoID = a.produtoID
        LEFT JOIN utilizadores u ON a.utilizadorID = u.utilizadorID
        WHERE p.produtoID = ?
        GROUP BY a.avaliacaoID";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $produtoID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Inicializa arrays para armazenar as avaliações e imagens
    $avaliacoes = [];
    $imagens = [];
    $produto = null;

    while ($row = mysqli_fetch_assoc($result)) {
        // Se o produto ainda não foi definido, define-o
        if (!$produto) {
            $produto = [
                'produtoID' => $row['produtoID'],
                'nome' => htmlspecialchars($row['nome']),
                'descricao' => htmlspecialchars($row['descricao']),
                'preco' => $row['preco'],
                'stock' => $row['stock'],
                'avaliacoes' => [],
                'imagens' => []
            ];
        }

        // Adiciona o caminho da imagem ao array de imagens (evita duplicações)
        if (!is_null($row['caminho']) && !in_array($row['caminho'], $imagens)) {
            $imagens[] = htmlspecialchars($row['caminho']);
        }

        // Adiciona a avaliação ao array de avaliações (evita duplicações)
        if (!is_null($row['avaliacaoID'])) {
            $avaliacoes[] = [
                'avaliacaoID' => $row['avaliacaoID'],
                'comentario' => htmlspecialchars($row['comentario']),
                'avaliacao' => $row['avaliacao'],
                'nome_utilizador' => htmlspecialchars($row['nome_utilizador']),
                'apelido_utilizador' => htmlspecialchars($row['apelido_utilizador'])
            ];
        }
    }

    mysqli_stmt_close($stmt); // Fechar a declaração preparada
    mysqli_close($conn); // Fechar a conexão

    // Adicionar as avaliações e imagens ao array do produto
    if ($produto) {
        $produto['avaliacoes'] = $avaliacoes;
        $produto['imagens'] = $imagens;
    }

    return $produto;
}

// Verificar se foi passado o parâmetro 'id' via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $produto = getProdutoID($id);

    // Verificar se o produto foi encontrado
    if ($produto) {
?>

        <!DOCTYPE html>
        <html lang="pt">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Primesupps - <?php echo htmlspecialchars($produto['nome']); ?></title>
            <meta name="description" content="<?php echo htmlspecialchars($produto['descricao']); ?>">
            <meta name="keywords" content="Suplementos, saúde, fitness, primesupps">
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
            <script type="text/javascript" src="../js/paginaProdutos.js"></script>
            <script type="text/javascript" src="../js/adicionarAOCarrinho.js"></script>
            <link rel="stylesheet" href="../css/paginaProdutos.css">
        </head>

        <body>

            <div id="header"></div>

            <main>
                <!-- Exibição dos detalhes do produto -->
                <div class="slideshowBanner">
                            <?php if (!empty($produto['imagens'])): ?>
                        <img class="imagemPd" id="imagemProduto" src="<?php echo htmlspecialchars($produto['imagens'][0]); ?>" alt="Imagem do produto">
                        <button class="prev" onclick="changeSlide(-1)"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="next" onclick="changeSlide(1)"><i class="fa-solid fa-chevron-right"></i></button>
                    <?php else: ?>
                        <p>Sem imagens disponíveis.</p>
                    <?php endif; ?>
                </div>
                    <div class="flexContainer">
                        <!-- Informações do produto -->
                        <div class="infoProduto">
                            <h2><?php echo htmlspecialchars($produto['nome']); ?></h2>
                            <h3>Preço: <?php echo number_format($produto['preco'], 2, ',', '.') . '€'; ?></h3>
                        </div>

                        <!-- Formulário para adicionar ao carrinho -->
                        <form id="formAdicionarAoCarrinho">
                            <div class="quantidadeContainer">
                                <h3>Quantidade</h3>
                                <div class="quantidadeControls btnsQntd">
                                    <!-- Botão para diminuir a quantidade -->
                                    <button type="button" class="quantidade-btn" id="diminuirQuantidade">
                                        <p>-</p>
                                    </button>
                                    <!-- Input para visualizar número de itens selecionados -->
                                    <input type="text" class="visualizarQuantidade" id="visualizarQuantidade" name="visualizarQuantidade" value="1" readonly>
                                    <!-- Botão para aumentar a quantidade -->
                                    <button type="button" class="quantidade-btn" id="aumentarQuantidade">
                                        <p>+</p>
                                    </button>
                                </div>
                                <!-- Campos hidden para envio de informações -->
                                <input type="hidden" id="produtoID" name="produtoID" value="<?php echo htmlspecialchars($id); ?>">
                                <input type="hidden" id="stock" name="stock" value="<?php echo htmlspecialchars($produto['stock']); ?>">
                                <input type="hidden" id="quantidade" name="quantidade" value="1">
                            </div>
                    </div>
                    <!-- Botão para adicionar ao carrinho -->
                    <button id="btnAdicionarCarrinho" type="button">
                        <p>Adicionar ao carrinho</p>
                    </button>
                    </form>

                    <!-- Descrição do produto -->
                    <div class="descricaoProduto">
                        <h2 id="tituloDescricao">Descrição</h2>
                        <p id="descricao"><?php echo nl2br(htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8')); ?></p>
                    </div>

                    <!-- Avaliações do produto -->
                    <div class="avaliacoesProduto">
                        <h2>Avaliações</h2>
                        <?php foreach ($produto['avaliacoes'] as $avaliacao): ?>
                            <div class="avaliacao">
                                <h3 id="nomeUtilizadorAvaliacao"><?php echo htmlspecialchars($avaliacao['nome_utilizador'] . ' ' . $avaliacao['apelido_utilizador']); ?></h3>
                                <div class="avaliacao-estrelas" data-avaliacao="<?php echo htmlspecialchars($avaliacao['avaliacao']); ?>"><p></p></div>
                                <div class="comentario">
                                    <p><?php echo nl2br(htmlspecialchars($avaliacao['comentario'], ENT_QUOTES, 'UTF-8')); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
            </main>

            <div id="footer"></div>


            <script>
        // Variáveis JavaScript
        const slides = <?php echo json_encode($produto['imagens']); ?>;
        let slideIndex = 0;

        function showSlide(index) {
            const imgElement = document.getElementById('imagemProduto');
            imgElement.src = slides[index];
        }

        function changeSlide(n) {
            slideIndex += n;
            if (slideIndex >= slides.length) {
                slideIndex = 0;
            } else if (slideIndex < 0) {
                slideIndex = slides.length - 1;
            }
            showSlide(slideIndex);
        }

        // Mostrar a primeira imagem ao carregar
        showSlide(slideIndex);
    </script>
        </body>

        </html>
<?php
    } else {
        // Produto não encontrado
        echo "<script>alert('Produto não encontrado'); window.location.href='index.php';</script>";
    }
} else {
    // Caso 'id' não tenha sido recebido via GET, exibe uma mensagem de erro ou redireciona
    echo "<script>alert('Não foi possível carregar a página!'); window.location.href='index.php';</script>";
}

?>