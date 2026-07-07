<?php
// app/core/App.php

class App {
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Chercher le contrôleur (première partie de l'URL)
        if (isset($url[0]) && file_exists('app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
            $this->currentController = ucwords($url[0]) . 'Controller';
            unset($url[0]);
        }

        require_once 'app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Chercher la méthode (deuxième partie de l'URL)
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Obtenir les paramètres
        $this->params = $url ? array_values($url) : [];

        // Appeler la méthode avec les paramètres
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
