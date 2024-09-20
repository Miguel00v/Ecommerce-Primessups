function mostrarCaixaMBWAY() {
    var caixaMBWAY = document.getElementById("caixaMBWAY");
    var caixaCardCredit = document.getElementById("caixaCardCredit");
    
    if (caixaCardCredit.style.display === 'block') {
        caixaCardCredit.style.display = 'none';
    }
    
    if (caixaMBWAY.style.display === 'block') {
        caixaMBWAY.style.display = 'none';
    } else {
        caixaMBWAY.style.display = 'block';
    }
}

function mostrarcaixaCardCredit() {
    var caixaCardCredit = document.getElementById("caixaCardCredit");
    var caixaMBWAY = document.getElementById("caixaMBWAY");
    
    if (caixaMBWAY.style.display === 'block') {
        caixaMBWAY.style.display = 'none';
    }
    
    if (caixaCardCredit.style.display === 'block') {
        caixaCardCredit.style.display = 'none';
    } else {
        caixaCardCredit.style.display = 'block';
    }
}

function changeCardIcon() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    const iconElement = document.getElementById('iconCard').querySelector('i');
    const formElements = document.getElementsByClassName('formularioInsercao');

    for (let element of formElements) {
        element.style.display = 'block';
    }

    if (paymentMethod === 'americanExpress') {
        iconElement.className = 'fa-brands fa-cc-amex';
    } else if (paymentMethod === 'visa') {
        iconElement.className = 'fa-brands fa-cc-visa';
    } else if (paymentMethod === 'mastercard') {
        iconElement.className = 'fa-brands fa-cc-mastercard';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var stripe = Stripe('pk_test_51PfikOJGkzLnsntVCWwNLvlV4YxOjgvr30vIN1VkLPnAmbRPkvCBA2RpWGnlAyn75Pc3cRhB3ZPCvb5ClKMw5ESE006rxOywRf'); 
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Exiba o erro ao usuário
                console.error(result.error.message);
                alert(result.error.message);
            } else {
                // Crie um input oculto para enviar o token ao servidor
                var tokenInput = document.createElement('input');
                tokenInput.setAttribute('type', 'hidden');
                tokenInput.setAttribute('name', 'stripeToken');
                tokenInput.setAttribute('value', result.token.id);
                form.appendChild(tokenInput);

                // Envie o formulário
                form.submit();
            }
        });
    });
});