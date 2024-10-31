$(document).ready(function() {
    function loadHeaderFooter() {
        if ($(window).width() <= 768 ) { // Limite para considerar mobile
            $("#header").load("php/headerMobileIndex.php");
            $("#footer").load("php/footerMobileIndex.php");
        } else if($(window).width()){
            $("#header").load("php/headerDesktopIndex.php");
            $("#footer").load("php/footerDesktopIndex.php");
        }
    }

    // Carregar o header e footer ao carregar a página
    loadHeaderFooter();

    // Recarregar o header e footer ao redimensionar a tela
    $(window).resize(function() {
        loadHeaderFooter();
    });
});