<?php

    session_start();

    if($_SERVER['REQUEST_METHOD']=='POST'){
        include'conexaobd.php';

        function capitalizeFirstLetter($string) {
            return ucfirst(strtolower(trim($string)));
        }

        $nome = capitalizeFirstLetter($_POST['nome']);
        $apelido = capitalizeFirstLetter($_POST['apelido']);
        $dataNascimento = $_POST['dataNascimento'];
        $email = trim($_POST['email']);
        $funcao = $_POST['funcao'];
        $password = password_hash(trim($_POST['password']),PASSWORD_DEFAULT);


        $sql = " INSERT INTO utilizadores (nome, apelido, dataNascimento, email, funcao, senha, emailConfirmado) VALUES (?, ?, ?, ?, ?, ?, '1') ";
        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, 'ssssss', $nome, $apelido, $dataNascimento, $email, $funcao, $password);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt)>0){

            echo " <script>alert('Utilizador criado com sucesso!'); 
                window.location.href='gerirUtilizadoresAdminDesktop.php';
            </script>" ;

        } else {

            echo " <script> alert('Erro ao criar utilizador!'); 
            </script> " ;
            exit();

        }

    }


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Área de administrador: Adicionar novo utilizador</title>
    <meta name="description" content="Administração do PrimeSupps - Adicione novos utilizadores ao sistema.">
    <meta name="keywords" content="PrimeSupps, Administração, Adicionar Utilizador, Gestão de Utilizadores">
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
    <script type="text/javascript" src="../js/adicionarUtilizadorAdmin.js"></script>
    <link rel="stylesheet" href="../css/adicionarUtilizadorAdmin.css">
</head>
<body>
    
<?php include'headerDesktop.php'; ?>

    <main>

        <h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
        <div class="background">

            <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
            <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
            <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
            <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
            <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

        </div>

        <h1 id="titulo1">Criar novo utilizador</h1>

        <div>
            <form method="post">
                <div class="flex1">
                    <div class="flexBoxMensagemErro">
                        <input class="inputs" type="text" id="nome" name="nome" placeholder="Nome*" aria-label="Nome*" required onchange="verificarNome()" onfocus="voltarNormalNome()">
                        <div class="error-message" id="error-message-1"></div>
                    </div>
                    <div class="flexBoxMensagemErro">
                    <input class="inputs" type="text" id="apelido" name="apelido" placeholder="Apelido*" aria-label="Apelido*" required onchange="verificarApelido()" onfocus="voltarNormalApelido()"> 
                    <div class="error-message" id="error-message-1"></div>
                    </div>

                </div>
                <input class="inputs" type="text" id="dataNascimento" name="dataNascimento" placeholder="Data de nascimento*" aria-label="Data de nascimento*" required onchange="verificarDataNascimento()" onfocus="this.type='date'; this.id='dataNascimentoDate'" onblur="this.type='text'; this.id='dataNascimentoText'">
                <input class="inputs" type="email" id="email" name="email" placeholder="Email*" aria-label="Email*" required onchange="verificarEmail()" onfocus="voltarNormalEmail()">
                <select class="inputs" name="funcao" id="funcao" onselect="verificarFuncao()">
                    <option disabled selected style="display: none;">Função*</option>
                    <option>administrador</option>
                    <option>utilizador</option>
                </select>
                <div class="flex1">
                    <div class="containerPassword">
                        <input class="inputs" type="password" id="password" name="password" placeholder="Password*" aria-label="Password*" required onchange="verificarPassword()" onfocus="voltarNormalPassword()"> 
                        <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
                    </div>
                    <div class="containerPassword">
                        <input class="inputs" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmar password*" aria-label="Confirmar password*" required onchange="verificarConfirmPassword()" onfocus="voltarNormalConfirmPassword()">
                        <i class="fa fa-eye-slash" id="toggleConfirmPassword" aria-hidden="true" onclick="toggleConfirmPasswordVisibility()"></i>
                    </div>
                </div>
                <button id="alterarBtn" type="submit" onclick="validarForm()"><p>Criar conta</p></button>

            </form>

        </div>

    </main>

    <?php include'footerDesktop.php'; ?>

</body>
</html>