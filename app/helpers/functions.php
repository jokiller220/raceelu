<?php
// app/helpers/functions.php

/**
 * Escape HTML output
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * CSRF field for forms
 */
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Verify CSRF token
 */
function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Détecter si $_POST est vide à cause d'un dépassement de post_max_size (ex: image trop lourde)
        if (empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
            die('Erreur : Le fichier envoyé (image) est trop volumineux. Veuillez réduire sa taille (max environ 2Mo) et réessayer.');
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            // Si c'est une requête AJAX, renvoyer du JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Session expirée, veuillez rafraîchir la page.']);
                exit;
            }
            die('Erreur de sécurité : Jeton CSRF invalide ou session expirée.');
        }
    }
}

/**
 * Get setting value from DB
 */
function get_setting($key, $default = '') {
    static $settings = null;
    
    if ($settings === null) {
        $db = new Database();
        $db->query('SELECT setting_key, setting_value FROM settings');
        $rows = $db->resultSet();
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
    }
    
    return isset($settings[$key]) ? $settings[$key] : $default;
}

/**
 * Get user points
 */
function get_user_points($user_id) {
    $db = new Database();
    $db->query('SELECT points FROM users WHERE id = :id');
    $db->bind(':id', $user_id);
    $user = $db->single();
    return $user ? $user->points : 0;
}
