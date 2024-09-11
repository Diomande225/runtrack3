<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher / Masquer Article</title>
    <style>
        #article-container {
            display: none;
        }
    </style>
</head>
<body>

    <button id="button" onclick="showhide()">Afficher / Masquer l'article</button>

    <div id="article-container">
        <article>
            L'important n'est pas la chute, mais l'atterrissage.
        </article>
    </div>

    <script>
        function showhide() {
            var container = document.getElementById("article-container");
            if (container.style.display === "none" || container.style.display === "") {
                container.style.display = "block";
            } else {
                container.style.display = "none";
            }
        }
    </script>

</body>
</html>
