$(document).ready(function() {
    function loadHeaderFooter() {
        if (window.innerWidth <= 768) { // Limite para considerar mobile
            $("#header").load("headerMobileCarrinho.php");
        } else {
            $("#header").load("headerDesktop.php");
        }
    }

    // Carregar o header e footer ao carregar a página
    loadHeaderFooter();

    // Recarregar o header e footer ao redimensionar a tela
    $(window).resize(function() {
        loadHeaderFooter();
    });
});