<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';

session_start();

// Função para gerar um código de recuperação
function gerarCodigo($tamanho = 4) {
    return substr(str_shuffle('0123456789'), 0, $tamanho);
}

// Verificar se o e-mail inserido existe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    include 'conexaobd.php';
    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email inválido.');</script>";
        exit();
    }
    
    $sql = "SELECT email, nome, apelido, utilizadorID FROM utilizadores WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $email, $nome, $apelido, $utilizadorID);
            mysqli_stmt_fetch($stmt);

            $codigoRecuperacao = gerarCodigo();
            $_SESSION['codigo_recuperacao'] = $codigoRecuperacao;
            $_SESSION['utilizadorID'] = $utilizadorID;
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $nome;
            $_SESSION['apelido'] = $apelido;

            // Enviar e-mail com código
            require '../PHPMailer-master/src/SMTP.php';
            require '../PHPMailer-master/src/PHPMailer.php';
            require '../PHPMailer-master/src/Exception.php';

            $mail = new PHPMailer(true); 
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Username = 'primesupps.pt@gmail.com';
                $mail->Password = 'nyjh klzg usde zont';
                $mail->Port = 587;

                $mail->setFrom('primesupps.pt@gmail.com', 'Primesupps');
                $mail->addAddress($email, $nome . ' ' . $apelido);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; 
                $mail->Subject = 'Pedido de recuperação de password';
                $mail->Body = 'Segue o seguinte código para recuperar a sua password <b>'.$codigoRecuperacao.'</b>.<br> Se não solicitou nenhum pedido de recuperação, por favor entre em contato connosco.';

                $mail->send();
                echo "<script> alert ('Foi enviado um e-mail com o código de recuperação para que você possa recuperar a sua senha.');
                    window.location.href ='alterarSenha_recuperada.php';</script>";
            } catch (Exception $e) {
                echo "<script> alert('Erro ao enviar código de recuperação');</script>";
            }
        } else {
            echo "<script> alert('E-mail inserido não existe na nossa base de dados.';</script>";
        }
    
        mysqli_stmt_close($stmt);
    } else {
        echo "<script> alert('Erro na preparação do email.');</script>";
    }
    
    mysqli_close($conn);
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
            <input id="EMAIL" type="text" name="email" value="" placeholder="Email" aria-label="Email" required>
            <span class="error-message" id="codigoError"></span>
        </div>
        <button id="btnAlterar" type="submit"><p>Alterar</p></button>
    </form>
    </main>

    <footer></footer>
</body>
</html>