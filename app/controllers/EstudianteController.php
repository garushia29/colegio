<?php

/**
 * Controlador para la gestión de estudiantes
 */

require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../models/Estudiante.php';
class EstudianteController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $search = $_GET['search'] ?? '';
        $estudianteModel = new Estudiante($this->pdo);

        if (!empty($search)) {
            $estudiantes = $estudianteModel->search($search);
        } else {
            $estudiantes = $estudianteModel->getAll();
        }

        include __DIR__ . '/../views/estudiantes/index.php';
    }


    public function create()
    {
        $cursoModel = new Curso($this->pdo);
        $cursos = $cursoModel->getAll();
        include __DIR__ . '/../views/estudiantes/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos recibidos desde el formulario
            $numero            = $_POST['numero'] ?? '';
            $ci                = $_POST['ci'] ?? '';
            $nombre            = $_POST['nombre'] ?? '';
            $apellido_paterno  = $_POST['apellido_paterno'] ?? '';
            $apellido_materno  = $_POST['apellido_materno'] ?? '';
            $fecha_nacimiento  = $_POST['fecha_nacimiento'] ?? '';
            $genero            = trim($_POST['genero']) ?? '';
            $direccion         = $_POST['direccion'] ?? '';
            $telefono          = $_POST['telefono'] ?? '';
            $nombre_tutor      = $_POST['nombre_tutor'] ?? '';
            $telefono_tutor   = $_POST['telefono_tutor'] ?? '';
            $email_tutor      = $_POST['email_tutor'] ?? '';
            $curso_id          = $_POST['curso_id'] ?? '';
            $estado            = $_POST['estado'] ?? 'activo'; //por defecto activo (1)

            
            if (!in_array($genero, ['masculino', 'femenino'])) {
                $_SESSION['error'] = 'Seleccione un género válido';
                header("Location: " . URL . "public/estudiantes/create");
                exit;
            }

            // Campo calculado: nombre completo
            $nombre_completo = trim($nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno);

            // Validaciones básicas
            if (empty($nombre) || empty($apellido_paterno) || empty($curso_id)) {
                $_SESSION['error'] = 'Nombre, Apellido Paterno y Curso son obligatorios';
                header("Location: " . URL . "public/estudiantes/create");
                exit;
            }


            // Crear registro
            $estudianteModel = new Estudiante($this->pdo);
            $result = $estudianteModel->create([
                'numero'           => $numero,
                'ci'               => $ci,
                'nombre'           => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'fecha_nacimiento' => $fecha_nacimiento,
                'genero'           => $genero,
                'direccion'        => $direccion,
                'telefono'         => $telefono,
                'nombre_tutor'     => $nombre_tutor,
                'telefono_tutor'   => $telefono_tutor,
                'email_tutor'      => $email_tutor,
                'curso_id'         => $curso_id,
                'estado'           => $estado
            ]);

            // Redirección con mensaje
            if ($result) {
                $_SESSION['success'] = 'Estudiante creado correctamente';
            } else {
                $_SESSION['error'] = 'Error al crear estudiante';
            }

            header("Location: " . URL . "public/estudiantes");
            exit;
        }
    }

    public function show($id)
    {
        if (!$id) {
            header("Location: " . URL . "public/estudiantes");
            exit;
        }

        $estudianteModel = new Estudiante($this->pdo);
        $estudiante = $estudianteModel->getById($id);

        if (!$estudiante) {
            $_SESSION['error'] = 'El estudiante no existe';
            header("Location: " . URL . "public/estudiantes");
            exit;
        }

        include __DIR__ . '/../views/estudiantes/show.php';
    }

    public function edit($id)
    {
        if (!$id) {
            header("Location: " . URL . "public/estudiantes");
            exit;
        }

        $estudianteModel = new Estudiante($this->pdo);
        $estudiante = $estudianteModel->getById($id);

        if (!$estudiante) {
            $_SESSION['error'] = 'El estudiante no existe';
            header("Location: " . URL . "public/estudiantes");
            exit;
        }

        // Cargar cursos para el formulario
        $cursoModel = new Curso($this->pdo);
        $cursos = $cursoModel->getAll();

        include __DIR__ . '/../views/estudiantes/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID del estudiante no definido';
                header("Location: " . URL . "public/estudiantes");
                exit;
            }

            $estudianteModel = new Estudiante($this->pdo);
            $result = $estudianteModel->update($id, $_POST);

            if ($result) {
                $_SESSION['success'] = 'Estudiante actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar estudiante';
            }

            header("Location: " . URL . "public/estudiantes");
            exit;
        }
    }

    public function delete($id)
    {
        if (!$id) {
            header("Location: " . URL . "public/estudiantes");
            exit;
        }

        $estudianteModel = new Estudiante($this->pdo);
        $estudianteModel->delete($id);

        $_SESSION['success'] = 'Estudiante eliminado correctamente';
        header("Location: " . URL . "public/estudiantes");
        exit;
    }
}
