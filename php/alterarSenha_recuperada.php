<?php 

    $anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';

    session_start();
    
// Alterar senha
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['codigo'], $_POST['NovaPassword'], $_POST['ConfirmNovaPassword'])) {

    include'conexaobd.php';

    $codigo = trim($_POST['codigo']);
    $password = trim($_POST['NovaPassword']);
    $confirmPassword = trim($_POST['ConfirmNovaPassword']);

    if (empty($codigo) || empty($password) || empty($confirmPassword)) {
        echo "<script>
            alert('Todos os campos são obrigatórios.');
            window.location.href = 'recuperarSenha.php';
        </script>";
        exit();
    }

    if ($codigo === $_SESSION['codigo_recuperacao']) {
        if ($password === $confirmPassword) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            include 'conexaobd.php';

            $sqlUpdate = "UPDATE utilizadores SET senha = ? WHERE utilizadorID = ?";
            $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

            if ($stmtUpdate) {
                mysqli_stmt_bind_param($stmtUpdate, "si", $hashedPassword, $_SESSION['utilizadorID']);
                if (mysqli_stmt_execute($stmtUpdate)) {
                    date_default_timezone_set('Europe/Lisbon');
                    $data = date('Y-m-d H:i:s');
                    $sqlInsert = "INSERT INTO alteracoes_password (data, utilizadorID) VALUES (?, ?)";
                    $stmtInsert = mysqli_prepare($conn, $sqlInsert);
                    mysqli_stmt_bind_param($stmtInsert, 'si', $data, $_SESSION['utilizadorID']);
                    mysqli_stmt_execute($stmtInsert);

                    mysqli_stmt_close($stmtInsert);
                    mysqli_stmt_close($stmtUpdate);

                    // Limpar a sessão e redirecionar
                    session_destroy();
                    echo "<script>
                        alert('Password alterada com sucesso!');
                        window.location.href = 'iniciarSessao.php';
                    </script>";
                } else {
                    // Mensagem de erro e redirecionamento
                    session_destroy();
                    echo "<script>
                        alert('Erro ao atualizar senha.');
                        window.location.href = 'recuperarSenha.php';
                    </script>";
                }
            } else {
                session_destroy();
                echo "<script>
                    alert('Erro ao preparar a atualização da senha.');
                    window.location.href = 'recuperarSenha.php';
                </script>";
            }

            mysqli_close($conn);
        } else {
            session_destroy();
            echo "<script>
                alert('As senhas inseridas não coincidem.');
                window.location.href = 'recuperarSenha.php';
            </script>";
        }
    } else {
        session_destroy();
        echo "<script>
            alert('Código inserido não é válido.');
            window.location.href = 'recuperarSenha.php';
        </script>";
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Recuperar password</title>
    <meta name="description" content="Recupere sua senha de forma rápida e segura na Primesupps. Siga as instruções para redefinir sua senha e acessar sua conta.">
    <meta name="keywords" content="recuperar senha, recuperação de conta, Primesupps, redefinir senha">
     <!-- Inserir em todas as páginas -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <link rel="stylesheet" href="../css/recuperarSenha.css">
</head>
<body onload="requisicao()">

<header>
        <nav id='navMobile1'>
            <div class="flexContainerHeader">
                <div id="item1FlexHeader">
                    <div class="backGroundHeader">
                    <div class="anteriroUrlHeader"><a href="<?php echo htmlspecialchars($anteriorURL); ?>" title="Ir para página anterior"><i class="fa-solid fa-angle-left"></i></a></div>
                    <div>
                        <h1>Recuperar password</h1>
                    </div>
                    </div>
                <div id="XHeader"><a href="../index.php" title="Ir para página principal"><i class="fa-solid fa-x"></i></a></div>
                </div>
            </div>
        </nav>
    </header>

    <main id="mainRecuperarSenha">

        <form id="formRecuperarSenha" method="post">
        <div class="input-container">
            <input id="codigo" type="password" name="codigo" value="" placeholder="Código" aria-label="codigo" maxlength="4" required>
            <i class="fa fa-eye-slash" id="toggleCodigo" aria-hidden="true" onclick="toggleVisibility('codigo', 'toggleCodigo')"></i>
            <span class="error-message" id="codigoError"></span>
        </div>
        <div class="input-container">
            <input id="password" type="password" name="NovaPassword" placeholder="Nova password" aria-label="Nova password" required>
            <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="toggleVisibility('password', 'togglePassword')"></i>
            <span class="error-message" id="passwordError"></span>
        </div>
        <div class="input-container">
            <input id="confirmPassword" type="password" name="ConfirmNovaPassword" placeholder="Confirmar password" aria-label="Confirmar nova password" required>
            <i class="fa fa-eye-slash" id="toggleConfirmPassword" aria-hidden="true" onclick="toggleVisibility('confirmPassword', 'toggleConfirmPassword')"></i>
            <span class="error-message" id="confirmPasswordError"></span>
        </div>
        <button id="btnAlterar" type="submit" disabled><p>Alterar</p></button>
    </form>
        <button id="reenviarCodigo" type="button" onclick="ReenviarCodigo()"><p>Reenviar código</p></button>

    </main>

    <footer></footer>
    <script type="text/javascript" src="../js/recuperarSenha.js"></script>
</body>
</html>