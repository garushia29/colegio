<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/config.php';

class AuthController {
    private $pdo;

    public function __construct($pdo = null) { 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->pdo = $pdo ?: getPDOConnection();
    }

    public function showLogin() {
        // Si el usuario ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location:".URL."public/index.php");

            exit;
        }
        include __DIR__ . '/../views/login_form.php';
    }

    public function login($username, $password) {
        // Si el usuario ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location:".URL."public/index.php");

            exit;
        }

        $userModel = new Usuario($this->pdo);
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            header("Location:".URL."public/index.php");
            exit;
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: " .URL. "public/login.php");

            exit;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
       header("Location: " .URL. "public/login.php");
        exit;
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }
}