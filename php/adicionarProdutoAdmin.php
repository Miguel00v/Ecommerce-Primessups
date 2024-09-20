<?php 

    session_start();

    if($_SERVER['REQUEST_METHOD']=='POST'){

        include'conexaobd.php';

        function formatarNome($nome) {
            return ucwords(strtolower(trim($nome)));
        }
    

        $nomeProduto = formatarNome(mysqli_real_escape_string($conn, $_POST['nome']));
        $categoriaProduto = mysqli_real_escape_string($conn,$_POST['categoria']);
        $stock = mysqli_real_escape_string($conn,$_POST['stock']);
        $preco = mysqli_real_escape_string($conn,$_POST['preco']);
        $descricao = mysqli_real_escape_string($conn,$_POST['descricao']);
        $imagens = $_FILES['imagem'];

         // Validação do stock
        if (!is_numeric($stock) || $stock < 0 || $stock > 1000) {
            echo "<script>alert('O valor do stock deve ser um número entre 0 e 1000.');
                window.location.href=window.location.href;
            </script>";
            exit();
        }
        // Converta vírgula para ponto no preço
            $preco = str_replace(',', '.', $preco);

            // Validação do preço
            if (!is_numeric($preco)) {
                echo "<script>alert('O preço deve ser um número válido.');
                    window.location.href=window.location.href;
                </script>";
                exit();
            }


        if ($nomeProduto && $categoriaProduto && $stock && $preco && $descricao && $imagens) {
        
            // Inserir os detalhes do produto na tabela produtos
            $sql = "INSERT INTO produtos (nome, categoria, stock, preco, descricao) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssids", $nomeProduto, $categoriaProduto, $stock, $preco, $descricao);
            mysqli_stmt_execute($stmt);
            $produtoID = mysqli_insert_id($conn); // Obtém o ID do produto inserido
    
            // Diretório de upload
            $uploadDir = '../uploads/imagens';
    
            // Iterar sobre cada imagem
            for ($i = 0; $i < count($imagens['name']); $i++) {
                $imageName = basename($imagens['name'][$i]);
                $imagePath = $uploadDir . $imageName;
                $imageTmpName = $imagens['tmp_name'][$i];
    
                // Mover o arquivo para o diretório de uploads
                if (move_uploaded_file($imageTmpName, $imagePath)) {
                    // Inserir o caminho da imagem na tabela imagens_produtos
                    $sql = "INSERT INTO imagens_produtos (produtoID, caminho) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "is", $produtoID, $imagePath);
                    mysqli_stmt_execute($stmt);
                } else {
                    echo "Erro ao fazer upload da imagem: " . htmlspecialchars($imageName);
                }
            }
    
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
    
            echo "<script>alert('Produto adicionado com sucesso!');
                window.location.href='gerirProdutosAdmin.php';
            </script>";
        } else {
            echo "<script>alert('Por favor, preencha todos os campos.');
                window.location.href=window.location.href;
            </script>";
        }

    }

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps- Área de administrador: Adicionar produto</title>
    <meta name="description" content="Adicione novos produtos à loja PrimeSupps através da área administrativa. Insira detalhes como nome, categoria, preço, e mais.">
    <meta name="keywords" content="PrimeSupps, adicionar produto, administração, loja online, suplementos, gestão de produtos">
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
    <link rel="stylesheet" href="../css/adicionarProdutoAdmin.css">
</head>
<body>

<div id="header"></div>

    <main>
    <h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
    <div class="background">

        <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
        <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
        <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
        <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
        <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

    </div>
    <h1 id="titulo1">Adicionar novo produto</h1>

        <div id="posicaoDesktop">

            <form method="post" enctype="multipart/form-data">
                <input class="inputs" type="text" name="nome" value="" placeholder="Nome" aria-label="Nome" required>
                <select class="inputs" name="categoria" required>
                    <option disabled selected style="display: none;">Categoria</option>
                    <option>Proteínas</option>
                    <option>Vitaminas e minerais</option>
                    <option>Aminoácidos</option>
                    <option>Pré-treino e pós-treino</option>
                    <option>Emagrecimento</option>
                    <option>Outros</option>
                </select>
                <input class="inputs" type="text" name="stock" placeholder="Stock" aria-label="Stock" required>
                <div class="input-group">
                    <input class="inputs" type="text" name="preco" placeholder="Preço" aria-label="Preço" required>
                    <span class="currency-symbol">€</span>
                </div>
                <textarea class="inputs" id="descricao" placeholder="Descriçao" name="descricao"></textarea required>
                <input class="anexarImagens" type="file" name="imagens[]" accept="image/*" multiple onchange="validateImages(this)">
                    <p class="p" id="limiteImagem">Limite máximo: 7MB</p>
                <p id="fileInfo"></p>
                <button id="btnGuardar" type="submit"><p>Adicionar</p></button>
            </form>

        </div>

    </main>
    
<div id="footer"></div>

</body>
</html>