<?php
/**
 * Controlador para la gestión de estudiantes
 */
class EstudianteController {
    private $pdo;
    private $estudianteModel;
    private $cursoModel;

    /**
     * Constructor del controlador
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../models/Estudiante.php';
        require_once __DIR__ . '/../models/Curso.php';
        $this->estudianteModel = new Estudiante($pdo);
        $this->cursoModel = new Curso($pdo);
    }

    /**
     * Obtener mensaje de sesión y eliminarlo
     * @param string $key Clave del mensaje en la sesión
     * @return string|null Mensaje almacenado o null si no existe
     */
    private function getSessionMessage($key) {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        }
        return null;
    }

    /**
     * Mostrar la lista de estudiantes
     */
    public function index() {
        $estudiantes = $this->estudianteModel->getAll();
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        require_once __DIR__ . '/../views/estudiantes/index.php';
    }

    /**
     * Mostrar estudiantes de un curso específico
     * @param int $cursoId ID del curso
     */
    public function showByCurso($cursoId) {
        $curso = $this->cursoModel->getById($cursoId);
        if (!$curso) {
            $_SESSION['error'] = 'El curso no existe';
            header('Location: /index.php');
            exit;
        }
        
        $estudiantes = $this->estudianteModel->getByCurso($cursoId);
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        require_once __DIR__ . '/../views/estudiantes/por_curso.php';
    }

    /**
     * Mostrar formulario para crear un nuevo estudiante
     */
    public function create() {
        $cursos = $this->cursoModel->getAll();
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        require_once __DIR__ . '/../views/estudiantes/create.php';
    }

    /**
     * Guardar un nuevo estudiante
     */
    public function store() {
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Método no permitido';
            header('Location: /estudiantes/agregar_estudiante.php');
            exit;
        }

        // Validar datos obligatorios
        if (empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['curso_id'])) {
            $_SESSION['error'] = 'Los campos Nombres, Apellidos y Curso son obligatorios';
            header('Location: /estudiantes/agregar_estudiante.php');
            exit;
        }

        // Validar que el curso exista
        $curso_id = filter_var($_POST['curso_id'], FILTER_VALIDATE_INT);
        $curso = $this->cursoModel->getById($curso_id);
        if (!$curso) {
            $_SESSION['error'] = 'El curso seleccionado no existe';
            header('Location: /estudiantes/agregar_estudiante.php');
            exit;
        }

        // Crear el estudiante
        $result = $this->estudianteModel->create([
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'curso_id' => $curso_id,
            'cedula' => $_POST['cedula'] ?? null,
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
            'telefono' => $_POST['telefono'] ?? null,
            'email' => $_POST['email'] ?? null
        ]);

        if ($result) {
            $_SESSION['success'] = 'Estudiante agregado correctamente';
            header('Location: /estudiantes/index.php');
        } else {
            $_SESSION['error'] = 'Error al agregar el estudiante';
            header('Location: /estudiantes/agregar_estudiante.php');
        }
        exit;
    }

    /**
     * Mostrar formulario para editar un estudiante
     * @param int $id ID del estudiante
     */
    public function edit($id) {
        $estudiante = $this->estudianteModel->getById($id);
        if (!$estudiante) {
            $_SESSION['error'] = 'El estudiante no existe';
            header('Location: /estudiantes/index.php');
            exit;
        }
        
        $cursos = $this->cursoModel->getAll();
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        require_once __DIR__ . '/../views/estudiantes/edit.php';
    }

    /**
     * Actualizar un estudiante existente
     * @param int $id ID del estudiante
     */
    public function update($id) {
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Método no permitido';
            header('Location: /estudiantes/index.php');
            exit;
        }

        // Validar que el estudiante exista
        $estudiante = $this->estudianteModel->getById($id);
        if (!$estudiante) {
            $_SESSION['error'] = 'El estudiante no existe';
            header('Location: /estudiantes/index.php');
            exit;
        }

        // Validar datos obligatorios
        if (empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['curso_id'])) {
            $_SESSION['error'] = 'Los campos Nombres, Apellidos y Curso son obligatorios';
            header("Location: /estudiantes/editar_estudiante.php?id=$id");
            exit;
        }

        // Validar que el curso exista
        $curso_id = filter_var($_POST['curso_id'], FILTER_VALIDATE_INT);
        $curso = $this->cursoModel->getById($curso_id);
        if (!$curso) {
            $_SESSION['error'] = 'El curso seleccionado no existe';
            header("Location: /estudiantes/editar_estudiante.php?id=$id");
            exit;
        }

        // Actualizar el estudiante
        $result = $this->estudianteModel->update($id, [
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'curso_id' => $curso_id,
            'cedula' => $_POST['cedula'] ?? null,
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
            'telefono' => $_POST['telefono'] ?? null,
            'email' => $_POST['email'] ?? null
        ]);

        if ($result) {
            $_SESSION['success'] = 'Estudiante actualizado correctamente';
            header('Location: /estudiantes/index.php');
        } else {
            $_SESSION['error'] = 'Error al actualizar el estudiante';
            header("Location: /estudiantes/editar_estudiante.php?id=$id");
        }
        exit;
    }

    /**
     * Eliminar un estudiante
     * @param int $id ID del estudiante
     */
    public function delete($id) {
        // Verificar que el estudiante exista
        $estudiante = $this->estudianteModel->getById($id);
        if (!$estudiante) {
            $_SESSION['error'] = 'El estudiante no existe';
            header('Location: /estudiantes/index.php');
            exit;
        }

        // Eliminar el estudiante
        $result = $this->estudianteModel->delete($id);

        if ($result) {
            $_SESSION['success'] = 'Estudiante eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el estudiante';
        }
        
        header('Location: /estudiantes/index.php');
        exit;
    }
}