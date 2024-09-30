document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const autocompleteResults = document.getElementById('autocomplete-results');

    searchInput.addEventListener('input', function() {
        const search = this.value.trim();
        if (search.length > 0) {
            fetch(`autocomplete.php?q=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    if (data.exact.length > 0) {
                        html += '<div class="autocomplete-group"><strong>Résultats exacts:</strong>';
                        data.exact.forEach(pokemon => {
                            html += `<div><a href="element.php?id=${pokemon.id}">${pokemon.name}</a> - ${pokemon.type}</div>`;
                        });
                        html += '</div>';
                    }
                    if (data.partial.length > 0) {
                        html += '<div class="autocomplete-group"><strong>Autres résultats:</strong>';
                        data.partial.forEach(pokemon => {
                            html += `<div><a href="element.php?id=${pokemon.id}">${pokemon.name}</a> - ${pokemon.type}</div>`;
                        });
                        html += '</div>';
                    }
                    autocompleteResults.innerHTML = html;
                    autocompleteResults.style.display = html ? 'block' : 'none';
                });
        } else {
            autocompleteResults.innerHTML = '';
            autocompleteResults.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
            autocompleteResults.style.display = 'none';
        }
    });
});
