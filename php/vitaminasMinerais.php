<?php

    session_start();

    include'conexaobd.php';

    $sql = "SELECT ip.caminho, p.preco, p.nome, p.produtoID, p.stock 
        FROM produtos p 
        JOIN imagens_produtos ip ON p.produtoID = ip.produtoID 
        WHERE TRIM(REPLACE(p.categoria, '\r\n', '')) = 'Vitaminas e minerais'
        AND ip.imagemID = (SELECT MIN(ip2.imagemID) 
                            FROM imagens_produtos ip2 
                            WHERE ip2.produtoID = p.produtoID)";

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
    <title>Primessups - Vitaminas e minerais</title>
    <meta name="description" content="Descubra uma ampla gama de vitaminas e minerais na Primessups. Encontre suplementos de alta qualidade para atender às suas necessidades nutricionais e de saúde.">
    <meta name="keywords" content="vitaminas, minerais, suplementos, Primessups, saúde, nutrição, suplementos nutricionais">
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
    <link rel="stylesheet" href="../css/estiloCategorias.css">
    <link rel="stylesheet" href="../css/vitaminasMinerais.css">
</head> 
<body>

<div id="header"></div>

<main>

    <div class="backgroundCategorias"><h1>Vitaminas e minerais</h1></div>
    <div class="produtosContainer">
        <?php foreach ($produtos as $produto) { ?>
            <a href="paginaProdutos.php?id=<?php echo htmlspecialchars($produto['produtoID'])?>">
                <?php if($produto['stock']!== '0'){ ?>
                <div class="gallery">
                    <img src="<?php echo htmlspecialchars($produto['caminho']) ?>" alt="<?php echo htmlspecialchars($produto['nome'])?>">
                    <div class="desc"><?php echo htmlspecialchars($produto['nome'])?></div>
                    <div class="preco"><?php echo htmlspecialchars(number_format($produto['preco'], 2,',','.')) ?>€</div>
                </div>
                <?php } else{ ?>
                <?php } ?>
            </a>
        <?php } ?>

    </div>

</main>

<div id="footer"></div>
    
</body>
</html>