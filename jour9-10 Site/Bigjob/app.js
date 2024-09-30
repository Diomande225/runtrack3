const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const path = require('path');
const apiRoutes = require('./routes/api');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Servir des fichiers statiques à partir du dossier 'public'
app.use(express.static(path.join(__dirname, 'public')));

// Utiliser les routes API
app.use('/api', apiRoutes);

// Route de test
app.get('/test', (req, res) => {
  res.json({ message: 'Le serveur fonctionne correctement' });
});

// Middleware de gestion d'erreurs
app.use((err, req, res, next) => {
  console.error('Erreur serveur:', err);
  res.status(500).json({ message: 'Une erreur est survenue', error: err.message });
});

// Démarrage du serveur
app.listen(PORT, () => {
  console.log(`Serveur démarré sur le port ${PORT}`);
});