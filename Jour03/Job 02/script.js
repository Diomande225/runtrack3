document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner les éléments
    const shuffleButton = document.getElementById('shuffleButton');
    const shuffleContainer = document.getElementById('shuffleContainer');
    const orderContainer = document.getElementById('orderContainer');
    const resultMessage = document.getElementById('resultMessage');

    // Liste des bonnes positions des images
    const correctOrder = ['arc1', 'arc2', 'arc3', 'arc4', 'arc5', 'arc6'];

    // Fonction pour mélanger un tableau
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    // Fonction pour mélanger les images
    function shuffleImages() {
        const images = Array.from(document.querySelectorAll('.rainbow-piece'));
        shuffleArray(images);
        shuffleContainer.innerHTML = '';  // Vider le conteneur
        images.forEach(image => shuffleContainer.appendChild(image));  // Réinsérer les images dans l'ordre mélangé
    }

    // Fonction pour vérifier l'ordre des images
    function checkOrder() {
        const placedImages = Array.from(orderContainer.children);
        const placedOrder = placedImages.map(img => img.id);
        
        // Vérifier si l'ordre correspond à correctOrder
        if (JSON.stringify(placedOrder) === JSON.stringify(correctOrder)) {
            resultMessage.textContent = 'Vous avez gagné';
            resultMessage.style.color = 'green';
        } else {
            resultMessage.textContent = 'Vous avez perdu';
            resultMessage.style.color = 'red';
        }
    }

    // Ajouter la fonctionnalité de glisser-déposer
    function enableDragAndDrop() {
        const images = document.querySelectorAll('.rainbow-piece');

        images.forEach(image => {
            image.setAttribute('draggable', true);

            // Début du glisser
            image.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.id);
            });
        });

        // Déposer dans le conteneur d'ordre
        orderContainer.addEventListener('dragover', (e) => {
            e.preventDefault();  // Permet de déposer l'élément
        });

        orderContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            const id = e.dataTransfer.getData('text/plain');
            const draggedElement = document.getElementById(id);
            orderContainer.appendChild(draggedElement);  // Ajouter l'image au conteneur

            // Vérifier l'ordre après chaque dépôt
            if (orderContainer.children.length === correctOrder.length) {
                checkOrder();
            }
        });
    }

    // Mélanger les images lors du clic sur le bouton
    shuffleButton.addEventListener('click', shuffleImages);

    // Activer le glisser-déposer
    enableDragAndDrop();
});
