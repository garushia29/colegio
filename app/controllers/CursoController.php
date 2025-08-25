<?php
require_once __DIR__ . '/../models/Curso.php';

class CursoController
{
    private $pdo;
    private $cursoModel;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->cursoModel = new Curso($this->pdo);
    }

    public function index()
    {
        $search = $_GET['search'] ?? '';

        if (!empty($search)) {
            $cursos = $this->cursoModel->search($search);
        } else {
            $stmt = $this->pdo->prepare("SELECT c.*, COUNT(e.id) as total_estudiantes 
                                         FROM cursos c 
                                         LEFT JOIN estudiantes e ON c.id = e.curso_id 
                                         GROUP BY c.id 
                                         ORDER BY c.grado, c.seccion");
            $stmt->execute();
            $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        include __DIR__ . '/../views/cursos/index.php';
    }

    public function create()
    {
        include __DIR__ . '/../views/cursos/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $grado = $_POST['grado'] ?? '';
            $seccion = $_POST['seccion'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $año_escolar = $_POST['año_escolar'] ?? date('Y');

            if (empty($grado) || empty($seccion)) {
                $_SESSION['error'] = 'Grado y Sección son obligatorios';
                header("Location: " . URL . "public/cursos/create");
                exit;
            }

            $cursoModel = new Curso($this->pdo);
            $cursoModel->create([
                'grado' => $grado,
                'seccion' => $seccion,
                'descripcion' => $descripcion,
                'año_escolar' => $año_escolar
            ]);

            $_SESSION['success'] = 'Curso creado correctamente';
            header("Location: " . URL . "public/cursos");
            exit;
        }
    }

    public function edit($id)
    {
        $curso = $this->cursoModel->findById($id);
        include __DIR__ . '/../views/cursos/edit.php'; // ruta correcta
    }

    // Actualizar en la BD
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID del curso no definido';
                header("Location: " . URL . "public/cursos");
                exit;
            }

            $data = [
                'grado' => $_POST['grado'] ?? '',
                'seccion' => $_POST['seccion'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'año_escolar' => $_POST['año_escolar'] ?? date('Y')
            ];

            $this->cursoModel->update($id, $data);

            $_SESSION['success'] = 'Curso actualizado correctamente';
            header("Location: " . URL . "public/cursos");
            exit;
        }
    }
    public function show($id)
    {
        if (!$id) {
            header("Location: " . URL . "public/cursos");
            exit;
        }

        $curso = $this->cursoModel->findById($id);

        // Obtener búsqueda y paginación
        $search = $_GET['search'] ?? '';
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $estudiantes = $this->cursoModel->getEstudiantes($id, $search, $limit, $offset);
        $total = $this->cursoModel->countEstudiantes($id, $search);
        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/cursos/show.php';
    }

    public function delete($id)
    {
        if (!$id) {
            header("Location: " . URL . "public/cursos");
            exit;
        }

        $result = $this->cursoModel->delete($id);

        if ($result) {
            $_SESSION['success'] = 'Curso eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar curso';
        }

        header("Location: " . URL . "public/cursos");
        exit;
    }
}
