<?php 

    session_start();
    if (!isset($_SESSION['utilizadorID'])) {
        echo "<script> 
            alert('Não tem sessão iniciada.'); 
            window.location.href='iniciarSessao.php';
          </script>";
        exit();
    }

    include 'conexaobd.php';

    $sql = "SELECT p.produtoID, p.nome, p.categoria, p.preco, p.destaque, p.stock, 
               (SELECT i_p.caminho 
                FROM imagens_produtos i_p 
                WHERE i_p.produtoID = p.produtoID 
                LIMIT 1) AS caminho 
        FROM produtos p";
    $stmt =mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($stmt);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $produtos = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $produtos[] = $row;
        }
    
        mysqli_stmt_close($stmt);
    } else {
        
        echo "<script>alert('Erro ao carregar página!');</script> ";
    }    

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Área de administrador: Gerir produtos</title>
    <meta name="description" content="Administre e gerencie eficientemente os produtos da PrimeSupps. Adicione, edite e remova produtos facilmente com nossa interface intuitiva.">
    <meta name="keywords" content="PrimeSupps, administração de produtos, gerir produtos, painel administrativo, adicionar produtos, editar produtos, remover produtos">
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
    <script type="text/javascript" src="../js/gerirProdutosAdmin.js"></script>
    <link rel="stylesheet" href="../css/gerirProdutosAdmin.css">
</head>
<body>

<div id="header"></div>

    <main>

        <h1 id="titulo1">Gerir produtos</h1>

        <h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
        <div id="background1" class="background1">

            <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
            <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
            <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
            <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
            <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

        </div>

        <h3 id="tituloForm">Procurar produto</h3>
            <form id="searchForm">
                <div class="flex1">
                    <input class="inputs" id="nome" type="nome" value="" placeholder="Nome" aria-label="Nome" oninput="filtrarEncomendas()">
                    <select class="inputs" name="categoria" id="categoria" onchange="filtrarEncomendas()">
                        <option disabled selected style="display: none;">Categoria</option>
                        <option>Proteínas</option>
                        <option>Vitaminas e minerais</option>
                        <option>Aminoácidos</option>
                        <option>Pré-treino e pós-treino</option>
                        <option>Emagrecimento</option>
                        <option>Outros</option>
                    </select>
                    <select class="inputs" id="destaque" name="destaque" onchange="filtrarEncomendas()">
                        <option disabled selected style="display: none;">Destaque</option>
                        <option>Sim</option>
                        <option>Não</option>
                    </select>
                </div>
                <div class="flex1">
                    <button class="btns" id="filtrar" type="submit" disabled><p>Filtrar</p></button>
                    <button class="btns" id="limpar" type="button"><p>Limpar</p></button>
                </div>

            </form>

        <a class="linkAdicionarProduto" href="adicionarProdutoAdmin.php" title="Adicionar um novo produto"><button class="btnAdicionarProduto" type="button"><p>Adicionar novo produto</p></button></a>

            <div id="produtosPadrao">
                <?php foreach ($produtos as $produto){ ?>

                    <div class="background" style="background-image: url('<?php echo htmlspecialchars($produto['caminho']); ?>');">
                        <div id="editarProduto"><a class="linkEditarProduto" href="editarProdutoAdmin.php?produtoID=<?php echo htmlspecialchars($produto['produtoID']); ?>" title="Editar produto"><button class="btnEditarProduto" type="button"><i class="fa-solid fa-pen"></i></button></a></div>

                <!-- Verificar se está em destaque -->
                        <?php if($produto['destaque']== '1'){ ?>
                            <div id="destaqueProduto">
                                <img id="simboloDestaque" src="../imagens/icons/destaque.svg" alt="Icon de destaque">
                            </div>
                        <?php } ?>
                            <div id="preco">
                                <p>Preço : <?php echo number_format($produto['preco'], 2, ',', '.'); ?> €</p>
                            </div>
                            <div id="stock">
                                <p>Stock : <?php echo htmlspecialchars($produto['stock']); ?> un</p>
                            </div>
                            <div id="nomeProduto">
                                <p><?php echo htmlspecialchars($produto['nome']); ?></p>
                            </div>
                            <div id="categoriaProduto">
                                <p>Categoria : <?php echo htmlspecialchars($produto['categoria']); ?></p>
                            </div>
                            <div class="removerProduto"><a class="linkRemoverProduto" href="removerProdutoAdmin.php?produtoID=<?php echo htmlspecialchars($produto['produtoID']); ?>" title="Remover produto"><button class="btnRemoverProduto" type="button"><i class="fa-solid fa-trash-can"></i></button></a></div>

                    </div>

                    <?php } mysqli_close($conn); ?>

            </div>

            <div id="resultados"></div>

    </main>

    <div id="footer"></div>
    
</body>
</html>