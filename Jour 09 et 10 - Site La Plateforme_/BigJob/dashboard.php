<?php
session_start();

// Si l'utilisateur n'est pas connecté, rediriger vers l'accueil
if (!isset($_SESSION['utilisateur_nom'])) {
    header('Location: index.php');
    exit;
}

$demandes_file = 'demandes.json';
if (!file_exists($demandes_file)) {
    file_put_contents($demandes_file, json_encode([]));
}
$demandes = json_decode(file_get_contents($demandes_file), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_presence = $_POST['date_presence'];
    $nom = $_SESSION['utilisateur_nom'];

    // Ajouter la demande de présence
    $demandes[] = [
        'nom' => $nom,
        'date_presence' => $date_presence,
        'statut' => 'En attente',
        'date_demande' => date('Y-m-d H:i:s')
    ];
    file_put_contents($demandes_file, json_encode($demandes));

    header('Location: dashboard.php?demande=1');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - La Plateforme_</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bonjour, <?php echo $_SESSION['utilisateur_nom']; ?></h1>

        <?php if (isset($_GET['demande']) && $_GET['demande'] == 1): ?>
            <div class="alert alert-success text-center">Demande de présence envoyée.</div>
        <?php endif; ?>

        <h2 class="mt-4">Demande de présence</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="date_presence" class="form-label">Date de présence</label>
                <input type="date" class="form-control" id="date_presence" name="date_presence" required>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer la demande</button>
        </form>
    </div>
</body>
</html>
