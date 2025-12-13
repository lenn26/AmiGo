import "./bootstrap";
import "./map";
import "./faq";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Logique de chargement
window.addEventListener("load", function () {
    const loader = document.getElementById("global-loader");
    if (loader) {
        loader.classList.add("opacity-0", "pointer-events-none");
        setTimeout(() => {
            loader.style.display = "none";
        }, 500);
    }
});

// Afficher le chargement lors de la transition de page (clic sur un lien)
document.addEventListener("click", function (e) {
    const link = e.target.closest("a");
    // Vérifie si c'est un lien valide
    if (
        link &&
        link.href &&
        !link.href.startsWith("#") &&
        !link.href.includes("#") &&
        link.target !== "_blank" &&
        link.hostname === window.location.hostname
    ) {
        const loader = document.getElementById("global-loader");
        if (loader) {
            loader.style.display = "flex";
            // Petit délai pour s'assurer que display:flex est appliqué avant de supprimer l'opacité
            requestAnimationFrame(() => {
                loader.classList.remove("opacity-0", "pointer-events-none");
            });
        }
    }
});

// Observateur d'intersection Navbar/Footer
document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("main-navbar");
    const footer = document.getElementById("main-footer");

    if (navbar && footer) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        navbar.classList.add("-translate-y-full");
                    } else {
                        navbar.classList.remove("-translate-y-full");
                    }
                });
            },
            {
                threshold: 0.5,
            }
        );

        observer.observe(footer);
    }
});
