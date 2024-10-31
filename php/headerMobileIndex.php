<header>
    <nav>
        <img class="imagemLogo" src="imagens/identidadeVisual/logoMobile.png" alt="Logo">

        <div class="nav-items">
            <div class="dropdown_lupa">
                <button onclick="dropLupa()" class="dropbtn_lupa">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <div id="myDropdown_lupa" class="dropdown-contentLupa">
                    <form id="formPesquisa">
                        <input id="pesquisa" name="pesquisa" type="text" placeholder="Pesquisar..." aria-label="Pesquisar...">
                        <div id="results"></div>
                    </form>
                </div>
            </div>

            <div class="carrinho nav-items">
                <a href="php/carrinho.php" title="Meu carrinho">
                    <button class="carrinho-btn" type="button">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count">0</span>
                    </button>
                </a>
            </div>
        </div>
    </nav>
    
</header>
<script type="text/javascript" src="js/header.js"></script>