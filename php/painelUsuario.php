<?php

    session_start();
    include 'conexaobd.php';

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Painel de utilizador</title>
    <meta name="description" content="Acesse e gerencie suas informações de conta, configurações, pedidos e preferências pessoais no painel de utilizador do PrimeSupps. Mantenha sua conta atualizada e tenha controle total sobre suas compras e dados pessoais.">
    <meta name="keywords" content="painel de utilizador, gerenciamento de conta, configurações de conta, histórico de pedidos, preferências pessoais, PrimeSupps">
     <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/painelUsuario.css">
</head>
<body>

    <?php include'headerMobile.php'; ?>

    <?php

        // verificar se utilizador está logado
        if (!isset($_SESSION['utilizadorID'])) {

            //Sem login
            echo "
            <main class='mainComLogin'>
                <div id='inciarSessaoDiv'>
                    <div><h2>Já sou cliente</h2></div>
                    <div><a class='iniciarSessaoBtn' href='iniciarSessao.php' title='Iniciar sessão'><p>Iniciar sessão</p><i class='fa-solid fa-right-to-bracket'></i></a></div>
                </div>

                <div id='criarContaDiv'>
                    <div><h2>Ainda não tenho conta</h2></div>
                    <div>
                        <a class='iniciarSessaoBtn' href='criarConta.php' title='Criar conta'>
                        <p>Criar conta</p>
                        <i class='fa-solid fa-plus'></i>
                        </a>
                    </div>
                </div>

                <div class='flexCubos'>
                    <div id='FAQ'><a href='FAQ.php' title='Perguntas frequentes'><i class='fa-solid fa-question'></i></a></div>
                    <div id='headset'><a href='ajuda.php' title='Ajuda'><i class='fa-solid fa-headset'></i></a></div>
                </div>

                <div>
                    <h2>Ajuda e informação</h2>
                    <a class='flexContainer' href='contactos.php' title='Contactar suporte'>
                        <div><p>Contactos</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='devolucoesTrocas.php' title='Políticas de devoluções e trocas'>
                    <div><p>Devoluções e trocas</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='sobreNos.php' title='Sobre a Primesupps'>
                    <div><p>Quem somos</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>

                    <a class='flexContainer' href='subscreverNewsletter.php' title='Subscrever a newsletter'>
                    <div><p>Subscrever a newsletter</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                </div>
            </main>";
        } else 
        if($_SESSION['funcao']=='utilizador') {

            //Com login
            echo "
            <main class='mainComLogin'>
                <div id='saudacaoUser'>
                    <div id='dadosUser'>";

            //verificar se o utilizador inseriu imagem de perfil 
            if ($_SESSION['imagem'] === NULL) {

                //Sem imagem
                echo "<i class='fa-solid fa-circle-user'></i>";
            } else {

                //Com imagem
                echo "<img class='imagemLogin' src='" . htmlspecialchars($_SESSION['imagem']) . "' alt='Imagem de perfil do utilizador'>";
            }

            echo "<h3 id='nomeUser'>Olá, " . htmlspecialchars($_SESSION['nome']) . "</h3>
                    </div>
                    <div class='logoutDiv'><a href='logout.php' title='Encerrar sessão'><p>Logout</p><i class='fa-solid fa-right-from-bracket'></i></a></div>
                </div>

                <div class='flexCubos'>

                    <div id='comentario'><div><a href='criarComentario.php' title='Criar comentário'><h1>Escrever comentário</h1></a></div></div>
                    <div id='suporte'><div><a href='ajuda.php' title='Ajuda'><i class='fa-solid fa-headset'></i></a></div></div>

                </div>

                <div>
                
                    <div><h2>A minha conta</h2></div>
                    <div>
                        <a class='flexContainer' href='alterarPassword.php' title='Alterar password'>
                        <div><p>Alterar password</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                        </a>
                        <a class='flexContainer' href='gerirMinhaConta.php' title='Gerir dados da conta'>
                        <div><p>Gerir a minha conta</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                        </a>
                    </div>

                </div>

                <div>
                
                    <div><h2>As minhas encomendas</h2></div>
                    <div>
                        <a class='flexContainer' href='encomendas.php' title='Encomendas realizadas'>
                        <div><p>Gerir as minhas encomendas</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                        </a>
                    </div>

                </div>

                <div>

                    <h2>Ajuda e informação</h2>
                    <a class='flexContainer' href='contactos.php' title='Contactar suporte'>
                        <div><p>Contactos</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='devolucoesTrocas.php' title='Políticas de devoluções e trocas'>
                    <div><p>Devoluções e trocas</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='sobreNos.php' title='Sobre a Primesupps'>
                    <div><p>Quem somos</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='subscreverNewsletter.php' title='Subscrever a newsletter'>
                    <div><p>Subscrever a newsletter</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                
                </div>
            </main>";
        }

        //verificar se é um administrador
        if (isset($_SESSION['funcao']) && $_SESSION['funcao'] == 'administrador'){

            echo"
            
            <main class='mainComLogin'>
                <div id='adminDiv'>
                    <div id='saudacaoDiv'>";

            //verificar se o utilizador inseriu imagem de perfil 
            if ($_SESSION['imagem'] === NULL) {

                //Sem imagem
                echo "<i class='fa-solid fa-circle-user'></i>";
            } else {

                //Com imagem
                echo "<img class='imagemLogin' src='" . htmlspecialchars($_SESSION['imagem']) . "' alt='Imagem de perfil do utilizador'>";
            }

            echo "<h3 id='nomeUserAdmin'>Olá, " . htmlspecialchars($_SESSION['nome']) . "</h3>
                    </div>
                    <div class='logoutDiv'><a href='logout.php' title='Encerrar sessão'><p>Logout</p><i class='fa-solid fa-right-from-bracket'></i></a></div>
                </div>

                <div class='flexCubos'>

                    <div id='comentarioCubo'><a href='criarComentario.php' title='Criar comentário'><h1>Escrever comentário</h1></a></div>
                    <div id='heasetCubo'><a href='ajuda.php' title='Ajuda'><i class='fa-solid fa-headset'></i></a></div>
                    <div id='areaAdmin'>";
                    if(!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']){
                        echo"<a href='gerarCodigoAcessoAdministrador.php' title='Página de administrador'><i class='fa-solid fa-user-tie'></i></a>";
                    }
                        else{
                            echo"<a href='areaAdministrador.php' title='Página de administrador'><i class='fa-solid fa-user-tie'></i></a>";
                        }
                   echo"</div>

                </div>

                <div>
                
                    <div><h2>A minha conta</h2></div>
                    <div> 
                        <a class='flexContainer' href='alterarPassword.php' title='Alterar password'>
                        <div><p>Alterar password</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                        </a>
                        <a class='flexContainer' href='gerirMinhaConta.php' title='Gerir dados da conta'>
                        <div><p>Gerir a minha conta</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                        </a>
                    </div>

                </div>

                <div>
                
                    <div><h2>As minhas encomendas</h2></div>
                    <div>
                        <a class='flexContainer' href='encomendas.php' title='Encomendas realizadas'>
                        <div><p>Gerir as minhas encomendas</p></div>
                        <div><i class='fa-solid fa-chevron-right'></i></div>
                        </a>
                    </div>

                </div>

                <div>

                    <h2>Ajuda e informação</h2>
                    <a class='flexContainer' href='contactos.php' title='Contactar suporte'>
                    <div><p>Contactos</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='devolucoesTrocas.php' title='Políticas de devoluções e trocas'>
                    <div><p>Devoluções e trocas</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='sobreNos.php' title='Sobre a Primesupps'>
                    <div><p>Quem somos</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                    <a class='flexContainer' href='subscreverNewsletter.php' title='Subscrever a newsletter'>
                    <div><p>Subscrever a newsletter</p></div>
                    <div><i class='fa-solid fa-chevron-right'></i></div>
                    </a>
                
                </div>
            </main>";

        }

        include'footerMobile.php';

?>


</body>
</html>