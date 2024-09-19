<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'modérateur' && $_SESSION['role'] != 'administrateur')) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $statut = $_POST['statut'];
    $demande_id = $_POST['demande_id'];

    $demandes_json = file_get_contents($demandes_json_file);
    $demandes = json_decode($demandes_json, true);

    foreach ($demandes as &$demande) {
        if ($demande['id'] == $demande_id) {
            $demande['statut'] = $statut;
            break;
        }
    }

    file_put_contents($demandes_json_file, json_encode($demandes, JSON_PRETTY_PRINT));
    
    sync_json_to_db($demandes_json_file, 'demandes', $pdo);

    header('Location: backoffice.php');
    exit;
}

$demandes_json = file_get_contents($demandes_json_file);
$demandes = json_decode($demandes_json, true);

$users_json = file_get_contents($users_json_file);
$users = json_decode($users_json, true);

foreach ($demandes as &$demande) {
    foreach ($users as $user) {
        if ($user['id'] == $demande['user_id']) {
            $demande['nom_utilisateur'] = $user['nom']; // Utilisez un nom différent pour éviter les conflits
            break;
        }
    }
}

// ... (le reste du code HTML reste inchangé)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - La Plateforme_</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <h1 class="mb-3 mb-md-0">Gestion des demandes de présence</h1>
            <div>
                <?php if ($_SESSION['role'] === 'administrateur'): ?>
                    <a href="admin.php" class="btn btn-primary me-2 mb-2 mb-md-0">Gestion des droits</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date de présence</th>
                        <th>Date de demande</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demandes as $demande): ?>
                        <tr>
                         <td><?php echo $demande['nom_utilisateur']; ?></td>
                            <td><?php echo $demande['date_presence']; ?></td>
                            <td><?php echo $demande['date_demande']; ?></td>
                            <td><?php echo $demande['statut']; ?></td>
                            <td class="table-actions">
                                <?php if ($demande['date_presence'] >= date('Y-m-d')): ?>
                                    <form method="POST" action="" class="d-flex flex-column flex-md-row">
                                        <input type="hidden" name="demande_id" value="<?php echo $demande['id']; ?>">
                                        <select name="statut" class="form-select me-md-2 mb-2 mb-md-0">
                                            <option value="Acceptée">Accepter</option>
                                            <option value="Refusée">Refuser</option>
                                        </select>
                                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Date passée</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>