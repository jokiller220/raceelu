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

$db_url = get_env_var(['MYSQL_URL', 'DATABASE_URL', 'MYSQL_PRIVATE_URL']);
if ($db_url) {
    $parsed = parse_url($db_url);
    define('DB_HOST', $parsed['host'] ?? 'localhost');
    define('DB_USER', $parsed['user'] ?? 'root');
    define('DB_PASS', $parsed['pass'] ?? '');
    define('DB_NAME', ltrim($parsed['path'] ?? '/race_elu_db', '/'));
    define('DB_PORT', $parsed['port'] ?? '3306');
} else {
    define('DB_HOST', get_env_var(['MYSQLHOST', 'MYSQL_HOST'], 'gateway01.eu-central-1.prod.aws.tidbcloud.com'));
    define('DB_USER', get_env_var(['MYSQLUSER', 'MYSQL_USER'], '3cnjGn66JTPAvQH.root'));
    define('DB_PASS', get_env_var(['MYSQLPASSWORD', 'MYSQL_PASSWORD'], 'rOHhBuwTmieKFMj0')); 
    define('DB_NAME', get_env_var(['MYSQLDATABASE', 'MYSQL_DATABASE'], 'test'));
    define('DB_PORT', get_env_var(['MYSQLPORT', 'MYSQL_PORT'], '4000'));
}

// Base URL de l'application dynamique (gère le port automatiquement)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$scriptPath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptPath === '/' || $scriptPath === '\\') {
    $scriptPath = '';
}
// Si on est sur Railway (ou tout autre serveur où le dossier racine est servi), SCRIPT_NAME est /index.php donc scriptPath est vide
// Si on est sur MAMP, c'est /Race_Elu_siteweb/index.php, donc scriptPath est /Race_Elu_siteweb
define('BASE_URL', $protocol . '://' . $host . $scriptPath);

// Titre du site
define('SITE_NAME', 'Race Élu - Grossiste Alimentaire');

// Fidélité (1 point pour X FCFA)
define('POINTS_RATIO', 1000);
define('POINT_VALUE', 10); // 1 point = 10 FCFA de réduction
