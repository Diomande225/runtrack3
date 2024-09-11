function fizzbuzz() {
    // Boucle pour parcourir les nombres de 1 à 151
    for (let i = 1; i <= 151; i++) {
        // Vérifie si le nombre est un multiple de 3 et de 5
        if (i % 3 === 0 && i % 5 === 0) {
            console.log('FizzBuzz');
        }
        // Vérifie si le nombre est un multiple de 3
        else if (i % 3 === 0) {
            console.log('Fizz');
        }
        // Vérifie si le nombre est un multiple de 5
        else if (i % 5 === 0) {
            console.log('Buzz');
        }
        // Sinon, affiche le nombre
        else {
            console.log(i);
        }
    }
}

// Appelle la fonction pour exécuter FizzBuzz
fizzbuzz();
