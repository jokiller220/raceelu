<?php
require_once 'config/config.php';

echo "<h1>Installation de la base de données</h1>";

try {
    $port = defined('DB_PORT') ? DB_PORT : '3306';
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . $port . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/config/cacert.pem',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true
    );
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    $sqlFile = __DIR__ . '/database/database.sql';
    if (!file_exists($sqlFile)) {
        die("Erreur: Le fichier database.sql est introuvable.");
    }

    $sql = file_get_contents($sqlFile);
    
    // Sépare les requêtes par le point-virgule
    $queries = explode(';', $sql);
    
    $successCount = 0;
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            try {
                $pdo->exec($query);
                $successCount++;
            } catch (PDOException $e) {
                echo "<p style='color:red;'>Erreur sur la requête : " . htmlspecialchars($query) . "<br>" . $e->getMessage() . "</p>";
            }
        }
    }

    echo "<p style='color:green;'><strong>Succès !</strong> $successCount requêtes ont été exécutées avec succès.</p>";
    echo "<p>Veuillez SUPPRIMER ce fichier (install.php) de votre serveur maintenant pour des raisons de sécurité !</p>";
    echo "<a href='" . BASE_URL . "'>Aller à l'accueil</a>";

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erreur de connexion : " . $e->getMessage() . "</p>";
}
