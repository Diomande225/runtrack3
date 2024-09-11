$(document).ready(function () {
    const taquinBoard = $('#taquin-board');
    const winMessage = $('#win-message');
    const restartButton = $('#restart-button');

    // Chemins des images (assurez-vous que ces fichiers existent dans le dossier images/)
    const images = [
        './images/image1.png',
        './images/image2.png',
        './images/image3.png',
        './images/image4.png',
        './images/image5.png',
        './images/image6.png',
        './images/image7.png',
        './images/image8.png',
        null // Case vide
    ];

    let emptyIndex = 8;

    // Mélanger les images
    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    shuffle(images);

    // Création du plateau
    function createBoard() {
        taquinBoard.empty(); // Vider le plateau
        $.each(images, function (index, img) {
            const tile = $('<div></div>').addClass('tile').attr('data-index', index);
            if (img) {
                const imgElement = $('<img>').attr('src', img).attr('data-index', index);
                tile.append(imgElement);
            }
            tile.on('click', moveTile);
            taquinBoard.append(tile);
        });
    }

    // Déplacement des tuiles
    function moveTile() {
        const clickedIndex = parseInt($(this).attr('data-index'));
        const adjacentIndexes = getAdjacentIndexes(emptyIndex);

        if (adjacentIndexes.includes(clickedIndex)) {
            [images[emptyIndex], images[clickedIndex]] = [images[clickedIndex], images[emptyIndex]];
            emptyIndex = clickedIndex;
            createBoard();
            if (checkWin()) {
                winMessage.text("Vous avez gagné !").css("color", "green");
                restartButton.show();
            }
        }
    }

    // Obtenir les indices adjacents
    function getAdjacentIndexes(index) {
        const adjacent = [];
        if (index % 3 !== 0) adjacent.push(index - 1);
        if (index % 3 !== 2) adjacent.push(index + 1);
        if (index - 3 >= 0) adjacent.push(index - 3);
        if (index + 3 < 9) adjacent.push(index + 3);
        return adjacent;
    }

    // Vérification de victoire
    function checkWin() {
        for (let i = 0; i < 8; i++) {
            if (images[i] !== `images/image${i + 1}.png`) {
                return false;
            }
        }
        return true;
    }

    // Recommencer la partie
    restartButton.on('click', function () {
        shuffle(images);
        emptyIndex = images.indexOf(null);
        createBoard();
        winMessage.text('');
        restartButton.hide();
    });

    // Initialiser le plateau
    createBoard();
});
