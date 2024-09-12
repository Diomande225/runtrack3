<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    
    <!-- Tableau pour afficher les utilisateurs -->
    <table id="usersTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les utilisateurs seront insérés ici -->
        </tbody>
    </table>
    
    <!-- Bouton pour mettre à jour le tableau -->
    <button id="updateButton">Update</button>
    
    <script>
        document.getElementById('updateButton').addEventListener('click', function() {
            fetch('users.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('usersTable').getElementsByTagName('tbody')[0];
                    tbody.innerHTML = ''; // Clear previous data
                    
                    data.forEach(user => {
                        const row = tbody.insertRow();
                        row.insertCell(0).textContent = user.id;
                        row.insertCell(1).textContent = user.nom;
                        row.insertCell(2).textContent = user.prenom;
                        row.insertCell(3).textContent = user.email;
                    });
                })
                .catch(error => console.error('Erreur:', error));
        });
    </script>
</body>
</html>