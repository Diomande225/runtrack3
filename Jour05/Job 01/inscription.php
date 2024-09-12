<?php
session_start(); // Démarrer la session
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "utilisateurs_v2";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Préparer et exécuter la requête pour insérer un nouvel utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateurs_v2 (prenom, nom, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $prenom, $nom, $email, $password);

    if ($stmt->execute()) {
        header("Location: connexion.php"); // Rediriger vers la page de connexion
        exit();
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation pour le formulaire d'inscription
            $("form").hide().fadeIn(1000);

            // Animation pour les messages d'erreur
            $("span").hide();

            // Fonction de validation du formulaire
            function validateForm() {
                let valid = true;
                const prenom = $("#prenom").val();
                const nom = $("#nom").val();
                const email = $("#email").val();
                const password = $("#password").val();
                const confirmPassword = $("#confirmPassword").val();

                // Vérifier la longueur du prénom
                if (prenom.length < 3) {
                    $("#prenomError").text("La taille de votre prénom est trop petite").fadeIn();
                    valid = false;
                } else {
                    $("#prenomError").fadeOut();
                }

                // Vérifier la longueur du nom
                if (nom.length < 3) {
                    $("#nomError").text("La taille de votre nom est trop petite").fadeIn();
                    valid = false;
                } else {
                    $("#nomError").fadeOut();
                }

                // Vérifier le format de l'email
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $("#emailError").text("Format de l'email incorrect").fadeIn();
                    valid = false;
                } else {
                    $("#emailError").fadeOut();
                }

                // Vérifier la complexité du mot de passe
                if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[!@#$%^&*]/.test(password)) {
                    $("#passwordError").text("Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial").fadeIn();
                    valid = false;
                } else {
                    $("#passwordError").fadeOut();
                }

                // Vérifier que les mots de passe correspondent
                if (password !== confirmPassword) {
                    $("#confirmPasswordError").text("Les mots de passe ne correspondent pas").fadeIn();
                    valid = false;
                } else {
                    $("#confirmPasswordError").fadeOut();
                }

                return valid;
            }

            // Attacher la fonction de validation au formulaire
            $("form").on("submit", function() {
                return validateForm();
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <?php if (isset($_SESSION['prenom'])): ?>
            <!-- Afficher un message si l'utilisateur est déjà connecté -->
            <p>Vous êtes déjà connecté. <a href="index.php">Retourner à l'accueil</a></p>
        <?php else: ?>
            <!-- Formulaire d'inscription -->
            <form method="POST">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
                <span id="prenomError" style="color:red;"></span><br>

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
                <span id="nomError" style="color:red;"></span><br>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <span id="emailError" style="color:red;"></span><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <span id="passwordError" style="color:red;"></span><br>

                <label for="confirmPassword">Confirmation du mot de passe :</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <span id="confirmPasswordError" style="color:red;"></span><br>

                <button type="submit" class="btn">S'inscrire</button>
            </form>
            <?php if (isset($error)): ?>
                <!-- Afficher un message d'erreur si l'inscription échoue -->
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>