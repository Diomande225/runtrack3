<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrer les Pokémon</title>
</head>
<body>
    <h1>Filtrer les Pokémon</h1>
    
    <!-- Formulaire de filtrage -->
    <form id="filterForm">
        <label for="id">ID :</label>
        <input type="text" id="id" name="id">
        
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name">
        
        <label for="type">Type :</label>
        <select id="type" name="type">
            <option value="">Tous</option>
            <option value="Grass">Grass</option>
            <option value="Poison">Poison</option>
            <option value="Fire">Fire</option>
            <option value="Flying">Flying</option>
            <option value="Water">Water</option>
            <option value="Bug">Bug</option>
            <option value="Normal">Normal</option>
            <option value="Electric">Electric</option>
            <option value="Ground">Ground</option>
            <option value="Fairy">Fairy</option>
            <option value="Fighting">Fighting</option>
            <option value="Psychic">Psychic</option>
            <option value="Rock">Rock</option>
            <option value="Ice">Ice</option>
            <option value="Ghost">Ghost</option>
            <option value="Dragon">Dragon</option>
            <option value="Dark">Dark</option>
            <option value="Steel">Steel</option>
        </select>
        
        <input type="button" id="filterButton" value="Filtrer">
    </form>
    
    <!-- Zone pour afficher les résultats -->
    <div id="results"></div>
    
    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            fetch('pokemon.json')
                .then(response => response.json())
                .then(data => {
                    const id = document.getElementById('id').value.toLowerCase();
                    const name = document.getElementById('name').value.toLowerCase();
                    const type = document.getElementById('type').value.toLowerCase();
                    
                    const filteredData = data.filter(pokemon => {
                        return (id === "" || pokemon.id.toString().includes(id)) &&
                               (name === "" || pokemon.name.toLowerCase().includes(name)) &&
                               (type === "" || pokemon.type.some(t => t.toLowerCase() === type));
                    });
                    
                    displayResults(filteredData);
                })
                .catch(error => console.error('Erreur:', error));
        });

        function displayResults(pokemons) {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = ''; // Clear previous results
            
            if (pokemons.length === 0) {
                resultsDiv.innerHTML = '<p>Aucun Pokémon trouvé.</p>';
                return;
            }
            
            const ul = document.createElement('ul');
            pokemons.forEach(pokemon => {
                const li = document.createElement('li');
                li.textContent = `ID: ${pokemon.id}, Nom: ${pokemon.name}, Type: ${pokemon.type.join(', ')}`;
                ul.appendChild(li);
            });
            resultsDiv.appendChild(ul);
        }
    </script>
</body>
</html>