<?php
session_start(); // Démarrer la session
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "utilisateurs_v2";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête pour vérifier les informations de connexion
    $stmt = $conn->prepare("SELECT id, prenom, password FROM utilisateurs_v2 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $prenom, $hashedPassword);
    $stmt->fetch();

    // Vérifier si les informations de connexion sont correctes
    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        $_SESSION['id'] = $id;
        $_SESSION['prenom'] = $prenom;
        header("Location: index.php"); // Rediriger vers la page d'accueil
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation pour le formulaire de connexion
            $("form").hide().fadeIn(1000);

            // Animation pour les messages d'erreur
            $("span").hide();

            // Fonction de validation du formulaire
            function validateForm() {
                let valid = true;
                const email = $("#email").val();
                const password = $("#password").val();

                // Vérifier le format de l'email
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $("#emailError").text("Format de l'email incorrect").fadeIn();
                    valid = false;
                } else {
                    $("#emailError").fadeOut();
                }

                // Vérifier la longueur du mot de passe
                if (password.length < 8) {
                    $("#passwordError").text("Le mot de passe doit contenir au moins 8 caractères").fadeIn();
                    valid = false;
                } else {
                    $("#passwordError").fadeOut();
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
        <h1>Connexion</h1>
        <?php if (isset($_SESSION['prenom'])): ?>
            <!-- Afficher un message si l'utilisateur est déjà connecté -->
            <p>Vous êtes déjà connecté. <a href="index.php">Retourner à l'accueil</a></p>
        <?php else: ?>
            <!-- Formulaire de connexion -->
            <form method="POST">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <span id="emailError" style="color:red;"></span><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <span id="passwordError" style="color:red;"></span><br>

                <button type="submit" class="btn">Se connecter</button>
            </form>
            <?php if (isset($error)): ?>
                <!-- Afficher un message d'erreur si les informations de connexion sont incorrectes -->
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>