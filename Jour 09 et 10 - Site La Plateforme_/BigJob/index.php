<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (is_plateforme_email($email)) {
        $nom = explode('@', $email)[0];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $users = get_json_data($users_json_file);
        
        $new_user = [
            'id' => generate_unique_id(array_column($users, 'id')),
            'nom' => $nom,
            'email' => $email,
            'password' => $hashed_password,
            'role' => 'utilisateur',
            'statut' => 'En attente'
        ];
        $users[] = $new_user;
        
        save_json_data($users_json_file, $users);
        sync_json_to_db($users_json_file, 'users', $pdo);
        
        $register_message = "Inscription réussie ! Votre compte est en attente d'approbation.";
    } else {
        $register_message = "Erreur : L'adresse email doit être du domaine @laplateforme.io";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $users = get_json_data($users_json_file);
    
    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            if ($user['statut'] === 'Approuvé') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['role'] = $user['role'];
                
                if ($_SESSION['role'] === 'administrateur') {
                    header('Location: admin.php');
                } else {
                    header('Location: calendrier.php');
                }
                exit;
            } else {
                $login_message = "Votre compte est en attente d'approbation ou a été refusé.";
            }
        }
    }
    if (!isset($login_message)) {
        $login_message = "Erreur : Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Plateforme_ - Connexion/Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">La Plateforme_</h1>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <h2>Inscription</h2>
                <?php if (isset($register_message)) echo "<p class='alert alert-info'>$register_message</p>"; ?>
                <form method="POST" action="" class="form-container">
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="register_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="register_password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="register_password" name="password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">S'inscrire</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <h2>Connexion</h2>
                <?php if (isset($login_message)) echo "<p class='alert alert-info'>$login_message</p>"; ?>
                <form method="POST" action="" class="form-container">
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="login_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="login_password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="login_password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-success w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>