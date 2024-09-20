const startConfetti = () => {
    setTimeout(function() {
        // Exibe confetti caindo do topo para o final
        confetti({
            particleCount: 2000,     // Quantidade de partículas
            spread: 600,             // Espalhamento das partículas
            origin: { y: 0 },       // Posição de origem no topo (y = 0)
            angle: 90,              // Direção das partículas (90 graus = para baixo)
            gravity: 1,             // Aumenta a gravidade para cair mais rápido
            ticks: 10000              // Controla a duração do movimento de queda
        });

        // Para o confetti após 4 segundos
        setTimeout(function() {
            confetti.reset(); // Reseta o efeito de confetti
        }, 10000);

    }, 1000); // Inicia o confetti após 1 segundo
};

// Chama a função startConfetti quando a página é carregada
window.onload = startConfetti;