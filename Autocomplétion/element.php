<?php
include 'config.php';
include 'header.php';

$id = $_GET['id'] ?? 0;
$db = getDBConnection();

$query = $db->prepare("SELECT * FROM pokemons WHERE id = :id");
$query->execute(['id' => $id]);
$pokemon = $query->fetch(PDO::FETCH_ASSOC);
?>

<main>
    <?php if ($pokemon): ?>
        <h2><?= htmlspecialchars($pokemon['name']) ?></h2>
        <p><strong>Type:</strong> <?= htmlspecialchars($pokemon['type']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($pokemon['description']) ?></p>
    <?php else: ?>
        <p>Pokémon non trouvé.</p>
    <?php endif; ?>
</main>

<script src="script.js"></script>
</body>
</html>
