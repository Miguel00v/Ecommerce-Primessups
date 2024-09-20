<?php 

session_start();

include 'conexaobd.php';

// Inicializar variáveis
$nomeProduto = isset($_GET['nome']) ? $_GET['nome'] : '';
$categoriaProduto = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$destaqueProduto = null;

if (isset($_GET['destaque'])) {
    if ($_GET['destaque'] === 'Sim') {
        $destaqueProduto = 1;
    } elseif ($_GET['destaque'] === 'Não') {
        $destaqueProduto = 0;
    }
}

// Construir a consulta SQL
$sql = "SELECT p.produtoID, p.nome, p.categoria, p.preco, p.destaque, p.stock, MAX(i_p.caminho) AS caminho
        FROM produtos p
        LEFT JOIN imagens_produtos i_p ON p.produtoID = i_p.produtoID
        WHERE 1=1";

// Adicionar condições dinamicamente
$params = [];
$types = '';

if ($nomeProduto) {
    $sql .= " AND p.nome LIKE ?";
    $params[] = "%" . $nomeProduto . "%";
    $types .= 's';
}

if ($categoriaProduto) {
    $sql .= " AND p.categoria = ?";
    $params[] = $categoriaProduto;
    $types .= 's';
}

if ($destaqueProduto !== null) {
    $sql .= " AND p.destaque = ?";
    $params[] = $destaqueProduto;
    $types .= 'i';
}

// Adicionar agrupamento
$sql .= " GROUP BY p.produtoID, p.nome, p.categoria, p.preco, p.destaque, p.stock";

// Preparar e executar a consulta
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    if ($types) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $produtos = [];
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $produtos[] = $linha;
        }
    } else {
        echo "<div><p>Nenhum produto encontrado.</p></div>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<div><p>Erro na preparação da consulta.</p></div>";
}

mysqli_close($conn);

// Exibir produtos
foreach ($produtos as $produto) {
    echo "
    <div class='background' style=\"background-image: url('".htmlspecialchars($produto['caminho'])."');\">
        <div id='editarProduto'>
            <a class='linkEditarProduto' href='editarProdutoAdmin.php?produtoID=".htmlspecialchars($produto['produtoID'])."' title='Editar produto'>
                <button class='btnEditarProduto' type='button'><i class='fa-solid fa-pen'></i></button>
            </a>
        </div>";
    
    if ($produto['destaque'] == '1') {
        echo "<div id='destaqueProduto'>
                <img id='simboloDestaque' src='../imagens/icons/destaque.svg' alt='Icon de destaque'>
              </div>";
    }

    echo "<div id='preco'>
            <p>Preço: ".number_format($produto['preco'], 2, ',', '.')." €</p>
          </div>
          <div id='stock'>
            <p>Stock: ".htmlspecialchars($produto['stock'])." un</p>
          </div>
          <div id='nomeProduto'>
            <p>".htmlspecialchars($produto['nome'])."</p>
          </div>
          <div id='categoriaProduto'>
            <p>Categoria: ".htmlspecialchars($produto['categoria'])."</p>
          </div>
          <div class='removerProduto'>
            <a class='linkRemoverProduto' href='removerProdutoAdmin.php?produtoID=".htmlspecialchars($produto['produtoID'])."' title='Remover produto'>
                <button class='btnRemoverProduto' type='button'><i class='fa-solid fa-trash-can'></i></button>
            </a>
          </div>
    </div>";
}

?>