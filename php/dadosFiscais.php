<?php 
session_start();

if(!isset($_SESSION['utilizadorID'])){
    echo "<script> 
        alert('Não tem sessão iniciada.'); 
        window.location.href='iniciarSessao.php';
      </script>";
    exit();
}

$utilizadorID = $_SESSION['utilizadorID'];

include 'conexaobd.php';

$sql = "SELECT dadosFiscaisID, NIF, endereco, pais, codigoPostal, cidade, nome, apelido, predefinido FROM dados_fiscais WHERE utilizadorID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $utilizadorID);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $dadosFiscaisID, $NIF, $endereco, $pais, $codigoPostal, $cidade, $nome, $apelido, $predefinido);
$dadosFiscais = [];

while (mysqli_stmt_fetch($stmt)) {
    $dadosFiscais[] = [
        'dadosFiscaisID' => $dadosFiscaisID,
        'NIF' => $NIF,
        'endereco' => $endereco,
        'pais' => $pais,
        'codigoPostal' => $codigoPostal,
        'cidade' => $cidade,
        'nome' => $nome,
        'apelido' => $apelido,
        'predefinido' => $predefinido
    ];
}

mysqli_stmt_close($stmt);

// Atualizar o dado fiscal predefinido se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dadosFiscaisPredefinida']) && isset($_POST['dadosFiscaisID'])) {
    $dadosFiscaisID = intval($_POST['dadosFiscaisID']);
    $predefinida = intval($_POST['dadosFiscaisPredefinida']);

    // Remove o predefinido existente
    $sql = "UPDATE dados_fiscais SET predefinido = '0' WHERE utilizadorID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($conn);
    }

    // Define como predefinido
    $sql = "UPDATE dados_fiscais SET predefinido = ? WHERE utilizadorID = ? AND dadosFiscaisID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iii', $predefinida, $utilizadorID, $dadosFiscaisID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($conn);
    }
}
//Link para rederecionar para página anterior se definida, senão vai para página inicial
$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Dados fiscais</title>
    <meta name="description" content="Confira a lista completa de dados fiscais da Primesupps. Encontre informações detalhadas sobre transações, impostos, e muito mais.">
    <meta name="keywords" content="Primesupps, dados fiscais, transações, impostos, lista fiscal, informações fiscais, relatórios fiscais">
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
    <script type="text/javascript" src="../js/dadosFiscais.js"></script>
    <link rel="stylesheet" href="../css/dadosFiscais.css">
</head>
<body>

<div id="header"></div>

<main>
<div class="background">

<div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
    <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
    <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
    <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
    <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
    <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

</div>
    <?php if(!empty($dadosFiscais)): ?>
        <?php foreach ($dadosFiscais as $dados): ?>
            <div class="backgroundDadosFiscais">
                    <form method="post" action="">
                        <input type="hidden" name="dadosFiscaisID" value="<?php echo htmlspecialchars($dados['dadosFiscaisID']); ?>">
                        <div class="predefinidoDadoFiscal"><input class="checkboxPredefinido" type="checkbox" name="dadoFiscalPredefinido" <?php echo ($dados['predefinido'] ? 'checked' : ''); ?>></div>
                    </form>
                <div class="infoDadosFiscais">
                    <div><p>Nome : <?php echo htmlspecialchars($dados['nome']).' '.htmlspecialchars($dados['apelido']); ?></p></div>
                    <div><p>Endereço : <?php echo htmlspecialchars($dados['endereco']); ?></p></div>
                    <div><p>Código Postal : <?php echo htmlspecialchars($dados['codigoPostal']); ?></p></div>
                    <div><p><?php echo htmlspecialchars($dados['cidade']).', '.htmlspecialchars($dados['pais']); ?></p></div>
                    <div><p>NIF : <?php echo htmlspecialchars($dados['NIF']); ?></p></div>
                </div> 
                    <form method="post" action="removerDadosFiscais.php">
                        <input type="hidden" name="dadosFiscaisID" value="<?php echo htmlspecialchars($dados['dadosFiscaisID']); ?>">
                        <div class="posicaoBtnRemover"><button class="btnRemover" type="submit"><i class="fa-solid fa-trash"></i></button></div>
                    </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>
            <div><h2 id="semdadosFiscais">Não tem dados fiscais guardados.</h2></div>
        </div>
    <?php endif; ?>
    <div id="divbtnAdd"><a class="linkNovoDadoFiscal" href="novoDadoFiscal.php" title="Adicionar novo dado fiscal"><button class="btnDadoFiscal" type="button"><p>Criar novo</p></button></a></div>
</main>

<div id="footer"></div>

</body>
</html>
