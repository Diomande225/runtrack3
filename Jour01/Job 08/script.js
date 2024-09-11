// Fonction pour vérifier si un nombre est premier
function estPremier(n) {
    if (n <= 1) return false; // Les nombres <= 1 ne sont pas premiers
    for (let i = 2; i <= Math.sqrt(n); i++) {
        if (n % i === 0) return false;
    }
    return true;
}

// Fonction pour calculer la somme de deux nombres premiers
function sommenombrespremiers(a, b) {
    if (estPremier(a) && estPremier(b)) {
        return a + b;
    } else {
        return false;
    }
}

// Exemples de tests
console.log(sommenombrespremiers(5, 7)); // 12, car 5 et 7 sont premiers
console.log(sommenombrespremiers(4, 9)); // false, car 4 et 9 ne sont pas premiers
console.log(sommenombrespremiers(11, 13)); // 24, car 11 et 13 sont premiers
console.log(sommenombrespremiers(8, 3)); // false, car 8 n'est pas premier
