<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['utilizadorID'])){
    include '../php/conexaobd.php';

    $sql = "SELECT imagem FROM utilizadores WHERE utilizadorID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['utilizadorID']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $imagem = str_replace('../', '', $row['imagem']);
        } 

        mysqli_stmt_close($stmt);
    } 

    mysqli_close($conn);
}

?>

<header id="headerDesktop">

    <nav id="navDesktop">

        <a id="linkImagemLogo" class="nav-item-desktop" href="index.php" title="Ir para página inicial"><img id="imagemLogoDesktop" src="imagens/identidadeVisual/logotipo-pc.png" alt="Logotipo Primessups"></a>
        <div class="nav-item-desktop">
            <div>
                <form id="formPesquisa">
                    <div class="input-container">
                        <i id="lupaDesktop" class="fa-solid fa-magnifying-glass"></i>
                        <input class="inputPesquisa" id="pesquisa" name="pesquisa" type="text" placeholder="Pesquisar..." aria-label="Pesquisar...">
                    </div>
                    <div id="results" class="resultsDesktop"></div>
                </form>
            </div>
        </div>
        <div class="dropdown-ajuda nav-item-desktop">
            <button type="button" class="dropbtn_ajuda" onclick="dropAjuda(event)"><i class='fa-solid fa-headset'></i></button>
            <div id="myDropdownAjuda" class="dropdown-content-ajuda">
                <div class="grid-content">
                    <div class="content" id="content1"><a href="php/enviarMensagem.php" title='Ajuda'><button type="button"><p>Enviar mensagem</p></button></a></div>
                    <div class="content" id="content2"><a href="php/termosCondicoes.php" title="Termos e condições"><button type="button"><p>Termos e condições</p></button></a></div>
                    <div class="content" id="content3"><a href="php/politicaPrivacidade.php" title="Políticas de privacidade"><button type="button"><p>Política de privacidade</p></button></a></div>
                    <div class="content" id="content4"><a href="php/devolucoesTrocas.php" title='Políticas de devoluções e trocas'><button type="button"><p>Devoluções e trocas</p></button></a></div>
                    <div class="content" id="content5"><a href="php/FAQ.php" title='Perguntas frequentes'><button type="button"><p>Perguntas frequentes</p></button></a></div>
                    <div class="content" id="content6"><a href="php/contactos.php" title='Contactar suporte'><button type="button"><p>Contactar</p></button></a></div>
                </div>
            </div> 
        </div>
        <div class="nav-item-desktop dropdown-user">
            <button id="dropBtnUser" type="button" onclick="dropUser(event)"> 
                <?php if(isset($_SESSION['nome'])&&($imagem !== null)){
                echo "<img id='imagemPerfil' src='".str_replace('../', '', $imagem)."' alt='Imagem de perfil'>";}
                else{  echo " <i class='fa-solid fa-user' onclick='dropUser(event)'></i>"; } ?>
                <?php if(isset($_SESSION['nome']) && isset($_SESSION['apelido'])) echo "<p>".$_SESSION['nome'].' '.$_SESSION['apelido']."</p>" ?> 
            </button>
            <div id="myDropdownUser" class="dropdown-content-user">
            <?php

            // verificar se utilizador está logado
            if (!isset($_SESSION['utilizadorID'])) {

                //Sem login
                echo "
                    <div class='content-user-semLogin'>
                        <div class='itens-user-semLogin' id='item-user-semLogin1'>
                                <p id='item-user-semLogin1-1'>Já sou cliente</p>
                                <a href='php/iniciarSessao.php' title='Iniciar sessão'>
                                        <div class='iconesHeader'><p class='p'>Iniciar sessão</p>
                                            <i class='fa-solid fa-right-to-bracket'></i>
                                        </div>
                                </a>
                        </div>

                        <div class='itens-user-semLogin' id='item-user-semLogin2'>
                            <p id='item-user-semLogin1-2'>Ainda não tenho conta</p>
                            <a href='php/criarConta.php' title='Criar conta'>
                            <div class='iconesHeader'>
                            <p class='p'>Criar conta</p><i class='fa-solid fa-plus'></i> 
                            </div></a>
                        </div>

                        <div class='itens-user-semLogin' id='item-user-semLogin3'><h2>Ajuda e informação</h2></div>
                        <div class='itens-user-semLogin linksHeader' id='item-user-semLogin4'>
                            <a href='php/contactos.php' title='Contactar suporte'>
                            <p>Contactos <i class='fa-solid fa-chevron-right'></i></p></a>
                        </div>

                        <div class='itens-user-semLogin linksHeader' id='item-user-semLogin5'>
                            <a href='php/devolucoesTrocas.php' title='Políticas de devoluções e trocas'>
                            <p>Devoluções e trocas <i class='fa-solid fa-chevron-right'></i></p></a>
                        </div>

                        <div class='itens-user-semLogin linksHeader' id='item-user-semLogin6'>
                            <a href='php/sobreNos.php' title='Sobre a Primesupps'>
                            <p>Quem somos <i class='fa-solid fa-chevron-right'></i></p></a>
                        </div>

                        <div class='itens-user-semLogin linksHeader' id='item-user-semLogin7'>
                            <a href='php/subscreverNewsletter.php' title='Subscrever a newsletter'>
                            <p>Subscrever a newsletter <i class='fa-solid fa-chevron-right'></i></p></a>
                        </div>
                    </div>
                ";
            } else 
            if(isset($_SESSION['utilizadorID'])) {

                echo"
                
                    <div class='grid-container-admin-headerDesktop'>
                        <div class='item-Header-desktop1'>";

                //verificar se o utilizador inseriu imagem de perfil 
                if ($imagem === NULL) {

                    //Sem imagem
                    echo "<div class='nomeHeaderDesktop'><i class='fa-solid fa-circle-user'></i>";
                } else {

                    //Com imagem
                    echo "<div class='nomeHeaderDesktop'><img id='imagemPerfilDrop' src='" .str_replace('../', '', $imagem). "' alt='Imagem de perfil do utilizador'>";
                }

                echo "<h3>Olá, " . htmlspecialchars($_SESSION['nome']) . "</h3></div>
                        <div><a class='linkLogoutHeaderDesktop' href='php/logout.php' title='Encerrar sessão'><p>Logout <i class='fa-solid fa-right-from-bracket'></i></p></a></div>
                    </div>";

                    //verificar se é um administrador
                    if (isset($_SESSION['funcao']) && $_SESSION['funcao'] == 'administrador'){
                        echo "
                            <div class='item-Header-desktop-admin'>";
                            if(!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']){
                                echo"<a class='linkHeaderDesktopAdmin' href='php/gerarCodigoAcessoAdministrador.php' 
                                title='Página de administrador'><p><i class='fa-solid fa-user-tie'></i> Ir para área de administrador</p></a>";
                            }
                                else{
                                    echo"<a class='linkHeaderDesktopAdmin' href='php/areaAdministrador.php' 
                                title='Página de administrador'><p><i class='fa-solid fa-user-tie'></i> Ir para área de administrador</p></a>";
                                }
                               echo "</div>";
                    }
                    
                    echo "<div class='item-Header-desktop2'>
                            <div><h2>A minha conta</h2></div>
                            <div class='item-headerDesktop'><a class='linksHeaderDesktop' href='php/alterarPassword.php' title='Alterar password'><p>Alterar password</p> <i class='fa-solid fa-chevron-right'></i></a></div>
                            <div class='item-headerDesktop'><a class='linksHeaderDesktop' href='php/criarComentario.php' title='Criar comentário'><p>Escrever comentário</p> <i class='fa-solid fa-chevron-right'></i></a></div>
                            <div class='item-headerDesktop'><a class='linksHeaderDesktop' href='php/gerirDadosContaDesktop.php' title='Gerir minha conta'><p>Gerir a minha conta</p> <i class='fa-solid fa-chevron-right'></i></a></div>

                        </div>

                    <div class='item-Header-desktop3'>
                    
                        <div><h2>As minhas encomendas</h2></div>
                        <div class='item-headerDesktop'>
                            <a class='linksHeaderDesktop' href='php/encomendasDesktop.php' title='Encomendas realizadas'><p>Gerir as minhas encomendas</p> <i class='fa-solid fa-chevron-right'></i></a>
                        </div>

                    </div>

                    <div class='item-Header-desktop4'>
                        <h2>Ajuda e informação</h2>
                        <div class='item-headerDesktop'><a class='linksHeaderDesktop' href='php/contactos.php' title='Contactar suporte'><p>Contactos</p> <i class='fa-solid fa-chevron-right'></i></a></div>
                        <div class='item-headerDesktop'><a class='linksHeaderDesktop' href='php/devolucoesTrocas.php' title='Políticas de devoluções e trocas'><p>Devoluções e trocas</p> <i class='fa-solid fa-chevron-right'></i></a></div>
                        <div class='item-headerDesktop'><a class='linksHeaderDesktop' href='php/sobreNos.php' title='Sobre a Primesupps'><p>Quem somos</p> <i class='fa-solid fa-chevron-right'></i></a></div>
                    </div>
                    </div>
                ";
        }

            ?>
            </div>
    </div>
        <div class="carrinhoDesktop nav-item-desktop">
                <a href="php/carrinho.php" title="Meu carrinho">
                    <button class="carrinho-btn-desktop" type="button">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count" id="cart-countDesktop">0</span>
                    </button>
                </a>
            </div> 

            <div class="produtosDestaque-headerDesktop">
                <a href="php/produtosDestaque.php " title="Produtos em destaque">
                    <button class="elementos" type="button">
                    <img src="imagens/icons/destaque.svg" alt="Ícone dos produtos em destaque"></button>
                </a>
            </div>

    
            <div class="categoriasBtnDesktop">
                <a href="php/vitaminasMinerais.php" title="Página de vitaminas e minerais"><button class="btnCategorias" id="bordaBtnCategoriaHeader1" type="button"><p>Vitaminas e minerais</p></button></a>
                <a href="php/emagrecimento.php" title="Página de Emagrecimento"><button class="btnCategorias" id="bordaBtnCategoriaHeader" type="button"><p>Emagrecimento</p></button></a>
                <a href="php/proteinas.php" title="Página de Proteínas"><button class="btnCategorias" id="bordaBtnCategoriaHeader3" type="button"><p>Proteínas</p></button></a>   
                <a href="php/aminoacidos.php" title="Página de Aminoácidos"><button class="btnCategorias" id="bordaBtnCategoriaHeader4" type="button"><p>Aminoácidos</p></button></a>
                <a href="php/preEposTreino.php" title="Página de Pré-treino e pós-treino"><button class="btnCategorias" id="bordaBtnCategoriaHeader5" type="button"><p>Pré-treino e pós-treino</p></button></a>
                <a href="php/outrosSuplementos.php" title="Página de Outros suplementos"><button class="btnCategorias" id="bordaBtnCategoriaHeader2" type="button"><p>Outros suplementos</p></button></a>
            </div>
    </nav>
</header>
<script type="text/javascript" src="js/header.js"></script>