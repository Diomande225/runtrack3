const fs = require('fs');
const path = require('path');
const express = require('express');
const router = express.Router();

const usersFilePath = path.join(__dirname, '../public/Assets/data/users.json');
const appointmentsFilePath = path.join(__dirname, '../public/Assets/data/appointments.json');

const readUsersFromFile = () => {
    const data = fs.readFileSync(usersFilePath, 'utf8');
    return JSON.parse(data);
};

const writeUsersToFile = (users) => {
    fs.writeFileSync(usersFilePath, JSON.stringify(users, null, 2));
};

const readAppointmentsFromFile = () => {
    const data = fs.readFileSync(appointmentsFilePath, 'utf8');
    return JSON.parse(data);
};

const writeAppointmentsToFile = (appointments) => {
    fs.writeFileSync(appointmentsFilePath, JSON.stringify(appointments, null, 2));
};

// Inscription d'un utilisateur
router.post('/inscription', (req, res) => {
    console.log('Requête d\'inscription reçue :', req.body);
    const { nom, email, motDePasse } = req.body;

    if (!nom || !email || !motDePasse) {
        return res.status(400).json({ message: 'Tous les champs sont obligatoires' });
    }

    const users = readUsersFromFile();

    if (users.find(user => user.email === email)) {
        return res.status(400).json({ message: 'Cet email est déjà enregistré' });
    }

    const nouvelUtilisateur = { id: users.length + 1, nom, email, motDePasse };
    users.push(nouvelUtilisateur);
    writeUsersToFile(users);

    res.status(201).json({ message: 'Utilisateur enregistré avec succès', idUtilisateur: nouvelUtilisateur.id });
});

// Connexion d'un utilisateur
router.post('/connexion', (req, res) => {
    console.log('Requête de connexion reçue :', req.body);
    const { email, motDePasse } = req.body;

    const users = readUsersFromFile();
    const utilisateur = users.find(user => user.email === email && user.motDePasse === motDePasse);

    if (utilisateur) {
        res.json({ message: 'Connexion réussie', idUtilisateur: utilisateur.id, token: 'token_factice' });
    } else {
        res.status(401).json({ message: 'Identifiants invalides' });
    }
});

// Récupération de tous les utilisateurs
router.get('/utilisateurs', (req, res) => {
    const users = readUsersFromFile();
    res.json(users);
});

// Création d'un rendez-vous
router.post('/rendez-vous', (req, res) => {
    console.log('Requête de création de rendez-vous reçue :', req.body);
    const { date, heure, description } = req.body;

    if (!date || !heure || !description) {
        return res.status(400).json({ message: 'Tous les champs sont obligatoires' });
    }

    const appointments = readAppointmentsFromFile();
    const nouvelRendezVous = { id: appointments.length + 1, date, heure, description };
    appointments.push(nouvelRendezVous);
    writeAppointmentsToFile(appointments);

    res.status(201).json({ message: 'Rendez-vous enregistré avec succès', rendezVous: nouvelRendezVous });
});

// Récupération de tous les rendez-vous
router.get('/rendez-vous', (req, res) => {
    const appointments = readAppointmentsFromFile();
    res.json(appointments);
});

// Nouvelle route pour les statistiques d'administration
router.get('/admin/statistics', (req, res) => {
    const users = readUsersFromFile();
    const appointments = readAppointmentsFromFile();

    const statistics = {
        totalUsers: users.length,
        totalAppointments: appointments.length
    };

    res.json(statistics);
});

module.exports = router;