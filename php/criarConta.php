<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexaobd.php';

    function capitalizeFirstLetter($string)
    {
        return ucfirst(strtolower(trim($string)));
    }

    // Get and trim input data
    $nome = capitalizeFirstLetter($_POST['nome']);
    $apelido = capitalizeFirstLetter($_POST['apelido']);
    $dataNascimento = trim($_POST['dataNascimento']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $aceitarTermos = isset($_POST['aceitarTermos']) ? 1 : 0;

    // Validate inputs
    if (empty($nome) || empty($apelido) || empty($dataNascimento) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo '<script>alert("Todos os campos são obrigatórios"); window.location.href="registro.php";</script>';
        exit;
    }

    if ($password !== $confirmPassword) {
        echo '<script>alert("As senhas não coincidem"); window.location.href="registro.php";</script>';
        exit;
    }

    // Sanitize input
    $nomeSanitizado = mysqli_real_escape_string($conn, $nome);
    $apelidoSanitizado = mysqli_real_escape_string($conn, $apelido);
    $dataNascimentoSanitizado = mysqli_real_escape_string($conn, $dataNascimento);
    $emailSanitizado = mysqli_real_escape_string($conn, $email);

    // Check if email already exists
    $sql = "SELECT * FROM utilizadores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Database prepare error: ' . $conn->error);
    }
    $stmt->bind_param('s', $emailSanitizado);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script>alert("Este email já está em uso"); window.location.href="registro.php";</script>';
        $stmt->close();
        $conn->close();
        exit;
    }

    // Insert user into the database
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(16));

    $sqlInsert = "INSERT INTO utilizadores (nome, apelido, dataNascimento, email, senha, funcao, token, emailConfirmado) 
                  VALUES (?, ?, ?, ?, ?, 'utilizador', ?, '0')";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        die('Database prepare error: ' . $conn->error);
    }
    $stmtInsert->bind_param('ssssss', $nomeSanitizado, $apelidoSanitizado, $dataNascimentoSanitizado, $emailSanitizado, $passwordHash, $token);

    if ($stmtInsert->execute()) {
        $utilizadorID = $stmtInsert->insert_id;

        // Insert permissions
        $sqlInsertPermissoes = "INSERT INTO permissoes (utilizadorID, email, receberNewsletter, receberEmails) VALUES (?, ?, '1', '1')";
        $stmtPermissoes = $conn->prepare($sqlInsertPermissoes);
        if (!$stmtPermissoes) {
            die('Database prepare error: ' . $conn->error);
        }
        $stmtPermissoes->bind_param('is', $utilizadorID, $emailSanitizado);
        $stmtPermissoes->execute();

        if ($stmtPermissoes->affected_rows > 0) {
            // Send confirmation email
            require '../PHPMailer-master/src/SMTP.php';
            require '../PHPMailer-master/src/PHPMailer.php';
            require '../PHPMailer-master/src/Exception.php';

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Username = 'primesupps.pt@gmail.com';
            $mail->Password = 'nyjh klzg usde zont';
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('primesupps.pt@gmail.com', 'Primesupps');
            $mail->addAddress($emailSanitizado, $nomeSanitizado . ' ' . $apelidoSanitizado);
            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; // Define a codificação de caracteres para UTF-8
            $mail->Subject = 'Verificação de email';
            $mail->Body = 'Clique no link para verificar seu e-mail: <a href="http://localhost/Trabalho%20final/Desenvolvimento/php/verificacaoEmail.php?token=' .  urlencode($token) . '">Verificar E-mail</a>';
            $mail->AltBody = 'Clique no link para verificar seu e-mail: http://localhost/Trabalho%20final/Desenvolvimento/php/verificacaoEmail.php?token=' .  urlencode($token);

            if ($mail->send()) {
                echo '<script>alert("Registo efetuado com sucesso. Por favor confirme o email, através do link que lhe foi enviado para o email!"); window.location.href="iniciarSessao.php";</script>';
            } else {
                echo '<script>alert("Erro ao enviar email de confirmação"); window.location.href="iniciarSessao.php";</script>';
            }
        } else {
            echo '<script>alert("Erro ao inserir permissões"); window.location.href="iniciarSessao.php";</script>';
        }

        $stmtPermissoes->close();
    } else {
        echo '<script>alert("Erro ao criar conta"); window.location.href="iniciarSessao.php";</script>';
    }

    $stmtInsert->close();
    $conn->close();
}


