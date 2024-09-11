<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compteur</title>
</head>
<body>

    <button id="button">Cliquez-moi</button>
    <p id="compteur">0</p>

    <script>
        function addone() {
            var compteurElement = document.getElementById("compteur");
            var currentValue = parseInt(compteurElement.textContent);
            compteurElement.textContent = currentValue + 1;
        }

        // Attacher l'événement click au bouton
        document.getElementById("button").addEventListener("click", addone);
    </script>

</body>
</html>
