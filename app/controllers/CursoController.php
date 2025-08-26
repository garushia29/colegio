<?php
require_once __DIR__ . '/../models/Curso.php';

require_once __DIR__ . '/../libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;


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

         $estudiantes = $this->cursoModel->getEstudiantes($id);

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


    public function pdf()
    {
        $cursoId = $_GET['id'] ?? null;
        if (!$cursoId) {
            $_SESSION['error'] = "ID de curso no especificado.";
            header("Location: " . URL . "public/cursos");
            exit;
        }

        $curso = $this->cursoModel->getCursoConEstudiantes($cursoId);

        if (!$curso) {
            $_SESSION['error'] = "Curso no encontrado.";
            header("Location: " . URL . "public/cursos");
            exit;
        }

        // Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // HTML del reporte
        $html = '
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #2C3E50; margin-bottom: 10px; }
        h2 { color: #34495E; margin-top: 20px; }
        p { text-align: center; font-size: 12px; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #555; padding: 6px; text-align: left; font-size: 11px; }
        th { background-color: #f2f2f2; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #777; }
    </style>

    <h1>Reporte del Curso</h1>
    <p><strong>Curso:</strong> ' . htmlspecialchars($curso['grado'] . ' "' . $curso['seccion'] . '"') . '</p>
    <p><strong>Año Escolar:</strong> ' . htmlspecialchars($curso['año_escolar']) . '</p>

    <h2>Listado de Estudiantes</h2>
    <table>
        <thead>
            <tr>
                <th style="width:5%;">N°</th>
                <th style="width:35%;">Nombre Completo</th>
                <th style="width:30%;">Contactos</th>
                <th style="width:30%;">Dirección</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($curso['estudiantes'] as $i => $est) {
            $html .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>" . htmlspecialchars($est['nombre'] ?? '') . "</td>
            <td>" . htmlspecialchars(($est['telefono'] ?? '-') . ' - ' . ($est['email_tutor'] ?? '-')) . "</td>
            <td>" . htmlspecialchars($est['direccion'] ?? '-') . "</td>
        </tr>";
        }

        $html .= '
        </tbody>
    </table>

    <div class="footer">
        <p>Generado automáticamente el ' . date('d/m/Y H:i') . '</p>
    </div>';

        // Renderizar PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Curso_' . $curso['grado'] . '_' . $curso['seccion'] . '.pdf', ['Attachment' => true]);
    }
}
