<?php
// config.php
define('DB_HOST', getenv('MYSQLHOST') ?: 'localhost');
define('DB_USER', getenv('MYSQLUSER') ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: 'root'); // MAMP default password for root is 'root'
define('DB_NAME', getenv('MYSQLDATABASE') ?: 'race_elu_db');
define('DB_PORT', getenv('MYSQLPORT') ?: '3306');

// Base URL de l'application dynamique (gère le port automatiquement)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
define('BASE_URL', $protocol . '://' . $host . '/Race_Elu_siteweb');

// Titre du site
define('SITE_NAME', 'Race Élu - Grossiste Alimentaire');

// Fidélité (1 point pour X FCFA)
define('POINTS_RATIO', 1000);
define('POINT_VALUE', 10); // 1 point = 10 FCFA de réduction
