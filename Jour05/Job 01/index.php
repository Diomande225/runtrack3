<?php
session_start(); // Démarrer la session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation pour le message de bienvenue
            $("p").hide().fadeIn(2000);
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Accueil</h1>
        <?php if (isset($_SESSION['prenom'])): ?>
            <!-- Afficher un message de bienvenue si l'utilisateur est connecté -->
            <p>Bonjour <?php echo htmlspecialchars($_SESSION['prenom']); ?></p>
            <a href="connexion.php" class="btn">Retourner à la page de connexion</a>
            <!-- Formulaire pour se déconnecter -->
            <form method="POST" action="deconnexion.php">
                <button type="submit" class="btn">Se déconnecter</button>
            </form>
        <?php else: ?>
            <!-- Afficher les liens d'inscription et de connexion si l'utilisateur n'est pas connecté -->
            <a href="inscription.php" class="btn">Inscription</a>
            <a href="connexion.php" class="btn">Connexion</a>
        <?php endif; ?>
    </div>
</body>
</html>