const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const PORT = 3000;

// Middleware pour parser le corps des requêtes JSON
app.use(bodyParser.json());

// Simuler une base de données en mémoire
let utilisateurs = [];

// Endpoint d'inscription
app.post('/api/inscription', async (req, res) => {
    const { nom, email, motDePasse } = req.body;

    console.log('Données reçues pour l\'inscription:', req.body); // Débogage

    // Vérifiez que tous les champs sont fournis
    if (!nom || !email || !motDePasse) {
        console.error('Erreur: Tous les champs sont requis.'); // Débogage
        return res.status(400).json({ message: 'Tous les champs sont requis.' });
    }

    // Vérifiez si l'utilisateur existe déjà
    const utilisateurExistant = utilisateurs.find(user => user.email === email);
    if (utilisateurExistant) {
        console.error('Erreur: Cet email est déjà utilisé.'); // Débogage
        return res.status(400).json({ message: 'Cet email est déjà utilisé.' });
    }

    try {
        // Enregistrer l'utilisateur dans la "base de données"
        utilisateurs.push({ nom, email, motDePasse });
        console.log('Nouvel utilisateur inscrit:', { nom, email }); // Débogage

        // Répondre avec succès
        res.status(201).json({ message: 'Inscription réussie' });
    } catch (error) {
        console.error('Erreur d\'inscription:', error); // Débogage
        res.status(500).json({ message: 'Une erreur est survenue' });
    }
});

// Endpoint de connexion
app.post('/api/connexion', async (req, res) => {
    const { email, motDePasse } = req.body;

    console.log('Données reçues pour la connexion:', req.body); // Débogage

    // Vérifiez que tous les champs sont fournis
    if (!email || !motDePasse) {
        console.error('Erreur: Tous les champs sont requis.'); // Débogage
        return res.status(400).json({ message: 'Tous les champs sont requis.' });
    }

    try {
        // Vérifiez si l'utilisateur existe
        const utilisateur = utilisateurs.find(user => user.email === email);
        if (!utilisateur || utilisateur.motDePasse !== motDePasse) {
            console.error('Erreur: Email ou mot de passe incorrect.'); // Débogage
            return res.status(401).json({ message: 'Email ou mot de passe incorrect.' });
        }

        // Répondre avec succès
        res.status(200).json({
            message: 'Connexion réussie',
            token: 'votre_token', // Remplacez par un vrai token si nécessaire
            utilisateur: { nom: utilisateur.nom, email: utilisateur.email }
        });
    } catch (error) {
        console.error('Erreur de connexion:', error); // Débogage
        res.status(500).json({ message: 'Une erreur est survenue' });
    }
});

// Démarrer le serveur
app.listen(PORT, () => {
    console.log(`Serveur en cours d'exécution sur le port ${PORT}`);
});