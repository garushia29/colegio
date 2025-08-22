<?php
/**
 * Controlador para gestionar las operaciones relacionadas con los cursos
 */
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../models/Estudiante.php';

class CursoController {
    private $pdo;
    private $cursoModel;
    private $estudianteModel;

    /**
     * Constructor del controlador
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->cursoModel = new Curso($pdo);
        $this->estudianteModel = new Estudiante($pdo);
    }

    /**
     * Mostrar lista de cursos
     * @return void
     */
    public function index() {
        // Obtener todos los cursos
        $cursos = $this->cursoModel->getAll();
        
        // Obtener mensajes de sesión
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        // Cargar la vista
        include __DIR__ . '/../views/cursos/index.php';
    }

    /**
     * Mostrar formulario para crear curso
     * @return void
     */
    public function create() {
        // Obtener mensajes de sesión
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        // Cargar la vista
        include __DIR__ . '/../views/cursos/create.php';
    }
    
    /**
     * Obtener y limpiar un mensaje de sesión
     * @param string $key Clave del mensaje en la sesión
     * @return string|null Mensaje o null si no existe
     */
    private function getSessionMessage($key) {
        $message = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return $message;
    }

    /**
     * Guardar nuevo curso
     * @return void
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos de entrada
            if (empty($_POST['grado']) || empty($_POST['seccion'])) {
                $_SESSION['error'] = 'Los campos Grado y Sección son obligatorios';
                header('Location: /agregar_curso.php');
                exit;
            }
            
            // Preparar datos
            $data = [
                'grado' => $_POST['grado'],
                'seccion' => $_POST['seccion'],
                'descripcion' => isset($_POST['descripcion']) ? $_POST['descripcion'] : '',
                'año_escolar' => isset($_POST['año_escolar']) ? $_POST['año_escolar'] : date('Y')
            ];

            // Intentar crear el curso
            $result = $this->cursoModel->create($data);
            if ($result) {
                $_SESSION['success'] = 'Curso creado correctamente';
                header('Location: /index.php');
                exit;
            } else {
                $_SESSION['error'] = 'Error al crear el curso';
                header('Location: /agregar_curso.php');
                exit;
            }
        } else {
            // Si no es POST, redirigir
            header('Location: /agregar_curso.php');
            exit;
        }
    }
    
    /**
     * Mostrar estudiantes de un curso específico
     * @param int $id ID del curso
     * @return void
     */
    public function showStudents($id) {
        // Validar ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = 'ID de curso no válido';
            header('Location: /index.php');
            exit;
        }
        
        // Obtener el curso
        $curso = $this->cursoModel->getById($id);
        if (!$curso) {
            $_SESSION['error'] = 'El curso no existe';
            header('Location: /index.php');
            exit;
        }
        
        // Obtener estudiantes del curso
        $estudiantes = $this->estudianteModel->getByCurso($id);
        
        // Obtener mensajes de sesión
        $error = $this->getSessionMessage('error');
        $success = $this->getSessionMessage('success');
        
        // Cargar la vista
        include __DIR__ . '/../views/estudiantes/por_curso.php';
    }

    /**
     * Mostrar formulario para editar curso
     * @param int $id ID del curso a editar
     * @return void
     */
    public function edit($id) {
        // Validar ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = 'ID de curso inválido';
            header('Location: /index.php');
            exit;
        }
        
        // Obtener datos del curso
        $curso = $this->cursoModel->getById($id);
        if (!$curso) {
            $_SESSION['error'] = 'Curso no encontrado';
            header('Location: /index.php');
            exit;
        }
        
        // Obtener mensajes de error si existen
        $error = $this->getSessionMessage('error');
        
        // Cargar la vista
        include __DIR__ . '/../views/cursos/edit.php';
    }

    /**
     * Actualizar curso
     * @param int $id ID del curso a actualizar
     * @return void
     */
    public function update($id) {
        // Validar ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = 'ID de curso inválido';
            header('Location: /index.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos de entrada
            if (empty($_POST['grado']) || empty($_POST['seccion'])) {
                $_SESSION['error'] = 'Todos los campos son obligatorios';
                header('Location: /editar_curso.php?id=' . $id);
                exit;
            }
            
            // Preparar datos
            $data = [
                'grado' => $_POST['grado'],
                'seccion' => $_POST['seccion']
            ];

            // Intentar actualizar el curso
            $result = $this->cursoModel->update($id, $data);
            if ($result) {
                $_SESSION['success'] = 'Curso actualizado correctamente';
                header('Location: /index.php');
                exit;
            } else {
                $_SESSION['error'] = 'Error al actualizar el curso';
                header('Location: /editar_curso.php?id=' . $id);
                exit;
            }
        } else {
            // Si no es POST, redirigir
            header('Location: /editar_curso.php?id=' . $id);
            exit;
        }
    }

    /**
     * Eliminar curso
     * @param int $id ID del curso a eliminar
     * @return void
     */
    public function delete($id) {
        // Validar ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = 'ID de curso inválido';
            header('Location: /index.php');
            exit;
        }
        
        // Verificar que el curso existe
        $curso = $this->cursoModel->getById($id);
        if (!$curso) {
            $_SESSION['error'] = 'Curso no encontrado';
            header('Location: /index.php');
            exit;
        }
        
        // Intentar eliminar el curso
        $result = $this->cursoModel->delete($id);
        if ($result) {
            $_SESSION['success'] = 'Curso eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el curso';
        }
        header('Location: /index.php');
        exit;
    }
}