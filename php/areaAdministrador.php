<?php 

    session_start();

    if (!isset($_SESSION['utilizadorID'])) {
        echo "<script>
            alert('Precisa de iniciar sessão para aceder a esta página.');
            window.location.href='iniciarSessao.php';
        </script>";
        exit();
    }

    include'conexaobd.php';

// Consulta SQL para obter todos os dados da tabela encomendas e a primeira imagem do produto associado
$sql = "
  SELECT
    e.*,
    utilizadores.nome, 
    utilizadores.apelido,
    p.produtoID,
    ip.imagemID
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
            ip.produtoID, 
            MIN(ip.imagemID) AS imagemID
        FROM
            imagens_produtos ip
        GROUP BY
            ip.produtoID
    ) ip ON p.produtoID = ip.produtoID
LEFT JOIN
    utilizadores ON e.utilizadorID = utilizadores.utilizadorID
ORDER BY
    e.encomendaID;
";

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
    <title>PrimeSupps- Área de administrador</title>
    <meta name="description" content="Gerencie as configurações da loja.">
    <meta name="keywords" content="PrimeSupps, administração, área de administrador, código de acesso, gestão de usuário">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detecaoDispositivoAdmin.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/areaAdministrador.css">
     <script type="text/javascript" src="../js/areaAdministrador.js"></script>
</head>
<body>

<div id="header"></div>

<main>

<!-- Mobile -->
 <div class="mainMobile">
    
<a class="flexAdmin" href="verEncomendasAdmin.php" title="Ver encomendas">
                <div><p>Ver encomendas</p></div>
                <div><i class='fa-solid fa-chevron-right'></i></div>
            </a>

            <a class="flexAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos">
                <div><p>Gerir produtos</p></div>
                <div><i class='fa-solid fa-chevron-right'></i></div>
            </a>

            <a class="flexAdmin" href="gerirUtilizadoresAdmin.php" title="Gerir utilizadores">
                <div><p>Gerir utilizadores</p></div>
                <div><i class='fa-solid fa-chevron-right'></i></div>
            </a>

            <a class="flexAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais">
                <div><p>Gerir documentos legais</p></div>
                <div><i class='fa-solid fa-chevron-right'></i></div>
            </a>

            <a class="flexAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões">
                <div><p>Gerir cupões</p></div>
                <div><i class='fa-solid fa-chevron-right'></i></div>
            </a>
 </div>

<!-- Desktop -->
 <div class="mainDesktop">

 <h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
    <div class="background">

        <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
        <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
        <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
        <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
        <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

    </div>
<!-- Encomendas -->
<div class="divSearch">
    <h2 id="tituloSearch">Procurar encomenda</h2>
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
        <a class="linkBtnEncomenda" href='detalhesEncomendaDesktopAdmin.php?numero=<?php echo urlencode($encomenda['encomendaID']); ?>' title='Detalhes da encomenda'>
        <div class='numeroEncomenda'>
            <h2>Encomenda <?php echo htmlspecialchars($encomenda['numeroEncomenda']); ?></h2>
        </div>
        <div class='nomeCliente'>
            <p>Cliente : <?php echo htmlspecialchars($encomenda['nome']).' '.htmlspecialchars($encomenda['apelido']) ?></p>
        </div>
        <div class='dataEncomenda'>
            <p>Data da compra : <?php echo htmlspecialchars($encomenda['data']); ?></p>
        </div>
        <div class='infoEncomendas'>
            <div class='dadosInfoEncomenda'>
                <p>Total : <?php echo number_format($encomenda['total'], 2, ',', '.'); ?> €</p>
            </div>
            <div class='dadosInfoEncomenda'>
                <p>Estado : <?php echo htmlspecialchars($encomenda['estado']); ?></p>
            </div>
        </div>
        </a>
    </div>
<?php } ?>
    </div>

    <div id="result" class="result"></div>

 </div>

</main>

<div id="footer"></div>
    
</body>
</html>