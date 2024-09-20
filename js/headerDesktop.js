// Função para fechar todos os dropdowns
function closeAllDropdowns() {
    var dropdowns = document.querySelectorAll('.dropdown-content-ajuda, .dropdown-content-user');
    dropdowns.forEach(function(dropdown) {
        dropdown.classList.remove('showAjuda1', 'showUser');
    });
}

// Função para alternar o dropdown
function toggleDropdown(dropdownId, className, event) {
    event.stopPropagation(); 
    var dropdown = document.getElementById(dropdownId);
    var isOpen = dropdown.classList.contains(className);

    // Fechar todos os dropdowns antes de abrir o desejado
    closeAllDropdowns();

    // Se o dropdown não estava aberto, abra-o
    if (!isOpen) {
        dropdown.classList.add(className);
    }
}

// Event handler para o dropdown de Ajuda
function dropAjuda(event) {
    toggleDropdown("myDropdownAjuda", "showAjuda1", event);
}

// Event handler para o dropdown do Usuário
function dropUser(event) {
    toggleDropdown("myDropdownUser", "showUser", event);
}

// Listener de clique para fechar os dropdowns se clicar fora deles
document.addEventListener('click', function(event) {
    var dropdownAjuda = document.getElementById("myDropdownAjuda");
    var buttonAjuda = document.querySelector('.dropbtn_ajuda');

    if (dropdownAjuda.classList.contains('showAjuda1') && 
        !buttonAjuda.contains(event.target) && 
        !dropdownAjuda.contains(event.target)) {
        dropdownAjuda.classList.remove('showAjuda1');
    }

    var dropdownUser = document.getElementById("myDropdownUser");
    var buttonUser = document.querySelector('#dropBtnUser');

    if (dropdownUser.classList.contains('showUser') && 
        !buttonUser.contains(event.target) && 
        !dropdownUser.contains(event.target)) {
        dropdownUser.classList.remove('showUser');
    }
});