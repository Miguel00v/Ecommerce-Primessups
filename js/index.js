let slideIndex = 1;
let slideInterval;

showSlides(slideIndex);

// Função para avançar ou retroceder os slides
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Função para definir o slide atual
function currentSlide(n) {
    showSlides(slideIndex = n);
}

// Função para mostrar o slide atual
function showSlides(n) {
    let i;
    const slides = document.getElementsByClassName("mySlides");
    const dots = document.getElementsByClassName("dot");

    // Validar se os slides e pontos existem
    if (slides.length === 0) {
        console.error('Nenhum slide encontrado.');
        return;
    }

    if (dots.length === 0) {
        console.error('Nenhum ponto encontrado.');
        return;
    }

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; // Esconde todos os slides
        slides[i].style.animation = ""; // Remove a animação anterior
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", ""); // Remove a classe ativa de todos os pontos
    }

    slides[slideIndex - 1].style.display = "block"; // Exibe o slide atual
    slides[slideIndex - 1].style.animation = "slide3d 1.5s forwards"; // Aplica a animação 3D
    dots[slideIndex - 1].className += " active"; // Marca o ponto atual como ativo

    // Limpa o intervalo existente antes de definir um novo
    if (slideInterval) {
        clearInterval(slideInterval);
    }

    slideInterval = setInterval(() => {
        plusSlides(1); // Avança para o próximo slide a cada 5 segundos
    }, 5000);
}
//Fim slide banner

//Slide2
let slideIndex2 = 1;
let slideInterval2;

function plusSlides2(n) {
    showSlides2(slideIndex2 += n);
}

function currentSlide2(n) {
    showSlides2(slideIndex2 = n);
}

function showSlides2(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides2");
    let dots = document.getElementsByClassName("dot2");

    if (n > slides.length) { slideIndex2 = 1; }
    if (n < 1) { slideIndex2 = slides.length; }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; 
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex2 - 1].style.display = "block"; 
    dots[slideIndex2 - 1].className += " active"; 

    if (slideInterval2) {
        clearInterval(slideInterval2);
    }
    slideInterval2 = setInterval(() => {
        plusSlides2(1);
    }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
    showSlides2(slideIndex2);
});
//Fim slide2