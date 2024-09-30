document.addEventListener('DOMContentLoaded', function() {
    const formulaireConnexion = document.getElementById('loginForm');
    const formulaireInscription = document.getElementById('registerForm');

    if (formulaireConnexion) {
        formulaireConnexion.addEventListener('submit', gererConnexion);
    }

    if (formulaireInscription) {
        formulaireInscription.addEventListener('submit', gererInscription);
    }

    // Initialiser les composants Materialize
    M.AutoInit();
    console.log('DOM entièrement chargé et analysé');
});

async function gererConnexion(evenement) {
    evenement.preventDefault();
    const email = document.getElementById('email').value;
    const motDePasse = document.getElementById('password').value;

    console.log('Tentative de connexion avec', email);

    try {
        const reponse = await fetch('/api/connexion', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, motDePasse })
        });

        const texteReponse = await reponse.text();
        console.log('Réponse brute de l\'API:', texteReponse);

        let donnees;
        try {
            donnees = JSON.parse(texteReponse);
        } catch (e) {
            throw new Error(`Erreur du serveur: ${texteReponse}`);
        }

        console.log('Réponse de l\'API:', donnees);

        if (reponse.ok) {
            M.toast({html: 'Connexion réussie !'});
            localStorage.setItem('utilisateur', JSON.stringify(donnees));
            console.log('Redirection vers la page du calendrier dans 2 secondes');
            setTimeout(() => {
                window.location.href = '/page/calendar.html'; // Rediriger vers la page du calendrier
            }, 2000);
        } else {
            throw new Error(donnees.message || 'Échec de la connexion');
        }
    } catch (erreur) {
        console.error('Erreur de connexion:', erreur);
        M.toast({html: erreur.message});
    }
}

async function gererInscription(evenement) {
    evenement.preventDefault();
    const nom = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const motDePasse = document.getElementById('password').value;
    const confirmationMotDePasse = document.getElementById('confirmPassword').value;

    if (motDePasse !== confirmationMotDePasse) {
        return M.toast({html: 'Les mots de passe ne correspondent pas'});
    }

    console.log('Tentative d\'inscription avec', email);

    try {
        const reponse = await fetch('/api/inscription', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nom, email, motDePasse })
        });

        const texteReponse = await reponse.text();
        console.log('Réponse brute de l\'API:', texteReponse);

        let donnees;
        try {
            donnees = JSON.parse(texteReponse);
        } catch (e) {
            throw new Error(`Erreur du serveur: ${texteReponse}`);
        }

        console.log('Réponse de l\'API:', donnees);

        if (reponse.ok) {
            M.toast({html: 'Inscription réussie ! Vous allez être redirigé vers la page de connexion.'});
            console.log('Redirection vers la page de connexion dans 2 secondes');
            setTimeout(() => {
                window.location.href = '/page/login.html'; // Assurez-vous que ce chemin est correct
            }, 2000);
        } else {
            throw new Error(donnees.message || 'Échec de l\'inscription');
        }
    } catch (erreur) {
        console.error('Erreur d\'inscription:', erreur);
        M.toast({html: erreur.message});
    }
}