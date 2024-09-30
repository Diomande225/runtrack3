<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Pokédex</h1>
        <form action="recherche.php" method="GET">
            <input type="text" name="search" id="search" placeholder="Rechercher un Pokémon...">
            <button type="submit">Rechercher</button>
        </form>
        <div id="autocomplete-results"></div>
    </header>
