<?php 

session_start();

if(isset($_SESSION['utilizadorID'])){

    include'conexaobd.php';
    $utilizadorID= $_SESSION['utilizadorID'];

    $sql = "Select nome, apelido, dataNascimento, email, imagem FROM utilizadores WHERE utilizadorID = ? ";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt, "i", $utilizadorID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome, $apelido, $dataNascimento, $email, $imagem);
    if(mysqli_stmt_fetch($stmt)<0){

        echo " <script> alert('Erro ao carregar página'); 
        window.location.href='../index.php';
    </script> ";

    }
    mysqli_stmt_close($stmt);

}

//Seleciondar os dados de permissões

$newsletter = 0;
$emails = 0;
$sql = "SELECT receberNewsletter, receberEmails FROM permissoes WHERE utilizadorID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $utilizadorID);
$stmt->execute();
$stmt->bind_result($newsletter, $emails);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Dados da conta</title>
    <meta name="description" content="Acesse seus dados da conta na Primesupps. Edite suas informações pessoais e visualize sua imagem de perfil.">
    <meta name="keywords" content="suplementos nutricionais, vitaminas, proteínas, saúde, bem-estar, musculação, emagrecimento, fitness, whey protein, creatina, BCAA, multivitamínico">
    <meta name="keywords" content="Primesupps, conta Primesupps, dados da conta, editar informações, imagem de perfil, suplementos, saúde e bem-estar">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <link rel="stylesheet" href="../css/gerirDadosContaDesktop.css">
    <script type="text/javascript" src="../js/gerirDadosContaDesktop.js"></script>
</head>
<body>

    <?php include'headerDesktop.php'; ?>

    <main>
    <div class="background">

    <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
        <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
        <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
        <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
        <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
        <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

    </div>

        <div class="background1">
            <!-- Butões -->
            <div class="flexBtns">
        <button onclick="toggleForm('dadosPessoais', this)" class="dropbtn">
            <p>Dados pessoais</p>
            <i class="fa-solid fa-chevron-down" id="setaBaixo"></i> 
            <i class="fa-solid fa-chevron-right" id="setaDireita"></i>
        </button>

        <button onclick="toggleForm('imagemPerfilDados', this)" class="dropbtn">
            <p>Fotografia de perfil</p>
            <i class="fa-solid fa-chevron-down" id="setaBaixo"></i> 
            <i class="fa-solid fa-chevron-right" id="setaDireita"></i>
        </button>

        <button onclick="toggleForm('permissoes', this)" class="dropbtn">
            <p>Gerir permissões</p>
            <i class="fa-solid fa-chevron-down" id="setaBaixo"></i> 
            <i class="fa-solid fa-chevron-right" id="setaDireita"></i>
        </button>

        <button onclick="toggleForm('desativacaoConta', this)" class="dropbtn">
            <p>Desativar conta</p>
            <i class="fa-solid fa-chevron-down" id="setaBaixo"></i> 
            <i class="fa-solid fa-chevron-right" id="setaDireita"></i>
        </button>
    </div>
            <!-- Formulários -->
            <div class="posicaoForms" id="dadosPessoais">

            <form action="atualizarDadosContaDesktop.php" method="post">
                <h2>Editar informação pessoal</h2>
                <div class="flexInputs">
                    <div class="inputGroup">
                        <input class="inputs" type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo htmlspecialchars($nome) ?>" onchange="verificarNome()">
                        <span class="erro" id="erroNome"></span>
                    </div>
                    <div class="inputGroup">
                        <input class="inputs" type="text" name="apelido" id="apelido" placeholder="Apelido" value="<?php echo htmlspecialchars($apelido) ?>" onchange="verificarApelido()">
                        <span class="erro" id="erroApelido"></span>
                    </div>
                </div>
                <div class="inputGroup">
                    <input class="inputs" type="date" name="dataNascimento" id="dataNascimento" placeholder="Data de nascimento" value="<?php echo htmlspecialchars($dataNascimento) ?>" onchange="verificarDataNascimento()">
                    <span class="erro" id="erroDataNascimento"></span>
                </div>
                <div class="inputGroup">
                    <input class="inputs" type="email" name="email" id="email" placeholder="Email" value="<?php echo htmlspecialchars($email) ?>" onchange="verificarEmail()">
                    <span class="erro" id="erroEmail"></span>
                </div>
                <button id="btnAlterarDadosPessoais" type="submit" disabled>
                    <p>Guardar alterações</p>
                </button>
            </form>

            </div>

            <div class="posicaoForms" id="imagemPerfilDados">

            <form method="post" action="atualizarFotoPerfil.php" enctype="multipart/form-data">
                <h2>Alterar imagem de perfil</h2>
                
                <!-- Imagem de perfil atual -->
                 <div class="flexImage">
                    <div class="divImagens">
                        <h3>Imagem atual</h3>
                        <img id="imagemPerfilAtual" src="<?php echo htmlspecialchars($imagem) ?>" alt="Imagem de perfil">
                    </div>

                    <div class="previewImagem">
                        <h3>Nova imagem</h3>
                        <img id="previewImagem" src="" alt="Pré-visualização da imagem selecionada">
                    </div>
                 </div>
                
                <!-- Input para seleção da nova imagem -->
                <input type="file" name="fotoPerfilDados" id="fotoPerfilDados" accept="image/*" placeholder="Foto de perfil">

                <!-- Botão para guardar a imagem -->
                <button id="btnAtualizarFotoPerfil" type="submit" disabled><p>Guardar imagem</p></button>
            </form>


            </div>

            <div class="posicaoForms" id="permissoes">

                <form method="post" action="atualizarPermissoesDesktop.php">
                    <h2>Minhas permissões</h2>
                    <div>

                    <div><h3>Newsletter</h3></div>
                    <div id="newsletter">
                            <div><input type="checkbox" name="newsletter" <?php echo ($newsletter ? 'checked' : ''); ?>></div>
                            <div><label>Autorizo a subscrição de newsletter</label></div>
                    </div>

                    </div>
                    <div>

                    <div><h3>Notificações por email</h3></div>
                    <div id="emails">
                            <div><input type="checkbox" name="emails" <?php echo ($emails ? 'checked' : ''); ?>></div>
                            <div><label>Aceito receber emails com informações sobre a minha encomenda, prazos de validade, informações de pagamento e outros lembretes</label></div>

                    </div>
                    <button id="btnAlterarPermissoes" type="submit"><p>Alterar permissões</p></button>
                    </div>
                </form>

            </div>

            <div class="posicaoForms" id="desativacaoConta">

                <form action="desativarConta.php" id="formDesativar" method="post">
                    <h2>Desativar conta</h2>
                    <p>Ao desativares a tua conta vais perder todos os benefícios de seres nosso cliente, além de perderes a possibilidade de efetuar compras em primesupps.pt</p>
                    <button id="btnDesativar" type="button" onclick="confirmarDesativacao()"><p>Desativar conta</p></button>
                </form>

            </div>

        </div>

    </main>

    <?php include'footerDesktop.php'; ?>
</body> 