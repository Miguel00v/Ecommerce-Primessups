<?php
session_start();

if (isset($_GET['produtoID'])) {
    include 'conexaobd.php';

    if (mysqli_connect_errno()) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    $produtoID = $_GET['produtoID'];

    $sql = "SELECT p.nome, p.categoria, p.stock, p.preco, p.destaque, p.descricao, i_p.caminho, i_p.imagemID 
            FROM produtos p 
            JOIN imagens_produtos i_p ON p.produtoID = i_p.produtoID 
            WHERE p.produtoID = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $produtoID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Initialize variables
    $nome = $categoria = $stock = $preco = $destaque = $descricao = '';
    $caminhos = [];

    // Fetch rows for product details and images
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($nome)) {
            $nome = $row['nome'];
            $categoria = $row['categoria'];
            $stock = $row['stock'];
            $preco = $row['preco'];
            $destaque = $row['destaque'];
            $descricao = $row['descricao'];
        }
        $caminhos[] = ['caminho' => $row['caminho'], 'imagemID' => $row['imagemID']];
    }

    mysqli_close($conn);
} else {
    echo "<script>
            alert('Erro ao carregar página.'); 
            window.location.href='gerirProdutosAdmin.php';
          </script>";
    exit;
}

// Processar a atualização dos dados do produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizarProduto'])) {
    include 'conexaobd.php';

    if (mysqli_connect_errno()) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    function formatarNome($nome) {
        return ucwords(strtolower(trim($nome)));
    }

    $nomeNovo = formatarNome(mysqli_real_escape_string($conn,$_POST['nomeProduto']));
    $categoriaNova = $_POST['categoriaProduto'];
    $stockNovo = $_POST['stock'];
    $precoNovo = mysqli_real_escape_string($conn,$_POST['preco']);
    $descricaoNova = mysqli_real_escape_string($conn,$_POST['descricao']);
    $destaqueNovo = (int) $_POST['destaque'];

    if (!is_numeric($stockNovo) || $stockNovo < 0 || $stockNovo > 1000) {
        echo "<script>alert('O valor do stock deve ser um número entre 0 e 1000.');
            window.location.href=window.location.href;
        </script>";
        exit();
    }

    // Converta vírgula para ponto no preço
    $precoNovo = str_replace(',', '.', $precoNovo);

    // Validação do preço
    if (!is_numeric($precoNovo)) {
        echo "<script>alert('O preço deve ser um número válido.');
            window.location.href=window.location.href;
        </script>";
        exit();
    }

    // Initialize update SQL and parameters
    $updates = [];
    $params = [];
    $paramTypes = '';

    if ($nomeNovo != $nome) {
        $updates[] = 'nome = ?';
        $params[] = $nomeNovo;
        $paramTypes .= 's';
    }
    if ($categoriaNova != $categoria) {
        $updates[] = 'categoria = ?';
        $params[] = $categoriaNova;
        $paramTypes .= 's';
    }
    if ($stockNovo != $stock) {
        $updates[] = 'stock = ?';
        $params[] = $stockNovo;
        $paramTypes .= 'i';
    }
    if ($precoNovo != $preco) {
        $updates[] = 'preco = ?';
        $params[] = $precoNovo;
        $paramTypes .= 'd';
    }
    if ($descricaoNova != $descricao) {
        $updates[] = 'descricao = ?';
        $params[] = $descricaoNova;
        $paramTypes .= 's';
    }
    if($destaqueNovo != $destaque){
        $updates[] = 'destaque = ?';
        $params[] = $destaqueNovo;
        $paramTypes .= 'i';
    }

    if (!empty($updates)) {
        $paramTypes .= 'i'; // For produtoID at the end
        $params[] = $produtoID;
        $sql = 'UPDATE produtos SET ' . implode(', ', $updates) . ' WHERE produtoID = ?';
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Alterações guardadas com sucesso.');
                window.location.href='gerirProdutosAdmin.php';
            </script>";
        } else {
            echo "<script>alert('Erro ao guardar as alterações.');
                 window.location.href='gerirProdutosAdmin.php';
            </script>";
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

// Processar o upload das imagens
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionarImagens'])) {
    include 'conexaobd.php';

    if (mysqli_connect_errno()) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    $imagemDir = '../uploads/imagens'; // Certifique-se de que o diretório termina com '/'
    foreach ($_FILES['imagens']['tmp_name'] as $key => $tmpName) {
        
        if (!empty($tmpName)) { // Verifique se há uma imagem para processar
            $imagemNome = basename($_FILES['imagens']['name'][$key]);
            $imagemCaminho = $imagemDir . $imagemNome;

            // Mover o arquivo para o diretório de upload
            if (move_uploaded_file($tmpName, $imagemCaminho)) {
                // Inserir caminho da imagem na base de dados
                $sqlImagem = 'INSERT INTO imagens_produtos (produtoID, caminho) VALUES (?, ?)';
                $stmtImagem = mysqli_prepare($conn, $sqlImagem);
                mysqli_stmt_bind_param($stmtImagem, 'is', $produtoID, $imagemCaminho);
                if (!mysqli_stmt_execute($stmtImagem)) {
                    echo "<script>alert('Erro ao guardar a imagem na base de dados.');</script>";
                }
                mysqli_stmt_close($stmtImagem);
            } else {
                echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
            }
        }
    }
    mysqli_close($conn);
    echo "<script>alert('Imagens adicionadas com sucesso.');
        window.location.href='gerirProdutosAdmin.php';
    </script>";
}

