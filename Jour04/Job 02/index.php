<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple JSON</title>
</head>
<body>
    <h1>Tester la fonction jsonValueKey</h1>
    
    <!-- Formulaire pour entrer la clé -->
    <form id="jsonForm">
        <label for="key">Clé :</label>
        <input type="text" id="key" name="key" required>
        <button type="submit">Trouver la valeur</button>
    </form>
    
    <!-- Zone pour afficher la valeur -->
    <p id="resultat"></p>
    
    <!-- Script JavaScript -->
    <script>
        function jsonValueKey(jsonString, key) {
            try {
                // Convertir la chaîne JSON en objet JavaScript
                const jsonObject = JSON.parse(jsonString);
                
                // Retourner la valeur associée à la clé spécifiée
                return jsonObject[key];
            } catch (error) {
                // Gérer les erreurs de parsing JSON
                console.error('Erreur lors du parsing JSON :', error);
                return null;
            }
        }

        // Exemple de chaîne JSON
        const jsonString = `{
            "name": "La Plateforme_",
            "address": "8 rue d'hozier",
            "city": "Marseille",
            "nb_staff": "11",
            "creation": "2019"
        }`;

        document.getElementById('jsonForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher le rechargement de la page
            
            const key = document.getElementById('key').value;
            const result = jsonValueKey(jsonString, key);
            
            // Afficher le résultat dans le paragraphe
            document.getElementById('resultat').textContent = result !== null ? result : 'Clé non trouvée ou erreur de parsing.';
        });
    </script>
</body>
</html>
