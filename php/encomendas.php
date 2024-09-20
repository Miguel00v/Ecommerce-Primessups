<?php

session_start();
include 'conexaobd.php';

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Minhas Encomendas</title>
    <meta name="description" content="Visualize suas encomendas na Primesupps.">
    <meta name="keywords" content="encomendas, histórico de compras, Primesupps, acompanhar pedidos">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/encomendas.js"></script>
    <link rel="stylesheet" href="../css/encomendas.css">
</head>
<body>

    <?php include'headerMobile.php'; ?>

    <main>
       
            <div><h2>Procurar encomenda</h2></div>
            <div>
                <form id="searchForm">
                        <div id="flexInputs">
                            <input class="inputs" type="text" id="numeroEncomenda" name="encomenda" placeholder="Encomenda nº" aria-label="Encomenda nº" oninput="filtrarEncomendas()">
                            <input class="inputs" type="date" id="dataEncomenda" name="data" placeholder="Data" aria-label="Data" oninput="filtrarEncomendas()">
                        </div>
                        <div id="flexBtnsPesquisa">
                            <button class="btnsPesquisa" type="submit" id="filtrar" disabled><p>Filtrar</p></button>
                            <button class="btnsPesquisa" type="button" id="limpar"><p>Limpar</p></button>
                        </div>
                </form>

                <!-- Div para exibir as encomendas do utilizador da mais recente para a mais antiga -->
                <div id="encomendasPadrao">
                <?php
                if (isset($_SESSION['utilizadorID'])) {
                    $utilizadorID = $_SESSION['utilizadorID'];
                
                    $sql = "
                        SELECT e.encomendaID, e.numeroEncomenda, e.data, e.estado, e.total, 
                               MIN(ip.caminho) AS imagem
                        FROM encomendas e
                        JOIN itens_encomenda ie ON e.encomendaID = ie.encomendaID
                        JOIN produtos p ON ie.produtoID = p.produtoID
                        JOIN imagens_produtos ip ON p.produtoID = ip.produtoID
                        WHERE e.utilizadorID = ?
                        GROUP BY e.numeroEncomenda, e.data, e.estado, e.total
                        ORDER BY e.data DESC
                    ";
                
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "i", $utilizadorID);
                        mysqli_stmt_execute($stmt);
                        $resultadoEncomendas = mysqli_stmt_get_result($stmt);
                
                        if ($resultadoEncomendas->num_rows > 0) {
                            while ($encomenda = mysqli_fetch_assoc($resultadoEncomendas)) {
                                $encomendaID = htmlspecialchars($encomenda['encomendaID']);
                                $numeroEncomenda = htmlspecialchars($encomenda['numeroEncomenda']);
                                $dataEncomenda = htmlspecialchars($encomenda['data']);
                                $estadoEncomenda = htmlspecialchars($encomenda['estado']);
                                $imagemProduto = htmlspecialchars($encomenda['imagem']);
                                $totalEncomenda = htmlspecialchars($encomenda['total']);
                
                                echo "
                                    <div class='encomendas'>
                                        <div class='numeroEncomenda'><h2>Encomenda $numeroEncomenda</h2></div>
                                        <div class='dataEncomenda'><p>$dataEncomenda</p></div>
                                        <div><img class='imagemProduto' width='70em' src='$imagemProduto' alt='Imagem do produto'></div>
                                        <div class='infoEncomendas'>
                                            <div class='dadosInfoEncomenda'><p>".number_format($totalEncomenda, 2, ',', '.')." €</p></div>
                                            <div class='dadosInfoEncomenda'><p>$estadoEncomenda</p></div>
                                            <div class='dadosInfoEncomenda'><a id='linkDetalhesEncomenda' href='detalhesEncomenda.php?numero=$encomendaID' title='Detalhes da encomenda'><p>Ver detalhes</p></a></div>
                                        </div>
                                    </div>
                                ";
                            }
                        } else {
                            echo "
                                <div id='semEncomendas'>
                                    <h3>Não têm registo de qualquer encomenda feita.</h3>
                                    <a id='linkComprarAgora' href='produtosDestaque.php' title='Produtos em destaque'><button id='btnComprarAgora' type='button'><p>Comprar agora</p></button></a>
                                </div>
                            ";
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<p>Erro ao preparar a consulta SQL.</p>";
                    }
                } else {
                    echo "<div id='semLogin'>
                            <p>Você não está logado. <a href='iniciarSessao.php'>Faça login</a> para ver suas encomendas.</p>
                        </div>";
                }
                mysqli_close($conn);
                ?>
                </div>

                <!-- Div para exibir resultados da pesquisa de filtragem -->
                <div id="resultados" class="results"></div>

            </div>

        </div>

    </main>
    
    <?php include'footerMobile.php'; ?>

</body>
</html>