$categorias = [
    "Proteínas",
    "Vitaminas e minerais",
    "Aminoácidos",
    "Pré-treino e pós-treino",
    "Emagrecimento",
    "Outros"
];

$destaques = [
    '1' => 'Sim',
    '0' => 'Não'
];

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Área de administrador: Editar produto</title>
    <meta name="description" content="Administre e edite os produtos da PrimeSupps com facilidade e eficiência na área de administrador. Atualize informações, preços e estoque para manter seu catálogo sempre atualizado.">
    <meta name="keywords" content="administração de produtos, editar produtos, gerenciamento de estoque, PrimeSupps">
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
    <script type="text/javascript" src="../js/editarProdutoAdmin.js"></script>
    <link rel="stylesheet" href="../css/editarProdutoAdmin.css">
</head>
<body>

<div id="header"></div>

<main>
    <div id="background1" class="background1">

    <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
    <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
    <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
    <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
    <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

    </div>

    <h1 id="titulo1">Editar : <?php echo htmlspecialchars($nome); ?></h1>

    <div id="posicaoDesktop">
    <form method="post">
    <input class="inputs" type="text" placeholder="<?php echo htmlspecialchars($nome); ?>" 
           value="<?php echo htmlspecialchars($nome); ?>" name="nomeProduto">
    <select class="inputs" name="categoriaProduto">
        <option value="<?php echo htmlspecialchars($categoria); ?>"><?php echo htmlspecialchars($categoria); ?></option>
        <?php
        foreach ($categorias as $cat) {
            if ($cat === $categoria) continue;
            echo '<option value="' . htmlspecialchars($cat) . '">' . htmlspecialchars($cat) . '</option>';
        }
        ?>
    </select>
    <div class="flex1">
        <div class="stockInput">
            <label for="stock">Stock :</label>
            <input class="inputs" type="text" id="stock" name="stock" value="<?php echo htmlspecialchars($stock); ?>" placeholder="Stock">
        </div>
        <div class="input-group">
            <input class="inputs" type="text" name="preco" value="<?php echo number_format(htmlspecialchars($preco),2,',','.'); ?>" placeholder="Preço">
            <span class="currency-symbol">€</span>
        </div>
    </div>
    <select class="inputs" name="destaque">
        <option value="<?php echo htmlspecialchars($destaque); ?>"><?php echo ($destaque == '1') ? 'Sim' : 'Não'; ?></option>
        <?php
        foreach ($destaques as $value => $label) {
            if ($value == $destaque) continue;
            echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
        }
        ?>
    </select>
    <textarea class="inputs" id="descricao" name="descricao" placeholder="Descrição"><?php echo htmlspecialchars($descricao); ?></textarea>
    <button id="btnGuardar" type="submit" name="atualizarProduto"><p>Guardar alterações</p></button>
</form>

<!-- Formulário para adicionar imagens -->
<form method="post" enctype="multipart/form-data" action="../php/inserirImagensProdutosAdmin.php?produtoID=<?php echo $produtoID ?>">
    <div class="alinharImagens">
        <?php foreach ($caminhos as $img) { ?>
            <div class="editarImagem" id="imagem-<?php echo $img['imagemID']; ?>">
                <img class="imagensProdutos" src="<?php echo htmlspecialchars($img['caminho']); ?>" alt="Imagem do produto">
                <button class="btnRemoverImagem" type="button" onclick="removerImagem('<?php echo htmlspecialchars($img['imagemID']); ?>')"><p>Remover</p></button>
            </div>
        <?php } ?>
    </div>
    <input class="anexarImagens" type="file" name="imagens[]" accept="image/*" multiple onchange="validateImages(this)">
    <p class="p" id="limiteImagem">Limite máximo: 7MB</p>
    <p id="fileInfo"></p>
    <button id="btnAdicionarImagens" type="submit" name="adicionarImagens"><p>Adicionar imagens</p></button>
</form>
    </div>

</main>

<div id="footer"></div>

</body>
</html>