<?php
include 'config.php';
include 'header.php';

$search = $_GET['search'] ?? '';
$db = getDBConnection();

$query = $db->prepare("SELECT * FROM pokemons WHERE name LIKE :search");
$query->execute(['search' => "%$search%"]);
$results = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <h2>Résultats pour "<?= htmlspecialchars($search) ?>"</h2>
    <?php if (count($results) > 0): ?>
        <ul>
            <?php foreach ($results as $pokemon): ?>
                <li><a href="element.php?id=<?= $pokemon['id'] ?>"><?= htmlspecialchars($pokemon['name']) ?></a> - <?= htmlspecialchars($pokemon['type']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun résultat trouvé.</p>
    <?php endif; ?>
</main>

<script src="script.js"></script>
</body>
</html>
