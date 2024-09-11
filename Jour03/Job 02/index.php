<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de l'Arc-en-ciel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Reconstituez l'arc-en-ciel</h1>
    
    <!-- Conteneur pour les images mélangées -->
    <div id="shuffleContainer">
        <img src="images/arc1.png" id="arc1" class="rainbow-piece" alt="Arc 1">
        <img src="images/arc2.png" id="arc2" class="rainbow-piece" alt="Arc 2">
        <img src="images/arc3.png" id="arc3" class="rainbow-piece" alt="Arc 3">
        <img src="images/arc4.png" id="arc4" class="rainbow-piece" alt="Arc 4">
        <img src="images/arc5.png" id="arc5" class="rainbow-piece" alt="Arc 5">
        <img src="images/arc6.png" id="arc6" class="rainbow-piece" alt="Arc 6">
    </div>

    <!-- Bouton pour mélanger les images -->
    <button id="shuffleButton">Mélanger les images</button>

    <!-- Conteneur pour réarranger les images -->
    <div id="orderContainer"></div>

    <!-- Message de résultat -->
    <p id="resultMessage"></p>

    <script src="script.js"></script>

</body>
</html>
