<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keylogger</title>
    <style>
        #keylogger {
            width: 300px;
            height: 150px;
        }
    </style>
</head>
<body>

    <textarea id="keylogger" placeholder="Tapez ici ou ailleurs..."></textarea>

    <script>
        // Fonction pour ajouter une lettre au textarea
        function addLetter(letter) {
            var textarea = document.getElementById("keylogger");
            var currentContent = textarea.value;
            if (document.activeElement === textarea) {
                // Si le focus est dans le textarea, ajouter la lettre deux fois
                textarea.value = currentContent + letter + letter;
            } else {
                // Sinon, ajouter la lettre une fois
                textarea.value = currentContent + letter;
            }
        }

        // Écouter les événements de touche
        document.addEventListener("keydown", function(event) {
            var key = event.key.toLowerCase();
            // Ajouter la lettre si elle est une lettre de a à z
            if (key >= 'a' && key <= 'z') {
                addLetter(key);
            }
        });
    </script>

</body>
</html>
