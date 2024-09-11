function afficherjourssemaines() {
    // Déclare le tableau des jours de la semaine
    const jourssemaines = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    // Boucle pour afficher chaque jour
    for (let i = 0; i < jourssemaines.length; i++) {
        console.log(jourssemaines[i]);
    }
}

// Appelle la fonction pour afficher les jours de la semaine
afficherjourssemaines();
