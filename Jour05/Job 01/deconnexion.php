<?php
session_start(); // Démarrer la session
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnecté</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation pour les liens
            $("a").hide().slideDown(1000);
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Vous êtes déconnecté</h1>
        <!-- Liens pour se connecter ou s'inscrire -->
        <a href="connexion.php" class="btn">Se connecter</a>
        <a href="inscription.php" class="btn">S'inscrire</a>
    </div>
</body>
</html>