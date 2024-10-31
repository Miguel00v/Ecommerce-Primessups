<?php

session_start();

include 'conexaobd.php';

//Verifica se o formulario foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailInput = $_POST['email'];
    $passwordInput = $_POST['password'];
    $sql = "SELECT * FROM utilizadores WHERE email = ? AND emailConfirmado ='1'";

    //Sanitizar os dados
    $email = mysqli_escape_string($conn, $emailInput);

    //Preparar os statements
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    //verificar se o email existe
    if ($resultado->num_rows === 1) {
        $utilizador = mysqli_fetch_assoc($resultado);

        //Verificar password
        if (password_verify($passwordInput, $utilizador['senha'])) {

            //Declarção de variáveis de sessão
            $_SESSION['email'] = $utilizador['email'];
            $_SESSION['nome'] = $utilizador['nome'];
            $_SESSION['apelido'] = $utilizador['apelido'];
            $_SESSION['utilizadorID'] = $utilizador['utilizadorID'];
            $_SESSION['funcao'] = $utilizador['funcao'];
            $_SESSION['imagem'] = $utilizador['imagem'];
            $_SESSION['dataNascimento'] = $utilizador['dataNascimento'];
            $_SESSION['login'] = true; // Indica que o utilizador iniciou login

            
            echo "<script>alert('Login efetuado com sucesso!'); window.location.href = '../index.php';</script>";
            exit;

        } else {
            
            //Password inserida está incorreta
            echo "<script>alert('Senha incorreta!');</script>";

        }
    } else {

        //Email inserido não existe
        echo "<script>alert('O email que introduziu não está registado!');</script>";

    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

//Link para rederecionar para página anterior se definida, senão vai para página inicial
$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Iniciar sessão</title>
    <meta name="description" content="Página de login para iniciar sessão na Primesupps. Inicie sessão na sua conta ou crie uma nova.">
     <!-- Inserir em todas as páginas -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/iniciarSessao.js"></script>
    <link rel="stylesheet" href="../css/iniciarSessao.css">
</head>
<body>
    
<header>
        <nav id='navMobile1'>
            <div class="flexContainerHeader">
                <div id="item1FlexHeader">
                    <div class="backGroundHeader">
                    <div class="anteriroUrlHeader"><a href="<?php echo htmlspecialchars($anteriorURL); ?>" title="Ir para página anterior"><i class="fa-solid fa-angle-left"></i></a></div>
                    <div>
                        <h1>Iniciar Sessão</h1>
                    </div>
                    </div>
                <div id="XHeader"><a href="../index.php" title="Ir para página principal"><i class="fa-solid fa-x"></i></a></div>
                </div>
            </div>
        </nav>
    </header>
    <main id="mainIniciarSessao">

        <form method="post">

            <input type="email" id="email" name="email" placeholder="Email" aria-label="Email" required>
            <div class="password-container">
            <input type="password" id="password" name="password" placeholder="Password" aria-label="Password" required>
            <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
            </div>
            <button id="btnIniciaSessao" type="submit"><h3>Iniciar sessão</h3></button>

        </form>
        
            <a id="linkRecuperarSenha" href="recuperarSenha.php" title="Recuperar senha">
                <button id="btnRecuperarSenha" type="button"><p class="p">Esqueceste-te da password?</p></button>
            </a>
        

    </main>

    <footer>

        <div id="footerIniciarSessao">
            <p class="p">Esta é a sua primeira vez ?</p> 
            <div id="backgroundBtn">
                <a id="linkCriarConta" href="criarConta.php" title="Criar conta">
                    <button id="btnCriarConta" type="button"><p>Criar conta</p></button>
                </a>
            </div>
        </div>

    </footer>

</body>
</html>

