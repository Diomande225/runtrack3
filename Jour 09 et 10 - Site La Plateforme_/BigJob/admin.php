<?php
session_start();
require_once 'config.php';

// Vérification de l'authentification et des droits d'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    header('Location: calendrier.php');
    exit;
}

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Traitement des demandes de présence
    if (isset($_POST['approve_demande']) || isset($_POST['refuse_demande'])) {
        $demande_id = $_POST['demande_id'];
        $new_status = isset($_POST['approve_demande']) ? 'Approuvée' : 'Refusée';
        
        $demandes = get_json_data($demandes_json_file);
        
        foreach ($demandes as &$demande) {
            if ($demande['id'] == $demande_id) {
                $demande['statut'] = $new_status;
                break;
            }
        }
        
        save_json_data($demandes_json_file, $demandes);
        sync_json_to_db($demandes_json_file, 'demandes', $pdo);
        $action_message = "La demande a été " . strtolower($new_status) . " avec succès.";
    }

    // Traitement de l'ajout d'un nouvel administrateur
    if (isset($_POST['add_admin'])) {
        $new_admin_email = $_POST['new_admin_email'];
        
        $users = get_json_data($users_json_file);
        $user_found = false;
        $admin_added = false;
        
        foreach ($users as &$user) {
            if ($user['email'] === $new_admin_email) {
                $user_found = true;
                if ($user['role'] !== 'administrateur') {
                    $user['role'] = 'administrateur';
                    $user['statut'] = 'Approuvé';
                    $admin_added = true;
                } else {
                    $action_message = "Cet utilisateur est déjà administrateur.";
                }
                break;
            }
        }
        
        if (!$user_found) {
            $action_message = "Aucun utilisateur trouvé avec cet email.";
        } elseif ($admin_added) {
            save_json_data($users_json_file, $users);
            sync_json_to_db($users_json_file, 'users', $pdo);
            $action_message = "L'utilisateur a été promu administrateur avec succès.";
        }
    }
}

// Récupération des données
$demandes = get_json_data($demandes_json_file);
$users = get_json_data($users_json_file);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - La Plateforme_</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Administration</h1>
        <a href="calendrier.php" class="btn btn-primary mb-3 me-2">Retour au calendrier</a>
        <a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>
        
        <?php if (isset($action_message)): ?>
            <div class="alert alert-info mt-3"><?php echo $action_message; ?></div>
        <?php endif; ?>

        <h2 class="mt-4">Gestion des demandes de présence</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Date de présence</th>
                    <th>Date de demande</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                    <tr>
                        <td>
                            <?php
                            $user = array_filter($users, function($u) use ($demande) {
                                return $u['id'] == $demande['user_id'];
                            });
                            $user = reset($user);
                            echo htmlspecialchars($user['nom']);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($demande['date_presence']); ?></td>
                        <td><?php echo htmlspecialchars($demande['date_demande']); ?></td>
                        <td><?php echo htmlspecialchars($demande['statut']); ?></td>
                        <td>
                            <?php if ($demande['statut'] === 'En attente'): ?>
                                <form method="POST" action="" class="d-inline">
                                    <input type="hidden" name="demande_id" value="<?php echo $demande['id']; ?>">
                                    <button type="submit" name="approve_demande" class="btn btn-success btn-sm">Approuver</button>
                                </form>
                                <form method="POST" action="" class="d-inline">
                                    <input type="hidden" name="demande_id" value="<?php echo $demande['id']; ?>">
                                    <button type="submit" name="refuse_demande" class="btn btn-danger btn-sm">Refuser</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h2 class="mt-5">Ajouter un nouvel administrateur</h2>
        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <label for="new_admin_email" class="form-label">Email du nouvel administrateur</label>
                <input type="email" class="form-control" id="new_admin_email" name="new_admin_email" required>
            </div>
            <button type="submit" name="add_admin" class="btn btn-primary">Ajouter comme administrateur</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>