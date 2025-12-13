document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("cardsContainer");
    if (!slider) return; // Arrête l'exécution si on est pas sur la page FAQ

    const cards = document.querySelectorAll(".info-card");
    let isDown = false;
    let startX;
    let scrollLeft;

    // Animation de zoom sur les cartes
    function animateCards() {
        const centerScreen = window.innerWidth / 2;

        cards.forEach((card) => {
            const rect = card.getBoundingClientRect();
            const cardCenter = rect.left + rect.width / 2;

            // Calcul de la distance par rapport au centre
            const dist = Math.abs(cardCenter - centerScreen);

            // Ajustement de l'échelle et de l'opacité selon la distance
            let scale = 1 - dist / 1500;
            let opacity = 1 - dist / 1500;

            // Limites min/max
            if (scale < 0.9) scale = 0.9;
            if (opacity < 0.6) opacity = 0.6;
            if (scale > 1) scale = 1;

            card.style.transform = `scale(${scale})`;
            card.style.opacity = opacity;
        });

        requestAnimationFrame(animateCards);
    }

    animateCards();

    // Gestion du scroll à la souris (drag)
    slider.addEventListener("mousedown", (e) => {
        isDown = true;
        slider.classList.add("active");
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener("mouseleave", () => {
        isDown = false;
        slider.classList.remove("active");
    });
    slider.addEventListener("mouseup", () => {
        isDown = false;
        slider.classList.remove("active");
    });
    slider.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });
    // Gestion du scroll vertical vs horizontal
    slider.addEventListener("wheel", (evt) => {
        if (evt.deltaY !== 0) {
            const isAtStart = slider.scrollLeft <= 0;
            const isAtEnd =
                Math.ceil(slider.scrollLeft + slider.clientWidth) >=
                slider.scrollWidth;

            // Permet le scroll de la page si on est au début ou à la fin du slider
            if ((evt.deltaY < 0 && isAtStart) || (evt.deltaY > 0 && isAtEnd)) {
                return;
            }

            evt.preventDefault();
            slider.scrollLeft += evt.deltaY;
        }
    });
});
