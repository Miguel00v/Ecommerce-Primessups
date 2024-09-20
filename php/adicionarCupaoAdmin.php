<?php
session_start();

// Configurar o fuso horário para Portugal
date_default_timezone_set('Europe/Lisbon');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricao = $_POST['descricao'];
    $codigo = strtoupper($_POST['codigo']);
    $valor = $_POST['valor'];
    // Remover vírgula se inserida
    $valor = str_replace(',', '.', $valor);
    $tipoValor = strtoupper($_POST['tipoValor']);
    $dataExpiracao = $_POST['dataExpiracao'];

    $descricao = htmlspecialchars(trim($descricao));
    $codigo = htmlspecialchars(trim($codigo));
    $valor = filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (!is_numeric($valor)) {
        echo "<script>alert('Erro: O valor deve ser um número válido.');
            window.location.href='adicionarCupaoAdmin.php';
        </script>";
        exit;
    }

    $dataExpiracao = htmlspecialchars(trim($dataExpiracao));
    $dataExpiracao = new DateTime($dataExpiracao);
    $dataAtual = new DateTime();

    if ($dataExpiracao <= $dataAtual) {
        echo "<script>alert('Erro: A data de expiração deve ser superior à data atual.');
            window.location.href='adicionarCupaoAdmin.php';
        </script>";
        exit;
    }

    $dataExpiracaoFormatada = $dataExpiracao->format('Y-m-d H:i:s');

    include 'conexaobd.php';

    $sql = "INSERT INTO cupoes (descricao, codigo, valor, tipoValor, dataExpiracao) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Erro na preparação: ' . $conn->error);
    }

    // Ajustar bind_param para corresponder ao tipo de dados
    $stmt->bind_param('sssss', $descricao, $codigo, $valor, $tipoValor, $dataExpiracaoFormatada);

    if ($stmt->execute()) {
        echo "<script>alert('Cupão adicionado com sucesso!');
            window.location.href='gerirCupoesAdmin.php';
        </script>";
    } else {
        echo "<script>alert('Erro ao adicionar cupão: " . $stmt->error . "');
            window.location.href='adicionarCupaoAdmin.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps- Área de administrador : Adicionar cupão</title>
    <meta name="description" content="Área de administração para adicionar novos cupons ao sistema PrimeSupps.">
    <meta name="keywords" content="administração, adicionar cupão, PrimeSupps, gerenciamento, área de administrador">
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
     <link rel="stylesheet" href="../css/adicionarCupaoAdmin.css">
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
    <h1 id="titulo1">Adicionar novo cupão</h1>
        <form method="post">
            <input class="inputs" type="text" name="descricao" value="" placeholder="Descrição" required>
            <input class="inputs" type="text" name="codigo" value="" placeholder="Código" required>
            <select class="inputs" name="tipoValor">
                <option disabled selected style="display: none;">Tipo de valor</option>
                <option>Percentual</option>
                <option>Fixo</option>
            </select>
            <input class="inputs" type="text" name="valor" value="" placeholder="Valor" required>
            <input  class="inputs" type="datetime-local" name="dataExpiracao" placeholder="Data de expiração" value="" required>
            <button class="btnAdicionar" type="submit"><p>Adicionar</p></button>
        </form>

    </main>
    
<div id="footer"></div>

</body>
</html>