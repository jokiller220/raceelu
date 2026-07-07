<?php
// config.php
function get_env_var($keys, $default = '') {
    foreach ((array)$keys as $key) {
        $val = getenv($key);
        if ($val !== false && $val !== '') return $val;
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') return $_ENV[$key];
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return $_SERVER[$key];
    }
    return $default;
}

define('DB_HOST', get_env_var(['MYSQLHOST', 'MYSQL_HOST'], 'localhost'));
define('DB_USER', get_env_var(['MYSQLUSER', 'MYSQL_USER'], 'root'));
define('DB_PASS', get_env_var(['MYSQLPASSWORD', 'MYSQL_PASSWORD'], 'root')); // MAMP default password for root is 'root'
define('DB_NAME', get_env_var(['MYSQLDATABASE', 'MYSQL_DATABASE'], 'race_elu_db'));
define('DB_PORT', get_env_var(['MYSQLPORT', 'MYSQL_PORT'], '3306'));

// Base URL de l'application dynamique (gère le port automatiquement)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
define('BASE_URL', $protocol . '://' . $host . '/Race_Elu_siteweb');

// Titre du site
define('SITE_NAME', 'Race Élu - Grossiste Alimentaire');

// Fidélité (1 point pour X FCFA)
define('POINTS_RATIO', 1000);
define('POINT_VALUE', 10); // 1 point = 10 FCFA de réduction
