<?php
// app/core/Controller.php

class Controller {
    public function __construct() {
        // Verification CSRF automatique sur tous les POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            verify_csrf();
        }
    }

    // Charger le modèle
    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    // Charger la vue
    public function view($view, $data = []) {
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            die("La vue $view n'existe pas.");
        }
    }
}
