function tri(numbers, order) {
    // Vérifie la valeur de "order" pour décider du tri
    if (order === 'asc') {
        // Tri ascendant
        return numbers.sort(function(a, b) {
            return a - b;
        });
    } else if (order === 'desc') {
        // Tri descendant
        return numbers.sort(function(a, b) {
            return b - a;
        });
    } else {
        // Si "order" n'est pas "asc" ou "desc", retourne le tableau inchangé
        return numbers;
    }
}

// Exemples de tests
console.log(tri([5, 3, 8, 2, 9, 1], 'asc'));  // [1, 2, 3, 5, 8, 9]
console.log(tri([5, 3, 8, 2, 9, 1], 'desc')); // [9, 8, 5, 3, 2, 1]
console.log(tri([10, -2, 34, 7, 0], 'asc'));  // [-2, 0, 7, 10, 34]
console.log(tri([10, -2, 34, 7, 0], 'desc')); // [34, 10, 7, 0, -2]
