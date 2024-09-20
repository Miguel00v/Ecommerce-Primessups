<?php
session_start();

//Link para rederecionar para página anterior se definida, senão vai para página inicial
$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Detalhes da encomenda</title>
    <meta name="description" content="Detalhes da encomenda na Primesupps. Veja informações sobre os produtos comprados, dados fiscais e muito mais.">
    <meta name="keywords" content="Primesupps, detalhes da encomenda, informações sobre produtos, dados fiscais, cupões, entrega, e-commerce, suplementos">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detecaoDispositivo.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/detalhesEncomenda.css">
</head>
<body>
    
<div id="header"></div>

<main>
    <div class="background">

    <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
    <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
    <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
    <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
    <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

    </div>
<div id="posicaoDesktop">
<?php

// Verificar se o número da encomenda foi enviado
if (isset($_GET['numero']) && !empty($_GET['numero'])) {
    include 'conexaobd.php';

    $numeroEncomenda = mysqli_real_escape_string($conn, $_GET['numero']);

    // Selecionar todas as informações dos produtos da encomenda junto com a quantidade de cada produto, a primeira imagem, se foi usado algum cupão, e os dados fiscais do utilizador
    $sqlDetalhesEncomenda = " 
        SELECT 
            e.numeroEncomenda,
            p.produtoID, 
            p.nome AS nome_produto, 
            p.descricao, 
            p.preco, 
            ie.quantidade, 
            ip.caminho AS imagem, 
            c.codigo AS codigo_cupao, 
            c.valor AS desconto_cupao,  
            c.tipoValor AS tipo_desconto,  
            df.nome AS nome_fiscal, 
            df.apelido AS apelido_fiscal, 
            df.NIF AS nif_fiscal, 
            df.pais AS pais_fiscal, 
            df.cidade AS cidade_fiscal, 
            df.endereco AS morada_fiscal, 
            df.codigoPostal AS codigoPostal_fiscal, 
            en.endereco AS endereco_entrega, 
            en.pais AS pais_entrega, 
            en.codigoPostal AS codigoPostal_entrega, 
            en.cidade AS cidade_entrega
        FROM 
            encomendas e
        JOIN 
            itens_encomenda ie ON e.encomendaID = ie.encomendaID
        JOIN 
            produtos p ON ie.produtoID = p.produtoID
        LEFT JOIN 
            (SELECT produtoID, caminho 
             FROM imagens_produtos 
             WHERE imagemID IN (SELECT MIN(imagemID) FROM imagens_produtos GROUP BY produtoID)) ip 
             ON p.produtoID = ip.produtoID
        LEFT JOIN 
            cupoes c ON e.cupaoID = c.cupaoID
        LEFT JOIN 
            dados_fiscais df ON e.dadosFiscaisID = df.dadosFiscaisID
        LEFT JOIN 
            enderecos en ON e.utilizadorID = en.utilizadorID
        WHERE 
            e.encomendaID = ?";

    $stmtDetalhesEncomenda = mysqli_prepare($conn, $sqlDetalhesEncomenda);
    mysqli_stmt_bind_param($stmtDetalhesEncomenda, "s", $numeroEncomenda);
    mysqli_stmt_execute($stmtDetalhesEncomenda);
    $resultadoDetalhesEncomenda = mysqli_stmt_get_result($stmtDetalhesEncomenda);

    if ($resultadoDetalhesEncomenda->num_rows > 0) {
        $quantidadeTotal = 0; // Variável para armazenar a quantidade total de todos os produtos
        $subtotal = 0; // Variável para armazenar o valor total da encomenda
        $cupao = ''; // Variável para armazenar o código do cupão, se existir
        $descontoCupao = 0; // Variável para armazenar o valor do desconto do cupão
        $tipoDesconto = ''; // Variável para armazenar o tipo de desconto
        $paisEntrega = ''; // Variável para armazenar o país de entrega

        // Variáveis para armazenar os dados fiscais
        $nomeFiscal = '';
        $apelidoFiscal = '';
        $moradaFiscal = '';
        $nifFiscal = '';
        $paisFiscal = '';
        $cidadeFiscal = '';
        $codigoPostalFiscal = '';

        $detalheEncomenda = mysqli_fetch_assoc($resultadoDetalhesEncomenda);

        // Exibir o título da encomenda fora do loop
        echo "<h1 id='tituloEncomenda'>Número da Encomenda: " . htmlspecialchars($detalheEncomenda['numeroEncomenda']) . "</h1>";

        // Reposicionar o ponteiro no resultado para o início, se precisar usar o loop depois
        mysqli_data_seek($resultadoDetalhesEncomenda, 0);

        // Primeiro, percorra os resultados para calcular os totais e obter o código do cupão e dados fiscais
        while ($detalhe = mysqli_fetch_assoc($resultadoDetalhesEncomenda)) {
            $quantidade = isset($detalhe['quantidade']) ? (int)htmlspecialchars($detalhe['quantidade']) : 0;
            $precoProduto = isset($detalhe['preco']) ? (float)htmlspecialchars($detalhe['preco']) : 0.0;
            
            $quantidadeTotal += $quantidade;
            $subtotal += $precoProduto * $quantidade;

            // Obter o código do cupão, tipo e o país de entrega
            $cupao = isset($detalhe['codigo_cupao']) ? htmlspecialchars($detalhe['codigo_cupao']) : '';
            $descontoCupao = isset($detalhe['desconto_cupao']) ? (float)htmlspecialchars($detalhe['desconto_cupao']) : 0.0;
            $tipoDesconto = isset($detalhe['tipo_desconto']) ? htmlspecialchars($detalhe['tipo_desconto']) : 'fixo';
            $paisEntrega = isset($detalhe['pais_entrega']) ? htmlspecialchars($detalhe['pais_entrega']) : '';

            // Armazenar os dados fiscais se disponíveis
            if (isset($detalhe['nome_fiscal'])) {
                $nomeFiscal = htmlspecialchars($detalhe['nome_fiscal']);
                $apelidoFiscal = htmlspecialchars($detalhe['apelido_fiscal']);
                $moradaFiscal = htmlspecialchars($detalhe['morada_fiscal']);
                $nifFiscal = htmlspecialchars($detalhe['nif_fiscal']);
                $paisFiscal = htmlspecialchars($detalhe['pais_fiscal']);
                $cidadeFiscal = htmlspecialchars($detalhe['cidade_fiscal']);
                $codigoPostalFiscal = htmlspecialchars($detalhe['codigoPostal_fiscal']);
            }
        }

        // Exiba o total de produtos uma vez, antes de iniciar o loop novamente
        echo $quantidadeTotal == 1 ? "<p>1 produto</p>" : "<p>$quantidadeTotal produtos</p>";

        // Reposicione o ponteiro de resultado para o início
        mysqli_data_seek($resultadoDetalhesEncomenda, 0);

        // Agora percorra novamente para exibir os detalhes dos produtos
        while ($detalhe = mysqli_fetch_assoc($resultadoDetalhesEncomenda)) {
            // Dados dos produtos da encomenda
            $nomeProduto = isset($detalhe['nome_produto']) ? htmlspecialchars($detalhe['nome_produto']) : '';
            $precoProduto = isset($detalhe['preco']) ? htmlspecialchars($detalhe['preco']) : 0.0;
            $quantidade = isset($detalhe['quantidade']) ? htmlspecialchars($detalhe['quantidade']) : 0;
            $imagemProduto = isset($detalhe['imagem']) ? htmlspecialchars($detalhe['imagem']) : '';

            echo "
                <div class='divProdutos'>
                    <div><img class='imagemProduto' src='$imagemProduto' alt='Imagem do produto'></div>
                    <p class='nomeProduto'>$nomeProduto</p>
                    <p class='quantidadeProduto'>Quantidade : $quantidade</p>
                    <p class='precoProduto'>" . number_format($precoProduto, 2, ',', '.') . "€</p>
                </div>
            ";
        }

        // Verificar se utilizou cupões
        echo "
            <div class='backgroundCupoes'>
                <div class='tituloCupoes'>
                    <i class='fa-solid fa-clipboard-check'></i>
                    <h2>Cupões</h2>
                </div>
                <p class='textoCupao'>" . (!empty($cupao) ? "Cupão utilizado: $cupao" : "Nenhum cupão utilizado.") . "</p>
            </div>
        ";

        // Dados fiscais de faturação
        if (!empty($nomeFiscal)) {
            echo "
                <div class='backgroundFaturacao'>
                    <div class='tituloFaturacao'>
                        <i class='fa-solid fa-house'></i>
                        <h2>Dados de faturação</h2>
                    </div>
                    <div>
                        <p>$nomeFiscal $apelidoFiscal</p>
                        <p>Endereço: $moradaFiscal</p>
                        <p>Código postal: $codigoPostalFiscal</p>
                        <p>Cidade: $cidadeFiscal</p>
                        <p>País: $paisFiscal</p>
                        <p>NIF: $nifFiscal</p>
                    </div>
                </div>
            ";
        }

        // Verificar país de entrega
        $custoEnvio = ($paisEntrega !== 'Portugal') ? 2.99 : 0.00;

        // Calcular o desconto baseado no tipo (percentual ou fixo)
        if (strtolower($tipoDesconto) == 'percentual') {
            $valorDesconto = $subtotal * $descontoCupao;
        } else {
            $valorDesconto = $descontoCupao;
        }

        // Cálculo do total da compra
        $totalCompra = $subtotal - $valorDesconto + $custoEnvio;

        // Resumo da compra
        echo "
            <div class='backgroundResumo'>
                <div><h2>Resumo</h2></div>
                <div class='resumoFlexbox'>
                    <div><p>Subtotal</p></div>
                    <div><p>" . number_format($subtotal, 2, ',', '.') . "€</p></div>
                </div>
                <div class='resumoFlexbox'>
                    <div><p>Envio</p></div>
                    <div><p>" . number_format($custoEnvio, 2, ',', '.') . "€</p></div>
                </div>
                <div class='resumoFlexbox'>
                    <div><p>Descontos</p></div>
                    <div><p>" . number_format($valorDesconto, 2, ',', '.') . "€</p></div>
                </div>
                <hr>
                <div class='resumoFlexbox'>
                    <div><p>Total</p></div>
                    <div><p>" . number_format($totalCompra, 2, ',', '.') . "€</p></div>
                </div>
            </div>
        ";

    } else {
        echo "<script>
                alert('Não foi possível encontrar detalhes para esta encomenda!');
                window.location.href='areaAdministrador.php';
              </script>";
    }

    mysqli_stmt_close($stmtDetalhesEncomenda);
    mysqli_close($conn);

} else {
    echo "<script>
            alert('Não foi possível carregar a sua encomenda!');
            window.location.href='areaAdministrador.php';
          </script>";
}
?>
</div>

</main>

<div id="footer"></div>

</body>
</html>