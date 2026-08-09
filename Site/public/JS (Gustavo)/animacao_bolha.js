document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("bubblesContainer");
    
    // Se por acaso a div ainda não tiver ID no HTML, adicione id="bubblesContainer" nela
    if (!container) return;

    const totalBubbles = 35; // Quantidade de bolhas

    for (let i = 0; i < totalBubbles; i++) {
        const span = document.createElement("span");

        const randomLeft = Math.random() * 100;
        const randomSize = Math.random() * 40 + 10;
        const randomDuration = Math.random() * 4 + 3;
        const randomDelay = Math.random() * 5;

        span.style.left = `${randomLeft}%`;
        span.style.width = `${randomSize}px`;
        span.style.height = `${randomSize}px`;
        span.style.animationDuration = `${randomDuration}s`;
        span.style.animationDelay = `-${randomDelay}s`;

        container.appendChild(span);
    }
});