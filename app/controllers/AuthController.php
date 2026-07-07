<?php
// app/controllers/AuthController.php

class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $db = new Database();
            $db->query('SELECT * FROM users WHERE email = :email');
            $db->bind(':email', $email);
            $user = $db->single();

            if ($user && password_verify($password, $user->password)) {
                // Session
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_nom'] = $user->nom;
                $_SESSION['role'] = $user->role;
                $_SESSION['flash_success'] = "Bienvenue, " . $user->nom . " ! Heureux de vous revoir.";

                if ($user->role === 'admin') {
                    header('Location: ' . BASE_URL . '/admin');
                } else {
                    header('Location: ' . BASE_URL . '/shop');
                }
                exit;
            } else {
                $data = ['error' => 'Identifiants incorrects', 'title' => 'Connexion - Race Élu'];
                $this->view('pages/login', $data);
                return;
            }
        }

        $this->view('pages/login', ['title' => 'Connexion - Race Élu']);
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $telephone = trim($_POST['telephone']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if ($password !== $password_confirm) {
                $data = ['error' => 'Les mots de passe ne correspondent pas.', 'title' => 'Créer un compte - Race Élu'];
                $this->view('pages/register', $data);
                return;
            }

            $db = new Database();
            // Verifier si l'email existe deja
            $db->query('SELECT id FROM users WHERE email = :email');
            $db->bind(':email', $email);
            if ($db->single()) {
                $data = ['error' => 'Cet email est déjà utilisé.', 'title' => 'Créer un compte - Race Élu'];
                $this->view('pages/register', $data);
                return;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $db->query('INSERT INTO users (nom, email, telephone, password, role) VALUES (:nom, :email, :telephone, :password, "client")');
            $db->bind(':nom', $nom);
            $db->bind(':email', $email);
            $db->bind(':telephone', $telephone);
            $db->bind(':password', $hashed_password);
            
            if ($db->execute()) {
                // Auto login
                $_SESSION['user_id'] = $db->lastInsertId();
                $_SESSION['user_nom'] = $nom;
                $_SESSION['role'] = 'client';
                header('Location: ' . BASE_URL . '/shop');
                exit;
            }
        }

        $this->view('pages/register', ['title' => 'Créer un compte - Race Élu']);
    }
}
