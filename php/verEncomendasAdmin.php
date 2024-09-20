<?php
// Iniciar a sessão
session_start();

// Incluir o arquivo de conexão com o banco de dados
include 'conexaobd.php';

// Consulta SQL para obter todos os dados da tabela encomendas e a primeira imagem do produto associado
$sql = "
   SELECT
    e.*,
    ip.caminho AS imagem
FROM
    encomendas e
LEFT JOIN
    (
        SELECT
            ie.encomendaID,
            MIN(ie.produtoID) AS produtoID
        FROM
            itens_encomenda ie
        GROUP BY
            ie.encomendaID
    ) min_product ON e.encomendaID = min_product.encomendaID
LEFT JOIN
    produtos p ON min_product.produtoID = p.produtoID
LEFT JOIN
    (
        SELECT
            produtoID,
            MIN(caminho) AS caminho
        FROM
            imagens_produtos
        GROUP BY
            produtoID
    ) ip ON p.produtoID = ip.produtoID
ORDER BY
    e.encomendaID";

// Executar a consulta
$result = mysqli_query($conn, $sql);

// Verificar se há resultados
if (mysqli_num_rows($result) > 0) {
    $encomendas = array();
    
    // Armazenar os resultados em um array
    while ($row = mysqli_fetch_assoc($result)) {
        $encomendas[] = $row;
    }
} else {
    // Nenhuma encomenda encontrada
    $encomendas = array();
    // Opcional: você pode redirecionar ou exibir uma mensagem
    // echo "<script>alert('Nenhuma encomenda encontrada.'); window.location.href='areaAdministrador.php';</script>";
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Área de administrador: Visualizar encomendas</title>
    <meta name="description" content="Acesse a área de administração da Primesupps para visualizar e gerenciar todas as encomendas. Mantenha o controle total sobre o status das suas encomendas e histórico de pedidos.">
    <meta name="keywords" content="área de administração, visualizar encomendas, gerenciamento de pedidos, Primesupps">
   <!-- Inserir em todas as páginas -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/verEncomendasAdmin.js"></script>
    <link rel="stylesheet" href="../css/verEncomendasAdmin.css">
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
    </div>
    <div id="encomendasPadrao">
    <?php foreach ($encomendas as $encomenda) { ?>
    <div class='encomendas'>
        <div class='numeroEncomenda'>
            <h2>Encomenda <?php echo htmlspecialchars($encomenda['numeroEncomenda']); ?></h2>
        </div>
        <div class='dataEncomenda'>
            <?php echo htmlspecialchars($encomenda['data']); ?>
        </div>
        <div>
        <img class='imagemProduto' width='70em' src='<?php echo htmlspecialchars($encomenda['imagem']) ?>' alt='Imagem do produto'>
        </div>
        <div class='infoEncomendas'>
            <div class='dadosInfoEncomenda'>
                <?php echo number_format($encomenda['total'], 2, ',', '.'); ?> €
            </div>
            <div class='dadosInfoEncomenda'>
                <?php echo htmlspecialchars($encomenda['estado']); ?>
            </div>
            <div class='dadosInfoEncomenda'>
                <a href='detalhesEncomendaDesktopAdmin.php?numero=<?php echo urlencode($encomenda['encomendaID']); ?>' title='Detalhes da encomenda'>Ver detalhes</a>
            </div>
        </div>
    </div>
<?php } ?>
    </div>

    <div id="resultados" class="result"></div>

</main>
    
<?php include'footerMobile.php'; ?>

</body>
</html>