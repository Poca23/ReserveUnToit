import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Script pour le bouton ascenseur qui remonte en haut
document.addEventListener('DOMContentLoaded', () => {
    const elevatorButton = document.getElementById('elevator-button');
    
    if (elevatorButton) {
        // Afficher le bouton après avoir défilé de 200px
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
            // Animation des portes qui s'ouvrent
            elevatorButton.classList.add('animating');
            
            // Son "ding" (optionnel, ajoutez-le si vous le souhaitez)
            // const dingSound = new Audio('/sounds/ding.mp3');
            // dingSound.play();
            
            // Ajouter la classe pour animer l'ascenseur pendant le défilement
            elevatorButton.classList.add('scrolling');
            
            // Animation de défilement fluide vers le haut
            const scrollToTop = () => {
                const currentPosition = document.documentElement.scrollTop || document.body.scrollTop;
                
                if (currentPosition > 0) {
                    window.requestAnimationFrame(scrollToTop);
                    window.scrollTo(0, currentPosition - currentPosition / 15); // Ralenti (diviseur plus grand)
                } else {
                    // Animation d'arrivée
                    elevatorButton.classList.remove('scrolling');
                    elevatorButton.classList.add('arrived');
                    
                    // Fermeture des portes après arrivée
                    setTimeout(() => {
                        elevatorButton.classList.remove('animating', 'arrived');
                    }, 1200); // Plus long pour la fermeture des portes
                }
            };
            
            window.requestAnimationFrame(scrollToTop);
        });
    }
});
