<?php
require_once __DIR__ . '/../controllers/CursoController.php';
require_once __DIR__ . '/../controllers/EstudianteController.php';

require_once __DIR__ . '/../controllers/AuthController.php';

class Router {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function route($path) {
        switch ($path) {
            // Login
            case '/colegio_jim/public/login':
                $controller = new AuthController($this->pdo);
                $controller->showLogin();
                break;

            case '/colegio_jim/public/login/submit':
                $controller = new AuthController($this->pdo);
                $controller->login($_POST['username'] ?? '', $_POST['password'] ?? '');
                break;

            case '/colegio_jim/public/logout':
                $controller = new AuthController($this->pdo);
                $controller->logout();
                break;

            // Cursos
            case '/colegio_jim/public/cursos':
                $controller = new CursoController($this->pdo);
                $controller->index();
                break;

            case '/colegio_jim/public/cursos/create':
                $controller = new CursoController($this->pdo);
                $controller->create();
                break;

            case '/colegio_jim/public/cursos/store':
                $controller = new CursoController($this->pdo);
                $controller->store();
                break;

            case '/colegio_jim/public/cursos/edit':
                $controller = new CursoController($this->pdo);
                $controller->edit($_GET['id'] ?? null);
                break;

            case '/colegio_jim/public/cursos/update':
                $controller = new CursoController($this->pdo);
                $controller->update($_POST['id'] ?? null, $_POST);
                break;
            case '/colegio_jim/public/cursos/show':
                $controller = new CursoController($this->pdo);
                $controller->show($_GET['id'] ?? null);
                break;
            // Estudiantes
            case '/colegio_jim/public/estudiantes':
                $controller = new EstudianteController($this->pdo);
                $controller->index();
                break;

            default:
                http_response_code(404);
                echo "Página no encontrada";
                break;
        }
    }
}
