function updateCartCount() {
    $.ajax({
        url: 'php/cartCount.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.cartCount !== undefined) {
                var cartCount = parseInt(response.cartCount, 10);

                if (cartCount > 0) {
                    document.querySelector('.cart-count').style.display = 'block';
                    document.querySelector('.cart-count').textContent = cartCount;
                } else {
                    document.querySelector('.cart-count').style.display = 'none';
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao atualizar o contador do carrinho:', error);
        }
    });
}
 updateCartCount();
setInterval(updateCartCount, 5000);