<?php
// index.php
// En-têtes de sécurité
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Paramètres de session sécurisés et durée de vie longue (30 jours)
ini_set('session.gc_maxlifetime', 2592000);
ini_set('session.cookie_lifetime', 2592000);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}
session_start();

require_once 'config/config.php';
require_once 'app/helpers/functions.php';
require_once 'app/core/Database.php';
require_once 'app/core/Controller.php';
require_once 'app/core/App.php';

// Charger le helper CSRF si besoin (facultatif ici, on peut l'intégrer direct dans Controller)

// Instancier l'application
$app = new App();
