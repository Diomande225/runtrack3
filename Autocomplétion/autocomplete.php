<?php
include 'config.php';

$search = $_GET['q'] ?? '';
$db = getDBConnection();

$query = $db->prepare("SELECT * FROM pokemons WHERE name LIKE :search ORDER BY CASE WHEN name LIKE :exact THEN 0 ELSE 1 END, name LIMIT 10");
$query->execute(['search' => "%$search%", 'exact' => "$search%"]);
$results = $query->fetchAll(PDO::FETCH_ASSOC);

$exact = [];
$partial = [];

foreach ($results as $pokemon) {
    if (stripos($pokemon['name'], $search) === 0) {
        $exact[] = $pokemon;
    } else {
        $partial[] = $pokemon;
    }
}

echo json_encode(['exact' => $exact, 'partial' => $partial]);
