<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citation</title>
</head>
<body>

    <article id="citation">
        "La vie a beaucoup plus d’imagination que nous".
    </article>

    <button id="button" onclick="citation()">Afficher la citation</button>

    <script>
        function citation() {
            var texte = document.getElementById("citation").textContent;
            console.log(texte);
        }
    </script>

</body>
</html>
