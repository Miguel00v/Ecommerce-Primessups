<?php 
session_start();
include 'conexaobd.php';

// Define o fuso horário padrão
date_default_timezone_set('Europe/Lisbon');

// Verifica se o usuário está logado
if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>
        alert('Precisa de iniciar sessão para aceder a esta página.');
        window.location.href='iniciarSessao.php';
    </script>";
    exit();
}

$utilizadorID = $_SESSION['utilizadorID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = htmlspecialchars($_POST['codigo']);
    $password = trim($_POST['password']);

    // Busca o código mais recente para o usuário
    $sql = "SELECT codigo, dataExpiracao FROM codigo_acesso_admin WHERE utilizadorID = ? ORDER BY dataCriacao DESC LIMIT 1";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $novo_codigo, $data_expiracao);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Erro ao verificar o código de acesso.');</script>";
        exit();
    }

    // Verifica se recuperou o código e a data de expiração corretamente
    if (!$novo_codigo || !$data_expiracao) {
        echo "<script>alert('Não foi possível recuperar o código de acesso ou a data de expiração.');</script>";
        exit();
    }

    // Cria um objeto DateTime com a data de expiração recuperada do banco de dados
    $expirationDateTime = new DateTime($data_expiracao);
    // Cria um objeto DateTime com a data e hora atuais
    $currentDateTime = new DateTime();

    // Para depuração: imprime a data de expiração, a data atual e os códigos
    echo "<script>
        console.log('Data de Expiração: " . $expirationDateTime->format('Y-m-d H:i:s') . "');
        console.log('Data Atual: " . $currentDateTime->format('Y-m-d H:i:s') . "');
        console.log('Código Digitado: " . $codigo . "');
        console.log('Código do Banco: " . $novo_codigo . "');
    </script>";

    // Verifica se o código expirou
    if ($currentDateTime > $expirationDateTime) {
        echo "<script>alert('O código expirou. Por favor, solicite um novo código.');</script>";
    } else {
        // Busca o hash da senha do usuário
        $sql = "SELECT senha FROM utilizadores WHERE utilizadorID = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $senha);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Erro ao verificar a senha do utilizador.');</script>";
            exit();
        }

        // Verifica a senha e o código
        if (password_verify($password, $senha)) {
            if ($codigo === $novo_codigo) {
                $_SESSION['autenticado'] = true;
                echo "<script>
                    alert('Acesso permitido!'); 
                    window.location.href='areaAdministrador.php';
                </script>";
            } else {
                echo "<script>alert('Código de acesso incorreto.');</script>";
            }
        } else {
            echo "<script>alert('Senha incorreta.');</script>";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Verificar acesso à página de administração</title>
    <meta name="description" content="Verifique seu acesso à área de administração da Primesupps. Receba um código por e-mail para autenticação e acesso ao painel administrativo.">
    <meta name="keywords" content="Primesupps, administração, acesso, código, painel administrativo, e-mail, autenticação">
     <!-- Inserir em todas as páginas -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/verificarAdministrador.js"></script>
    <link rel="stylesheet" href="../css/verificarAdministrador.css">
</head>
<body>
<header>
        <nav id='navMobile1'>
            <div class="flexContainerHeader">
                <div id="item1FlexHeader">
                    <div class="backGroundHeader">
                    <div class="anteriroUrlHeader"><a href="<?php echo htmlspecialchars($anteriorURL); ?>" title="Ir para página anterior"><i class="fa-solid fa-angle-left"></i></a></div>
                    <div>
                        <h1>Verificar identidade</h1>
                    </div>
                    </div>
                <div id="XHeader"><a href="../index.php" title="Ir para página principal"><i class="fa-solid fa-x"></i></a></div>
                </div>
            </div>
        </nav>
    </header>

<main>

    <form method="post">
        <input type="text" name="codigo" value="" placeholder="Código enviado por email" required>
        <div class="password-container">
            <input type="password" name="password" id="password" value="" placeholder="Password" required>
            <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
        </div>
        <button id="btnReset" class="btn" type="button" id="resendCode" onclick="reenviarCodigo()"><p class="p">Reenviar código</p></button>
        <button id="btnSubmit" class="btn" type="submit"><p>Verificar</p></button>
    </form>

</main>

<footer>

</footer>

</body>
</html>