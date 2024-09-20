<?php

session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'conexaobd.php';

    $utilizadorID = $_SESSION['utilizadorID'];
    $passwordAtualInput = $_POST['passwordAtual'];
    $novaPassword = $_POST['novaPassword'];
    $confirmarNovaPassword = $_POST['confirmarNovaPassword'];
    date_default_timezone_set('Europe/Lisbon');
    $data = date('Y-m-d H:i:s');

    // Selecionar a senha antiga e verificar se coincidem
    $sqlSelect = "SELECT senha FROM utilizadores WHERE utilizadorID = ?";
    $stmtSelect = mysqli_prepare($conn, $sqlSelect);
    mysqli_stmt_bind_param($stmtSelect, 'i', $utilizadorID);
    mysqli_stmt_execute($stmtSelect);
    mysqli_stmt_bind_result($stmtSelect, $passwordAntiga);
    mysqli_stmt_fetch($stmtSelect);
    mysqli_stmt_close($stmtSelect);

    if (!password_verify($passwordAtualInput, $passwordAntiga)) {
        echo "<script>alert('A password atual não está correta!');window.location.href = window.location.href;</script>";
        exit();
    }

    if ($passwordAtualInput === $novaPassword) {
        echo "<script>alert('A password que inseriu é semelhante à password atual, insira uma distinta!');window.location.href = window.location.href;</script>";
        exit();
    }

    if ($novaPassword !== $confirmarNovaPassword) {
        echo "<script>alert('As passwords que inseriu não coincidem!');window.location.href = window.location.href;</script>";
        exit();
    }

    $novaPasswordUser = password_hash($novaPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE utilizadores SET senha = ? WHERE utilizadorID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $novaPasswordUser, $utilizadorID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $sqlInsert = "INSERT INTO alteracoes_password (data, utilizadorID) VALUES (?,?)";
        $stmtInsert = mysqli_prepare($conn, $sqlInsert);
        mysqli_stmt_bind_param($stmtInsert, 'si', $data, $utilizadorID);
        mysqli_stmt_execute($stmtInsert);
        mysqli_stmt_close($stmtInsert);

        echo "<script>alert('Password alterada com sucesso!'); window.location.href='logout.php';
        window.location.href='iniciarSessao.php';
        </script>";

    } else {
        echo "<script>alert('Erro ao alterar password!');
        window.location.href = window.location.href;</script>";
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primessups - Alterar password</title>
    <meta name="description" content="Página para alteração de senha do usuário no site Primessups.">
    <meta name="keywords" content="Primessups, alterar senha, segurança de conta, PHP, MySQL">
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
    <script type="text/javascript" src="../js/alterarPassword.js"></script>
    <link rel="stylesheet" href="../css/alterarPassword.css">
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
    <div>

        <div id="posicaoDesktop">
            <div class="flexboxAlterar">
                <div id="key"><i class="fa-solid fa-key"></i></div>
                <div><h2>Alterar password</h2></div>
            </div>
        </div>

        <div id="form">
            <form action="" method="post">
                <div class="containerPassword">
                    <input class="inputs" id="password" type="password" name="passwordAtual" placeholder="Password atual" aria-label="Password atual" required oninput="verificarPassword()" onfocus="voltarNormalPassword()">
                    <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
                </div>
                <div class="containerPassword">
                <input class="inputs" id="novaPassword" type="password" name="novaPassword" placeholder="Nova password" aria-label="Nova password" required oninput="verificarNovaPassword()" onfocus="voltarNormalNovaPassword()">
                <i class="fa fa-eye-slash" id="toggleNovaPassword" aria-hidden="true" onclick="toggleNovaPasswordVisibility()"></i>
                </div>
                <div class="containerPassword">
                <input class="inputs" id="confirmarNovaPassword" type="password" name="confirmarNovaPassword" placeholder="Confirmar nova password" aria-label="Confirmar nova password" required oninput="verificarConfirmPassword()" onfocus="voltarNormalConfirmPassword()">
                <i class="fa fa-eye-slash" id="toggleConfirmarNovaPassword" aria-hidden="true" onclick="toggleConfirmarNovaPasswordVisibility()"></i>
                </div>
                <button id="alterarBtn" type="submit" disabled><p>Alterar</p></button>
            </form>
        </div>

    </div>

</main>

<div id="footer"></div>

</body>
</html>

