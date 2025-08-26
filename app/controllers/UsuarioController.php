<?php

require_once __DIR__ . '/../models/Usuario.php';


class UsuarioController
{
    private $pdo;
    private $usuarioModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($this->pdo);
    }

    public function index()
    {
        $usuarios = $this->usuarioModel->getAll();

        include __DIR__ . '/../views/usuarios/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usuarioModel->create($_POST);
            header("Location: " . URL . "public/usuarios");
            exit;
        }
        include __DIR__ . '/../views/usuarios/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'usuario y password son obligatorios';
                header("Location: " . URL . "public/usuarios/create");
                exit;
            }

            $cursoModel = new Usuario($this->pdo);
            $cursoModel->create([
                'username' => $username,
                'password' => $password,
                
            ]);

            $_SESSION['success'] = 'Usuario creado correctamente';
            header("Location: " . URL . "public/usuarios");
            exit;
        }
    }



    public function edit()
    {
        $id = $_GET['id'];
        $usuario = $this->usuarioModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usuarioModel->update($id, $_POST);
            header("Location: " . URL . "public/usuarios");
            exit;
        }
       
         include __DIR__ . '/../views/usuarios/edit.php';
    }

     public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID del usuario no definido';
                header("Location: " . URL . "public/usuarios");
                exit;
            }

            $data = [
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                
            ];

            $this->usuarioModel->update($id, $data);

            $_SESSION['success'] = 'Usuario actualizado correctamente';
            header("Location: " . URL . "public/usuarios");
            exit;
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->usuarioModel->delete($id);
        header("Location: " . URL . "public/usuarios");
        exit;
    }
}
