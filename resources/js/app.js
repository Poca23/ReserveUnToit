import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Script pour le bouton ascenseur qui remonte en haut
document.addEventListener('DOMContentLoaded', () => {
    const elevatorButton = document.getElementById('elevator-button');
    
    if (elevatorButton) {
        // Afficher le bouton après avoir défilé de 500px
        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                elevatorButton.classList.remove('hidden');
                elevatorButton.classList.add('visible');
            } else {
                elevatorButton.classList.remove('visible');
                elevatorButton.classList.add('hidden');
            }
        });
        
        // Animation ascenseur et défilement vers le haut
        elevatorButton.addEventListener('click', () => {
            elevatorButton.classList.add('animating');
            elevatorButton.classList.add('scrolling');
            
            // Animation de défilement fluide vers le haut
            const scrollToTop = () => {
                const currentPosition = document.documentElement.scrollTop || document.body.scrollTop;
                
                if (currentPosition > 5) {
                    const newPosition = currentPosition - Math.max(currentPosition / 15, 1);
                    window.scrollTo(0, newPosition);
                    window.requestAnimationFrame(scrollToTop);
                } else {
                    // Force la position exacte à 0
                    window.scrollTo(0, 0);
                    
                    // Animation d'arrivée
                    elevatorButton.classList.remove('scrolling');
                    elevatorButton.classList.add('arrived');
                    
                    setTimeout(() => {
                        elevatorButton.classList.remove('animating', 'arrived');
                    }, 1200);
                }
            };
            
            window.requestAnimationFrame(scrollToTop);
        });
    }
});
