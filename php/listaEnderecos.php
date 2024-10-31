<?php
session_start();
// Verificar se o usuário está autenticado
if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>alert('Precisa de iniciar sessão para abrir a página!'); 
          window.location.href='../index.php';</script>";
    exit; // Termina a execução do script se o utilizador não estiver autenticado
}

include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];
$nomeUtilizador = $_SESSION['nome'];
$apelidoUtilizador = $_SESSION['apelido'];

// Verificar se o formulário foi submetido e se os campos estão definidos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enderecoID'])) {
    $enderecoID = $_POST['enderecoID'];
    $enderecoPrincipal = isset($_POST['enderecoPrincipal']) ? 1 : 0; // Se checkbox marcado, 1; se não marcado, 0

    // Iniciar uma transação para garantir consistência
    mysqli_begin_transaction($conn);

    try {
        // Atualizar todos os endereços do utilizador para predefinido = 0
        $sqlReset = "UPDATE enderecos SET predefinido = 0 WHERE utilizadorID = ?";
        $stmtReset = mysqli_prepare($conn, $sqlReset);
        mysqli_stmt_bind_param($stmtReset, "i", $utilizadorID);
        mysqli_stmt_execute($stmtReset);
        mysqli_stmt_close($stmtReset);

        // Atualizar o endereço especificado como predefinido
        $sqlUpdate = "UPDATE enderecos SET predefinido = 1 WHERE enderecoID = ? AND utilizadorID = ?";
        $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ii", $enderecoID, $utilizadorID);
        mysqli_stmt_execute($stmtUpdate);

        // Verificar se a atualização foi bem-sucedida
        if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
            mysqli_commit($conn);
            echo "<script> console.log('Endereço predefinido alterado com sucesso!');</script>";
        } else {
            mysqli_rollback($conn);
            echo "<script> console.log('Erro ao alterar endereço predefinido!');</script>";
        }

        mysqli_stmt_close($stmtUpdate);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script> console.log('Erro ao alterar endereço predefinido: " . $e->getMessage() . "');</script>";
    }
}

// Selecionar os endereços do utilizador após a atualização
$sql = "SELECT * FROM enderecos WHERE utilizadorID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $utilizadorID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$enderecos = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_stmt_close($stmt); // Fechar o statement após obter o resultado
mysqli_close($conn);
$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Lista de endereços</title>
    <meta name="description" content="Visualize, edite e remova os endereços de entrega dos utilizadores registados na Primesupps.">
    <meta name="keywords" content="endereços de entrega, gestão de endereços, editar endereços, remover endereços, Primesupps, clientes registados">
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
    <script type="text/javascript" src="../js/listaEnderecos.js"></script>
    <link rel="stylesheet" href="../css/listaEnderecos.css">
</head>
<body>
    
<div id="header"></div>

<main>

        <div class="background2"><h1>Meus endereços</h1></div>

        <div class="background1">

        <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
        <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
        <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
        <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
        <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
        <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

    </div>

    <?php if (empty($enderecos)) : ?>
        <h3 id="alignTitulo">Não foram encontrados endereços cadastrados para este utilizador.</h3>
    <?php else : ?>
        <?php foreach ($enderecos as $endereco) : ?>
                <div id="background">
                    <div id="infoEndereco">
                        <div><p>Nome : <?php echo $nomeUtilizador.' '.$apelidoUtilizador ?></p></div>
                        <div><p>Endereço : <?php echo $endereco['endereco'] ?></p></div>
                        <div><p>Código postal : <?php echo $endereco['codigoPostal'] ?></p></div>
                        <div><p>Cidade : <?php echo $endereco['cidade'] ?></p></div>
                        <div><p>País : <?php echo $endereco['pais'] ?></p></div>
                        <form method="post" id="enderecoPrincipal_<?php echo $endereco['enderecoID']; ?>">
                            <input type="hidden" name="enderecoID" value="<?php echo $endereco['enderecoID']; ?>">
                            <div class="flexboxCheckbox">
                                <input class="checkbox" id="checkBoxEnderecoPrincipal_<?php echo $endereco['enderecoID']; ?>" type="checkbox" name="enderecoPrincipal" <?php echo ($endereco['predefinido'] == 1) ? 'checked' : ''; ?>>
                                <label for="checkBoxEnderecoPrincipal_<?php echo $endereco['enderecoID']; ?>">Endereço principal</label>
                            </div>
                        </form>
                        <div id="flexBtns">
                            <div class="divsFlexBtn">
                                <a id="linkEditar" href="novoEndereco.php?enderecoID=<?php echo $endereco['enderecoID']; ?>" title="Editar endereço">
                                    <button id="btnEditar" type="button"><i class="fa-solid fa-pen"></i></button>
                                </a>
                            </div>
                            <form method="post" action="removerEndereco.php">
                                <input type="hidden" name="enderecoID" value="<?php echo $endereco['enderecoID']; ?>">
                                <div class="divsFlexBtn">
                                    <button id="btnRemover" type="submit"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
        <?php endforeach; ?>
    <?php endif; ?>
    <a id="linkNovoEndereco" href="novoEndereco.php" title="Adicionar novo endereço"><button id="btnNovoEndereco" type="button"><p>Novo endereço</p></button></a>
</main>

<div id="footer"></div>

</body>
</html>