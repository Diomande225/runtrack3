function bisextile(annee) {
    if ((annee % 4 === 0 && annee % 100 !== 0) || (annee % 400 === 0)) {
        return true;
    } else {
        return false;
    }
}

// Tests de la fonction
console.log(bisextile(2024)); // true
console.log(bisextile(2023)); // false
console.log(bisextile(2000)); // true
console.log(bisextile(1900)); // false
