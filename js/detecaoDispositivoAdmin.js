$(document).ready(function() {
    function loadHeaderFooter() {
        if ($(window).width() <= 768 ) { // Limite para considerar mobile
            $("#header").load("headerMobile.php");
            $("#main").load("mainAreaAdministrador.php");
            $("#footer").load("footerMobile.php");
        } else if($(window).width()){
            $("#header").load("headerDesktop.php");
            $("#main").load("mainAreaAdministradorDesktop.php");
            $("#footer").load("footerDesktop.php");
        }
    }

    // Carregar o header e footer ao carregar a página
    loadHeaderFooter();

    // Recarregar o header e footer ao redimensionar a tela
    $(window).resize(function() {
        loadHeaderFooter();
    });
});