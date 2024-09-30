<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'autocompletion');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection() {
    try {
        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch(PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
