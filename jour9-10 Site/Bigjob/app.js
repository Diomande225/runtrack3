const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Servir des fichiers statiques à partir du dossier 'public'
app.use(express.static(path.join(__dirname, 'public')));

// Simuler une base de données
let users = [];
let rendezVous = [];

// Route de test
app.get('/test', (req, res) => {
  res.json({ message: 'Le serveur fonctionne correctement' });
});

// Inscription
app.post('/api/inscription', (req, res) => {
  const { nom, email, motDePasse } = req.body;
  
  if (!nom || !email || !motDePasse) {
    return res.status(400).json({ message: 'Tous les champs sont requis' });
  }

  const userExists = users.find(user => user.email === email);
  if (userExists) {
    return res.status(400).json({ message: 'Cet email est déjà utilisé' });
  }

  const newUser = { nom, email, motDePasse };
  users.push(newUser);
  
  res.status(201).json({ message: 'Inscription réussie', user: newUser });
});

// Connexion
app.post('/api/connexion', (req, res) => {
  const { email, motDePasse } = req.body;

  if (!email || !motDePasse) {
    return res.status(400).json({ message: 'Email et mot de passe requis' });
  }

  const user = users.find(u => u.email === email && u.motDePasse === motDePasse);
  if (!user) {
    return res.status(401).json({ message: 'Email ou mot de passe incorrect' });
  }

  res.json({ message: 'Connexion réussie', user: { nom: user.nom, email: user.email } });
});

// Route pour gérer les rendez-vous
app.post('/api/rendez-vous', (req, res) => {
  const { utilisateur, date, description } = req.body;

  if (!utilisateur || !date || !description) {
    return res.status(400).json({ message: 'Tous les champs sont requis' });
  }

  const newRendezVous = { utilisateur, date, description };
  rendezVous.push(newRendezVous);

  res.status(201).json({ message: 'Rendez-vous enregistré avec succès', rendezVous: newRendezVous });
});

// Route de déconnexion
app.post('/api/deconnexion', (req, res) => {
  console.log('Route de déconnexion atteinte');
  res.json({ message: 'Déconnexion réussie' });
});

// Middleware de gestion d'erreurs
app.use((err, req, res, next) => {
  console.error('Erreur serveur:', err);
  res.status(500).json({ message: 'Une erreur est survenue', error: err.message });
});

// Démarrage du serveur
app.listen(PORT, () => {
  console.log(`Serveur en cours d'exécution sur le port ${PORT}`);
});