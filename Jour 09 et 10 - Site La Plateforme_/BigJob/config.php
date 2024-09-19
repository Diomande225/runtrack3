<?php

// Informations de connexion à la base de données
$db_host = 'localhost';
$db_name = 'bigjob';
$db_user = 'root';
$db_pass = '';

// Chemins vers les fichiers JSON
$users_json_file = __DIR__ . '/data/users.json';
$demandes_json_file = __DIR__ . '/data/demandes.json';

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fonction pour synchroniser les données JSON avec la base de données
function sync_json_to_db($json_file, $table, $pdo) {
    $json_data = file_get_contents($json_file);
    $data = json_decode($json_data, true);

    if (empty($data)) {
        echo "Aucune donnée à synchroniser pour la table $table.<br>";
        return;
    }

    try {
        // Désactiver temporairement les contraintes de clé étrangère
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

        // Commencer une transaction
        $pdo->beginTransaction();

        // Vider la table avant d'insérer les nouvelles données
        $pdo->exec("TRUNCATE TABLE $table");

        // Obtenir les colonnes de la table
        $stmt = $pdo->query("DESCRIBE $table");
        $db_columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Préparer la requête d'insertion
        $columns = array_intersect(array_keys($data[0]), $db_columns);
        $placeholders = array_fill(0, count($columns), '?');
        $sql = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = $pdo->prepare($sql);

        // Insérer les données
        foreach ($data as $item) {
            $values = array();
            foreach ($columns as $column) {
                $values[] = isset($item[$column]) ? $item[$column] : null;
            }
            $stmt->execute($values);
        }

        // Réactiver les contraintes de clé étrangère
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

        // Valider la transaction
        $pdo->commit();

        echo "Synchronisation réussie pour la table $table.<br>";
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction si elle est active
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "Erreur lors de la synchronisation de la table $table : " . $e->getMessage() . "<br>";
    }
}

// Fonction pour vérifier si un email est du domaine @laplateforme.io
function is_plateforme_email($email) {
    return strpos($email, '@laplateforme.io') !== false;
}

// Fonction pour obtenir les données depuis un fichier JSON
function get_json_data($json_file) {
    $json = file_get_contents($json_file);
    return json_decode($json, true);
}

// Fonction pour sauvegarder les données dans un fichier JSON
function save_json_data($json_file, $data) {
    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
}

// Fonction pour générer un ID unique
function generate_unique_id($existing_ids) {
    $new_id = empty($existing_ids) ? 1 : max($existing_ids) + 1;
    return $new_id;
}