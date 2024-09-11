function jourtravaille(date) {
    // Liste des jours fériés en France pour l'année 2020
    const joursFeries2020 = [
        new Date('2020-01-01'), // Jour de l'an
        new Date('2020-04-13'), // Lundi de Pâques
        new Date('2020-05-01'), // Fête du Travail
        new Date('2020-05-08'), // Victoire 1945
        new Date('2020-05-21'), // Ascension
        new Date('2020-06-01'), // Lundi de Pentecôte
        new Date('2020-07-14'), // Fête Nationale
        new Date('2020-08-15'), // Assomption
        new Date('2020-11-01'), // Toussaint
        new Date('2020-11-11'), // Armistice 1918
        new Date('2020-12-25')  // Noël
    ];

    const jour = date.getDate();
    const mois = date.getMonth() + 1; // Les mois commencent à 0 en JavaScript
    const annee = date.getFullYear();

    // Vérifie si la date est un jour férié
    for (let i = 0; i < joursFeries2020.length; i++) {
        if (date.toDateString() === joursFeries2020[i].toDateString()) {
            console.log(`Le ${jour} ${mois} ${annee} est un jour férié`);
            return;
        }
    }

    // Vérifie si la date est un week-end (samedi ou dimanche)
    const jourSemaine = date.getDay(); // 0 = dimanche, 6 = samedi
    if (jourSemaine === 0 || jourSemaine === 6) {
        console.log(`Non, le ${jour} ${mois} ${annee} est un week-end`);
    } else {
        console.log(`Oui, le ${jour} ${mois} ${annee} est un jour travaillé`);
    }
}

// Exemples de tests
jourtravaille(new Date('2020-01-01')); // Jour férié
jourtravaille(new Date('2020-05-02')); // Week-end
jourtravaille(new Date('2020-07-14')); // Jour férié
jourtravaille(new Date('2020-07-15')); // Jour travaillé
