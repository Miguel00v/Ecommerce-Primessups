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

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Dados da conta</title>
    <meta name="description" content="Acesse seus dados da conta na Primesupps. Edite suas informações pessoais e visualize sua imagem de perfil.">
    <meta name="keywords" content="Primesupps, conta Primesupps, dados da conta, editar informações, imagem de perfil, suplementos, saúde e bem-estar">
   <!-- Inserir em todas as páginas -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <link rel="stylesheet" href="../css/dadosConta.css">
    <script type="text/javascript" src="../js/dadosConta.js"></script>
</head>
<body>
    
<?php include'headerMobile.php'; ?>

<main>

<div class="escondido" id="tituloAlterarDados"><h2>Alterar dados da conta</h2></div>
    <div id="background">
        <form method="post" action="atualizarDadosConta.php" enctype="multipart/form-data">

        <div id="dadosUser">

        <div id="imagemNome">
            <div id="flexImagem">

        <?php 
            if ($imagem == NULL) {
                echo '
                    <input class="padrao" type="image" src="../imagens/icons/fotoPerfil.svg" name="imagem" alt="Imagem de perfil do utilizador" disabled>
                    <input id="inputImagem" type="file" accept="image/*" name="imagem" ">
                    <label for="inputImagem">
                        <img class="escondido" src="../imagens/icons/fotoPerfilEditavel.svg" alt="Selecionar imagem de perfil editável">
                    </label>
                    <img id="previewImagem" src="" alt="Pré-visualização da imagem selecionada" style="max-width: 100%; display: none;">
                ';
            } else {
                echo '
                    <input class="padrao" id="imagemUser" type="image" src="'.$imagem.'" name="imagem" alt="Imagem de perfil do utilizador" disabled>
                    <input id="inputImagem" type="file" accept="image/*" name="imagem" style="display: none;">
                    <label for="inputImagem">
                        <img class="escondido" src="../imagens/icons/fotoPerfilEditavel.svg" alt="Selecionar imagem de perfil editável">
                    </label>
                    <img id="previewImagem" src="" alt="Pré-visualização da imagem selecionada" style="max-width: 100%; display: none;">
                ';
            }
        ?>    
            </div>
        <div>

            <div id="nomeUser">
                <input class="edicaoInput" id="nome" type="text" name="nome" value="<?php echo $nome ?>" placeholder="<?php echo $nome ?>" aria-placeholder="Nome" disabled onchange="verificarNome()">
                <input class="edicaoInput" id="apelido" type="text" name="apelido" value="<?php echo $apelido ?>" placeholder="<?php echo $apelido ?>" aria-placeholder="Apelido" disabled onchange="verificarApelido()">

            </div>

        </div>
        </div>
        <div>

            <div>
                <div><input class="edicaoInput" id="dataNascimento" type="date" name="dataNascimento" value="<?php echo $dataNascimento ?>" 
                placeholder="<?php echo $dataNascimento ?>" aria-placeholder="<?php echo $dataNascimento ?>" disabled onchange="verificarDataNascimento()"></div>

            </div>
            <div><input class="edicaoInput" id="email" type="email" name="email" value="<?php echo $email ?>" placeholder="<?php echo $email ?>" aria-label="<?php echo $email ?>" disabled onchange="verificarEmail()"></div>


        </div>
        <div>
            <button class="escondido btns" id="alterarDadosConta" type="submit" disabled><p>Alterar</p></button>
        </form>
            <button class="padrao" id="aparecerEdicao" type="button" onclick="editarDados()"><p>Editar</p></button>
            <a class="escondido btns" href="dadosConta.php" title="Cancelar edição"><button class="btns" id="btnCancelar" type="button"><p>Cancelar</p></button></a>
        </div>

        </div>
    </div>

</main>

<?php include'footerMobile.php'; ?>

</body>
</html>