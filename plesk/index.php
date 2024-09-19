<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Projets Web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .project-list {
            list-style-type: none;
            padding: 0;
        }
        .project-item {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .project-link {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }
        .project-link:hover {
            text-decoration: underline;
        }
        .project-description {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mes Projets Web</h1>
        <ul class="project-list">
            <?php
            // Définition de vos projets
            $projects = [
                [
                    'name' => 'Livre d\'or',
                    'url' => '/livre-dor/',
                    'description' => 'Un livre d\'or interactif pour laisser des commentaires.'
                ],
                [
                    'name' => 'Memory',
                    'url' => '/memory/',
                    'description' => 'Jeu de mémoire classique en version web.'
                ],
                // Vous pouvez ajouter d'autres projets ici si nécessaire
            ];

            foreach ($projects as $project) {
                echo "<li class='project-item'>";
                echo "<a href='{$project['url']}' class='project-link'>{$project['name']}</a>";
                echo "<p class='project-description'>{$project['description']}</p>";
                echo "</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>