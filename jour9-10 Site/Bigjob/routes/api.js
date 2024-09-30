const express = require('express');
const router = express.Router();
const fs = require('fs');
const path = require('path');

// Chemin vers le fichier appointments.json
const appointmentsFilePath = path.join(__dirname, '../public/Assets/data/appointments.json');

// Chemin vers le fichier users.json
const usersFilePath = path.join(__dirname, '../public/Assets/data/users.json');

// Fonctions pour lire et écrire dans le fichier appointments.json
const readAppointmentsFromFile = () => {
    try {
        const data = fs.readFileSync(appointmentsFilePath, 'utf8');
        return data ? JSON.parse(data) : [];
    } catch (err) {
        console.error('Erreur de lecture du fichier appointments.json:', err);
        return [];
    }
};

const writeAppointmentsToFile = (appointments) => {
    try {
        fs.writeFileSync(appointmentsFilePath, JSON.stringify(appointments, null, 2));
    } catch (err) {
        console.error('Erreur d\'écriture dans le fichier appointments.json:', err);
    }
};

// Fonctions pour lire et écrire dans le fichier users.json
const readUsersFromFile = () => {
    try {
        const data = fs.readFileSync(usersFilePath, 'utf8');
        return data ? JSON.parse(data) : [];
    } catch (err) {
        console.error('Erreur de lecture du fichier users.json:', err);
        return [];
    }
};

const writeUsersToFile = (users) => {
    try {
        fs.writeFileSync(usersFilePath, JSON.stringify(users, null, 2));
    } catch (err) {
        console.error('Erreur d\'écriture dans le fichier users.json:', err);
    }
};

// Route pour récupérer les rendez-vous
router.get('/rendez-vous', (req, res) => {
    try {
        const appointments = readAppointmentsFromFile();
        res.json(appointments);
    } catch (err) {
        console.error('Erreur lors de la récupération des rendez-vous:', err);
        res.status(500).json({ message: 'Erreur lors de la récupération des rendez-vous' });
    }
});

// Route pour créer un rendez-vous
router.post('/rendez-vous', (req, res) => {
    const { utilisateur, date, heure, description } = req.body;

    if (!utilisateur || !date || !heure || !description) {
        return res.status(400).json({ message: 'Tous les champs sont requis' });
    }

    try {
        const appointments = readAppointmentsFromFile();
        const nouvelRendezVous = { id: appointments.length + 1, utilisateur, date, heure, description };
        appointments.push(nouvelRendezVous);
        writeAppointmentsToFile(appointments);

        res.status(201).json({ message: 'Rendez-vous enregistré avec succès', rendezVous: nouvelRendezVous });
    } catch (err) {
        console.error('Erreur lors de la création du rendez-vous:', err);
        res.status(500).json({ message: 'Erreur lors de la création du rendez-vous' });
    }
});

// Inscription d'un utilisateur
router.post('/inscription', (req, res) => {
    console.log('Requête d\'inscription reçue :', req.body);
    const { nom, email, motDePasse } = req.body;

    if (!nom || !email || !motDePasse) {
        return res.status(400).json({ message: 'Tous les champs sont obligatoires' });
    }

    try {
        const users = readUsersFromFile();
        console.log('Utilisateurs avant ajout :', users);

        if (users.find(user => user.email === email)) {
            return res.status(400).json({ message: 'Cet email est déjà enregistré' });
        }

        const nouvelUtilisateur = { id: users.length + 1, nom, email, motDePasse };
        users.push(nouvelUtilisateur);
        writeUsersToFile(users);

        console.log('Utilisateurs après ajout :', users);
        res.status(201).json({ message: 'Utilisateur enregistré avec succès', idUtilisateur: nouvelUtilisateur.id });
    } catch (err) {
        console.error('Erreur lors de l\'inscription de l\'utilisateur:', err);
        res.status(500).json({ message: 'Erreur lors de l\'inscription de l\'utilisateur' });
    }
});

// Connexion d'un utilisateur
router.post('/connexion', (req, res) => {
    console.log('Requête de connexion reçue :', req.body);
    const { email, motDePasse } = req.body;

    try {
        const users = readUsersFromFile();
        console.log('Utilisateurs chargés :', users);

        const utilisateur = users.find(user => user.email === email && user.motDePasse === motDePasse);
        console.log('Utilisateur trouvé :', utilisateur);

        if (utilisateur) {
            res.json({ message: 'Connexion réussie', idUtilisateur: utilisateur.id, token: 'token_factice' });
        } else {
            console.log('Email ou mot de passe incorrect');
            res.status(401).json({ message: 'Email ou mot de passe incorrect' });
        }
    } catch (err) {
        console.error('Erreur lors de la connexion de l\'utilisateur:', err);
        res.status(500).json({ message: 'Erreur lors de la connexion de l\'utilisateur' });
    }
});

// Déconnexion d'un utilisateur
router.post('/deconnexion', (req, res) => {
    console.log('Requête de déconnexion reçue');
    res.json({ message: 'Déconnexion réussie' });
});

// Récupération de tous les utilisateurs
router.get('/utilisateurs', (req, res) => {
    try {
        const users = readUsersFromFile();
        res.json(users);
    } catch (err) {
        console.error('Erreur lors de la récupération des utilisateurs:', err);
        res.status(500).json({ message: 'Erreur lors de la récupération des utilisateurs' });
    }
});

// Récupération de tous les utilisateurs des rendez-vous
router.get('/rendez-vous/utilisateurs', (req, res) => {
    try {
        const appointments = readAppointmentsFromFile();
        const utilisateurs = appointments.map(appointment => appointment.utilisateur);
        res.json(utilisateurs);
    } catch (err) {
        console.error('Erreur lors de la récupération des utilisateurs des rendez-vous:', err);
        res.status(500).json({ message: 'Erreur lors de la récupération des utilisateurs des rendez-vous' });
    }
});

// Route pour les statistiques d'administration
router.get('/admin/statistiques', (req, res) => {
    try {
        const users = readUsersFromFile();
        const appointments = readAppointmentsFromFile();

        const statistiques = {
            nombreUtilisateurs: users.length,
            nombreRendezVous: appointments.length,
        };

        res.json(statistiques);
    } catch (err) {
        console.error('Erreur lors de la récupération des statistiques d\'administration:', err);
        res.status(500).json({ message: 'Erreur lors de la récupération des statistiques d\'administration' });
    }
});

module.exports = router;