<?php
session_start();
require_once 'config.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Traitement de la nouvelle demande de présence
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_demande'])) {
    $date_presence = $_POST['date_presence'];
    
    $demandes = get_json_data($demandes_json_file);
    
    $new_demande = [
        'id' => generate_unique_id(array_column($demandes, 'id')),
        'user_id' => $_SESSION['user_id'],
        'date_presence' => $date_presence,
        'date_demande' => date('Y-m-d'),
        'statut' => 'En attente'
    ];
    
    $demandes[] = $new_demande;
    
    save_json_data($demandes_json_file, $demandes);
    sync_json_to_db($demandes_json_file, 'demandes', $pdo);
    
    $demande_message = "Votre demande de présence a été enregistrée et est en attente d'approbation.";
}

// Récupérer les demandes de l'utilisateur
$demandes = get_json_data($demandes_json_file);
$user_demandes = array_filter($demandes, function($demande) {
    return $demande['user_id'] == $_SESSION['user_id'];
});

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier - La Plateforme_</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Calendrier de <?php echo htmlspecialchars($_SESSION['nom']); ?></h1>
        <?php if ($_SESSION['role'] === 'administrateur'): ?>
            <a href="admin.php" class="btn btn-primary mb-3 me-2">Page d'administration</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>

        <?php if (isset($demande_message)): ?>
            <div class="alert alert-info mt-3"><?php echo $demande_message; ?></div>
        <?php endif; ?>

        <h2 class="mt-4">Nouvelle demande de présence</h2>
        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <label for="date_presence" class="form-label">Date de présence</label>
                <input type="date" class="form-control" id="date_presence" name="date_presence" required>
            </div>
            <button type="submit" name="new_demande" class="btn btn-primary">Envoyer la demande</button>
        </form>

        <h2>Vos demandes de présence</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Date de présence</th>
                    <th>Date de demande</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_demandes as $demande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($demande['date_presence']); ?></td>
                        <td><?php echo htmlspecialchars($demande['date_demande']); ?></td>
                        <td><?php echo htmlspecialchars($demande['statut']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>