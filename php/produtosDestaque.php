<?php

    session_start();

    include'conexaobd.php';

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
    <title>Primessups - Produtos em destaque</title>
    <meta name="description" content="Explore os produtos em destaque da Primessups. Encontre suplementos de alta qualidade, vitaminas, proteínas e muito mais para atender suas necessidades nutricionais.">
    <meta name="keywords" content="suplementos, vitaminas, proteínas, suplementos nutricionais, Primessups, produtos em destaque">
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
    <link rel="stylesheet" href="../css/produtosDestaque.css">
</head> 
<body>

<div id="header"></div>

<main>

    <div class="background"><h1>Produtos em destaque</h1></div>
                <div class="produtosContainer">
                <?php foreach ($produtos as $produto) { ?>
                <a href="paginaProdutos.php?id=<?php echo htmlspecialchars($produto['produtoID'])?>">
                    <div class="gallery">
                        <img src="<?php echo htmlspecialchars($produto['caminho']) ?>" alt="<?php echo htmlspecialchars($produto['nome'])?>" width="600" height="400">
                        <div class="desc"><?php echo htmlspecialchars($produto['nome'])?></div>
                        <div class="preco"><?php echo htmlspecialchars(number_format($produto['preco'], 2,',','.')) ?>€</div>
                    </div>
                </a>
                <?php } ?>
                </div>
</main>

<div id="footer"></div>
    
</body>
</html>