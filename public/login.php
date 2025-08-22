<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

// Iniciar sesión una sola vez
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = getPDOConnection();
$auth = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $auth->login($username, $password);
    } else {
        $_SESSION['error'] = "Por favor complete todos los campos";
       header("Location: " . URL . "public/login.php");

        exit;
    }
} else {
    $auth->showLogin();
}
