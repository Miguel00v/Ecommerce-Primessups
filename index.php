<?php

    session_start();

    include'../Desenvolvimento/php/conexaobd.php';

    $sql = "SELECT ip.caminho, p.preco, p.nome, p.produtoID FROM produtos p JOIN imagens_produtos ip ON p.produtoID = ip.produtoID WHERE 
    p.destaque = '1'AND ip.imagemID = ( SELECT MIN(ip2.imagemID) FROM imagens_produtos ip2 WHERE ip2.produtoID = p.produtoID);";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $produtos = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $produtos[] = $row;
        }
    } else {
        echo "<script> alert('Erro na consulta:" . mysqli_error($conn).")';</script>";
    }
    
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Página inicial - Suplementos Nutricionais</title>
    <meta name="description" content="Encontre os melhores suplementos nutricionais na Primesupps. Produtos em destaque, vitaminas, proteínas e mais.">
    <meta name="keywords" content="suplementos nutricionais, vitaminas, proteínas, saúde, bem-estar, musculação, emagrecimento, fitness, whey protein, creatina, BCAA, multivitamínico">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/regrasEstilo.css">
    <script type="text/javascript" src="js/detecaoDispositivoIndex.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="css/footerMobile.css">
    <link rel="stylesheet" href="css/headerDesktop.css">
    <link rel="stylesheet" href="css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <link rel="stylesheet" href="css/index.css">
</head>

<body onload="showSlides(), updateCartCount()">
    <!-- Carregamento de header com base na dimensão da tela -->
    <div id="header"></div>

    <main>
            <!-- Carrossel de banners -->
            <div class="slideshowBanner">
                <div class="mySlides fade">
                    <img src="imagens/Banners/Bem-Vindo à PrimeSupps!.png" alt="Banner1" style="width:100%">
                </div>
                <div class="mySlides fade">
                    <img src="imagens/Banners/Descontos e Promoções.png" alt="Banner2" style="width:100%">
                </div>
                <div class="mySlides fade">
                    <img src="imagens/Banners/Variedade de Opções.png" alt="Banner3" style="width:100%">
                </div>
                <div class="mySlides fade">
                    <img src="imagens/Banners/Bem-estar Integral.png" alt="Banner4" style="width:100%">
                </div>
                <div class="dotsContainer" style="text-align:center">
                    <div class="dot" onclick="currentSlide(1)"></div>
                    <div class="dot" onclick="currentSlide(2)"></div>
                    <div class="dot" onclick="currentSlide(3)"></div>
                    <div class="dot" onclick="currentSlide(4)"></div>
                </div>
            </div>

            <div>
                <h1 id="tituloProdutosDestaque">Produtos em destaque</h1>
                <div class="produtosContainer">
                <?php foreach ($produtos as $produto) { ?>
                <a href="php/paginaProdutos.php?id=<?php echo htmlspecialchars($produto['produtoID'])?>">
                    <div class="gallery">
                        <img src="<?php $produtoCaminho = str_replace("../", "", $produto['caminho']);
                         echo htmlspecialchars($produtoCaminho) ?>" alt="<?php echo htmlspecialchars($produto['nome'])?>">
                        <div class="desc"><?php echo htmlspecialchars($produto['nome'])?></div>
                        <div class="preco"><?php echo htmlspecialchars(number_format($produto['preco'], 2,',','.')) ?>€</div>
                    </div>
                </a>
                <?php } ?>
                </div>
            </div>

            <!-- Carrossel de informações -->
            <div class="slideshow2">
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Avaliações de Clientes da Prim.png" alt="Informação1" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Creatina.png" alt="Informação2" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Suplementos de Alta Qualidade.png" alt="Informação3" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Vitaminas e Minerais.png" alt="Informação4" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Aminoácidos.png" alt="Informação5" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Emagrecimento.png" alt="Informação6" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Real Whey.png" alt="Informação7" style="width:100%">
                </div>
                <div class="mySlides2 fade">
                    <img src="imagens/Banners/Whey Hydro Isolate.png" alt="Informação8" style="width:100%">
                </div>
                <div class="dotsContainer" style="text-align:center">
                    <div class="dot2" onclick="currentSlide2(1)"></div>
                    <div class="dot2" onclick="currentSlide2(2)"></div>
                    <div class="dot2" onclick="currentSlide2(3)"></div>
                    <div class="dot2" onclick="currentSlide2(4)"></div>
                    <div class="dot2" onclick="currentSlide2(5)"></div>
                    <div class="dot2" onclick="currentSlide2(6)"></div>
                    <div class="dot2" onclick="currentSlide2(7)"></div>
                    <div class="dot2" onclick="currentSlide2(8)"></div>
                </div>
            </div>
            <div class="containerBtns"> <!-- Botões das várias categorias -->
                <div class="containers" id="item1"><a href="php/vitaminasMinerais.php" title="Página de vitaminas e minerais"><button type="button"><h3>Vitaminas e minerais</h3></button></a></div>
                <div class="containers" id="item2"><a href="php/emagrecimento.php" title="Página de Emagrecimento"><button type="button"><h3>Emagrecimento</h3></button></a></div>
                <div class="containers" id="item3"><a href="php/proteinas.php" title="Página de Proteínas"><button type="button"><h3>Proteínas</h3></button></a></div>   
                <div class="containers" id="item4"><a href="php/aminoacidos.php" title="Página de Aminoácidos"><button type="button"><h3>Aminoácidos</h3></button></a></div>
                <div class="containers" id="item5"><a href="php/preEposTreino.php" title="Página de Pré-treino e pós-treino"><button type="button"><h3>Pré-treino e pós-treino</h3></button></a></div>
                <div class="containers" id="item6"><a href="php/outrosSuplementos.php" title="Página de Outros suplementos"><button type="button"><h3>Outros suplementos</h3></button></a></div>
            </div>
    </main>

    <!-- Carregamento do footer com base na dimensão da tela -->
    <div id="footer"></div>
    <script type="text/javascript" src="js/index.js"></script>
</body>
</html>