?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Criar conta</title>
    <meta name="description" content="Crie uma conta na Primesupps para começar a usar os nossos serviços. Preencha o formulário com seu nome, apelido, data de nascimento, email e password.">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/criarConta.js"></script>
    <link rel="stylesheet" href="../css/criarConta.css">
</head>

<body>
    <header>
        <nav id='navMobile1'>
            <div class="flexContainerHeader">
                <div id="item1FlexHeader">
                    <div class="backGroundHeader">
                    <div class="anteriroUrlHeader"><a href="<?php echo htmlspecialchars($anteriorURL); ?>" title="Ir para página anterior"><i class="fa-solid fa-angle-left"></i></a></div>
                    <div>
                        <h1>Criar conta</h1>
                    </div>
                    </div>
                <div id="XHeader"><a href="index.php" title="Ir para página principal"><i class="fa-solid fa-x"></i></a></div>
                </div>
            </div>
        </nav>
    </header>
    <main id="mainCriarconta">
        <form id="formCriarConta" method="post">
            <div id="itemCriarConta1">
                <div class="flexBoxMensagemErro">
                    <input class="input" type="text" id="nome" name="nome" placeholder="Nome*" aria-label="Nome*" required onchange="verificarNome()" onfocus="voltarNormalNome()">
                    <div class="error-message" id="error-message-1"></div>
                </div>
                <div class="flexBoxMensagemErro">
                    <input class="input" type="text" id="apelido" name="apelido" placeholder="Apelido*" aria-label="Apelido*" required onchange="verificarApelido()" onfocus="voltarNormalApelido()">
                    <div class="error-message" id="error-message-2"></div>
                </div>
            </div>
            <div class="flexBoxMensagemErro">
                <input class="input" type="text" id="dataNascimento" name="dataNascimento" placeholder="Data de nascimento*" aria-label="Data de nascimento*" required onchange="verificarDataNascimento()" onfocus="this.type='date'; this.id='dataNascimentoDate'" onblur="this.type='text'; this.id='dataNascimentoText'">
                <div class="error-message" id="error-message-3"></div>
            </div>
            <div class="flexBoxMensagemErro">
                <input class="input" type="email" id="email" name="email" placeholder="Email*" aria-label="Email*" required onchange="verificarEmail()" onfocus="voltarNormalEmail()">
                <div class="error-message" id="error-message-4"></div>
            </div>
            <div id="itemCriarConta2" class="password-flex-container">
            <div class="password-container">
                    <input class="input" type="password" id="password" name="password" placeholder="Password*" aria-label="Password*" required>
                    <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
                    <div class="error-message" id="error-message-5"></div>
                </div>
                <div class="password-container">
                    <input class="input" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmar password*" aria-label="Confirmar password*" required onchange="verificarConfirmPassword()" onfocus="voltarNormalConfirmPassword()">
                    <i class="fa fa-eye-slash" id="toggleConfirmPassword" aria-hidden="true" onclick="toggleConfirmPasswordVisibility()"></i>
                    <div class="error-message" id="error-message-6"></div>
                </div>
            </div>
                <div id="flex-TermosCriarconta">
                    <input type="checkbox" id="aceitarTermos" name="aceitarTermos" required>
                    <label id="labelTermos">Ao aceitar criar conta, aceito os <a href="termosCondicoes.php" title="Termos e condições">termos e condições</a></label>
                </div>
            <button id="alterarBtn" type="submit" onclick="validarForm()"><h3>Criar conta</h3></button>
        </form>
    </main>

    <footer></footer>
</body>

</html>