$(document).ready(function() {
    function loadHeaderFooter() {
        if (window.innerWidth <= 768) {
            $('body').prepend(`
                <header>
                    <nav id='navMobile1'>
                            <div>
                                <div>
                                    <div><a href="<?php echo htmlspecialchars($anteriorURL); ?>" title="Ir para página anterior"><i class="fa-solid fa-angle-left"></i></a></div>
                                    <div><h1>Criar conta</h1></div>
                                </div>
                                <div><i class="fa-solid fa-x"></i></div>
                            </div>
                    </nav>
                </header>
            `);
        } else {
            $('body').prepend(`<?php include 'headerDesktop.php'; ?>`);
        }
    }
    function adjustMainPadding() {
                const headerHeight = $('header').outerHeight();
                $('#mainCriarconta').css('padding-top', headerHeight + 'px');
            }

    loadHeaderFooter();
    adjustMainPadding();

    $(window).resize(function() {
        $('header').remove();
        loadHeaderFooter();
    });
});