<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Fonction pour lire les demandes depuis le fichier JSON
function get_demandes() {
    global $demandes_json_file;
    $json = file_get_contents($demandes_json_file);
    return json_decode($json, true);
}

// Fonction pour sauvegarder les demandes dans le fichier JSON
function save_demandes($demandes) {
    global $demandes_json_file;
    file_put_contents($demandes_json_file, json_encode($demandes, JSON_PRETTY_PRINT));
}

// Traitement de la suppression d'une demande
if (isset($_POST['delete_demande'])) {
    $demande_id = $_POST['demande_id'];
    $demandes = get_demandes();
    
    // Supprimer la demande du tableau
    $demandes = array_filter($demandes, function($demande) use ($demande_id) {
        return $demande['id'] != $demande_id;
    });
    
    // Sauvegarder les demandes mises à jour
    save_demandes(array_values($demandes));
    
    // Synchroniser avec la base de données
    sync_json_to_db($demandes_json_file, 'demandes', $pdo);
}

// Traitement de l'ajout d'une nouvelle demande
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date_presence'])) {
    $date_presence = $_POST['date_presence'];
    $today = date('Y-m-d');

    if ($date_presence >= $today) {
        $demandes = get_demandes();
        
        $nouvelle_demande = [
            'id' => count($demandes) + 1,
            'user_id' => $_SESSION['user_id'],
            'date_presence' => $date_presence,
            'date_demande' => $today,
            'statut' => 'En attente'
        ];
        $demandes[] = $nouvelle_demande;
        
        save_demandes($demandes);
        sync_json_to_db($demandes_json_file, 'demandes', $pdo);
        
        $message = "Votre demande de présence a été enregistrée.";
    } else {
        $message = "Erreur : Vous ne pouvez pas faire de demande pour une date passée.";
    }
}

// Récupérer toutes les demandes
$demandes = get_demandes();

// Filtrer les demandes pour l'utilisateur connecté
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
    <script src="js/main.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Calendrier de présence</h1>
        <a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>
        
        <?php if (isset($message)) echo "<p class='alert alert-info'>$message</p>"; ?>
        
        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <label for="date_presence" class="form-label">Date de présence</label>
                <input type="date" class="form-control" id="date_presence" name="date_presence" required>
            </div>
            <button type="submit" class="btn btn-primary">Demander une présence</button>
        </form>
        
        <h2>Vos demandes de présence</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Date de présence</th>
                    <th>Date de demande</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_demandes as $demande): ?>
                    <tr>
                        <td><?php echo $demande['date_presence']; ?></td>
                        <td><?php echo $demande['date_demande']; ?></td>
                        <td><?php echo $demande['statut']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="demande_id" value="<?php echo $demande['id']; ?>">
                                <button type="submit" name="delete_demande" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>