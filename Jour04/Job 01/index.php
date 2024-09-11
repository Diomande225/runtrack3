<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage de l'expression</title>
</head>
<body>
    <button id="button">Afficher l'expression</button>
    <p id="expression"></p>

    <script>
        document.getElementById('button').addEventListener('click', function() {
            fetch('expression.txt')
                .then(response => response.text())
                .then(text => {
                    document.getElementById('expression').textContent = text;
                })
                .catch(error => console.error('Erreur lors de la récupération du fichier :', error));
        });
    </script>
</body>
</html>
