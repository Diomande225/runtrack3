$(document).ready(function () {
    // Tableau des images avec la case vide
    const correctOrder = [
        'images/1.PNG',
        'images/2.PNG',
        'images/3.PNG',
        'images/4.PNG',
        'images/5.PNG',
        'images/6.PNG',
        'images/7.PNG',
        'images/8.PNG',
        null // Case vide
    ];

    let currentImages = [...correctOrder]; // Copie des images pour gérer les déplacements

    // Fonction pour générer la grille du jeu
    function createGameBoard() {
        $('#game-container').empty(); // Vider le conteneur avant de le recréer
        currentImages.forEach((imgSrc, index) => {
            let tile = $('<div class="tile"></div>');
            if (imgSrc) {
                let img = $('<img>').attr('src', imgSrc);
                tile.append(img);
            }
            $('#game-container').append(tile);

            // Gestion du clic sur les carreaux
            tile.click(function () {
                moveTile(index);
            });
        });
    }

    // Fonction pour mélanger les images de manière aléatoire
    function shuffleImages() {
        for (let i = currentImages.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [currentImages[i], currentImages[j]] = [currentImages[j], currentImages[i]];
        }
        createGameBoard(); // Mettre à jour la grille après le mélange
    }

    // Fonction pour déplacer un carreau
    function moveTile(index) {
        const emptyIndex = currentImages.indexOf(null);
        const possibleMoves = [emptyIndex - 1, emptyIndex + 1, emptyIndex - 3, emptyIndex + 3];

        if (possibleMoves.includes(index)) {
            [currentImages[emptyIndex], currentImages[index]] = [currentImages[index], currentImages[emptyIndex]];
            createGameBoard(); // Mettre à jour la grille après le mouvement
            checkWin(); // Vérifier si le joueur a gagné
        }
    }

    // Fonction pour vérifier si le joueur a gagné
    function checkWin() {
        if (JSON.stringify(currentImages) === JSON.stringify(correctOrder)) {
            let message = $('<div>Vous avez gagné !</div>').css('color', 'green');
            $('body').append(message);

            // Désactiver les mouvements
            $('.tile').off('click');
        }
    }

    // Fonction pour remettre le jeu en ordre
    function orderGame() {
        currentImages = [...correctOrder]; // Remettre les images dans le bon ordre
        createGameBoard(); // Recréer la grille
    }

    // Mélanger le jeu quand le bouton "Mélanger" est cliqué
    $('#shuffle-button').click(function () {
        shuffleImages();
    });

    // Remettre en ordre quand le bouton "Remettre en ordre" est cliqué
    $('#order-button').click(function () {
        orderGame();
    });

    // Initialisation du jeu au chargement de la page
    orderGame();
});
