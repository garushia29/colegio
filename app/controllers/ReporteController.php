<?php
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../libs/tcpdf/tcpdf.php';


class ReporteController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Generar reporte de todos los estudiantes con su curso
     */
    public function estudiantesConCurso()
    {
        $estudianteModel = new Estudiante($this->pdo);
        $estudiantes = $estudianteModel->getAll();

        // Crear nuevo PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Configurar información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Colegio');
        $pdf->SetTitle('Reporte de Estudiantes por Curso');
        $pdf->SetSubject('Lista de todos los estudiantes con sus cursos respectivos');
        
        // Configurar márgenes
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        
        // Configurar salto de página automático
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        // Configurar fuente
        $pdf->SetFont('helvetica', '', 10);
        
        // Agregar página
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'REPORTE DE ESTUDIANTES POR CURSO', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Fecha de generación: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
        $pdf->Ln(10);
        
        // Encabezados de tabla
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        // $pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
        // $pdf->Cell(25, 8, 'Número', 1, 0, 'C', true);
        $pdf->Cell(70, 8, 'Nombre Completo', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'CI', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Curso', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Teléfono', 1, 1, 'C', true);
        
        // Datos de estudiantes
        $pdf->SetFont('helvetica', '', 9);
        foreach ($estudiantes as $estudiante) {
            $nombreCompleto = $estudiante['nombre'] . ' ' . $estudiante['apellido_paterno'] . ' ' . ($estudiante['apellido_materno'] ?? '');
            $curso = ($estudiante['grado'] ?? 'N/A') . ' - ' . ($estudiante['seccion'] ?? 'N/A');
            
            // $pdf->Cell(15, 6, $estudiante['id'], 1, 0, 'C');
            // $pdf->Cell(25, 6, $estudiante['numero'] ?? 'N/A', 1, 0, 'C');
            $pdf->Cell(70, 6, substr($nombreCompleto, 0, 30), 1, 0, 'L');
            $pdf->Cell(25, 6, $estudiante['ci'] ?? 'N/A', 1, 0, 'C');
            $pdf->Cell(40, 6, $curso, 1, 0, 'C');
            $pdf->Cell(25, 6, $estudiante['telefono'] ?? 'N/A', 1, 1, 'C');
        }
        
        // Estadísticas
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'ESTADÍSTICAS', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'Total de estudiantes: ' . count($estudiantes), 0, 1, 'L');
        
        // Salida del PDF
        $pdf->Output('reporte_estudiantes_' . date('Y-m-d') . '.pdf', 'D');
    }

    /**
     * Generar reporte por curso con sus estudiantes
     */
    public function estudiantesPorCurso()
    {
        $cursoModel = new Curso($this->pdo);
        $cursos = $cursoModel->getAll();

        // Crear nuevo PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Configurar información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Colegio');
        $pdf->SetTitle('Reporte de Estudiantes por Curso');
        $pdf->SetSubject('Lista de estudiantes agrupados por curso');
        
        // Configurar márgenes
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        
        // Configurar salto de página automático
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        // Configurar fuente
        $pdf->SetFont('helvetica', '', 10);
        
        // Agregar página
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'REPORTE DE ESTUDIANTES POR CURSO', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Fecha de generación: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
        $pdf->Ln(10);
        
        $totalEstudiantes = 0;
        
        foreach ($cursos as $curso) {
            // Obtener estudiantes del curso
            $estudiantes = $cursoModel->getEstudiantes($curso['id']);
            $totalEstudiantes += count($estudiantes);
            
            // Título del curso
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->SetFillColor(200, 220, 255);
            $pdf->Cell(0, 10, $curso['grado'] . ' - ' . $curso['seccion'] . ' (' . count($estudiantes) . ' estudiantes)', 1, 1, 'C', true);
            $pdf->Ln(2);
            
            if (count($estudiantes) > 0) {
                // Encabezados de tabla
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->SetFillColor(230, 230, 230);
                // $pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
                // $pdf->Cell(25, 8, 'Número', 1, 0, 'C', true);
                $pdf->Cell(70, 8, 'Nombre Completo', 1, 0, 'C', true);
                $pdf->Cell(25, 8, 'CI', 1, 0, 'C', true);
                $pdf->Cell(55, 8, 'Tutor', 1, 1, 'C', true);
                
                // Datos de estudiantes
                $pdf->SetFont('helvetica', '', 9);
                foreach ($estudiantes as $estudiante) {
                    $nombreCompleto = $estudiante['nombre'] . ' ' . $estudiante['apellido_paterno'] . ' ' . ($estudiante['apellido_materno'] ?? '');
                    
                    // $pdf->Cell(15, 6, $estudiante['id'], 1, 0, 'C');
                    // $pdf->Cell(25, 6, $estudiante['numero'] ?? 'N/A', 1, 0, 'C');
                    $pdf->Cell(70, 6, substr($nombreCompleto, 0, 35), 1, 0, 'L');
                    $pdf->Cell(25, 6, $estudiante['ci'] ?? 'N/A', 1, 0, 'C');
                    $pdf->Cell(55, 6, substr($estudiante['tutor_nombre'] ?? 'N/A', 0, 30), 1, 1, 'L');
                }
            } else {
                $pdf->SetFont('helvetica', 'I', 10);
                $pdf->Cell(0, 8, 'No hay estudiantes registrados en este curso', 1, 1, 'C');
            }
            
            $pdf->Ln(8);
        }
        
        // Estadísticas generales
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'ESTADÍSTICAS GENERALES', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'Total de cursos: ' . count($cursos), 0, 1, 'L');
        $pdf->Cell(0, 6, 'Total de estudiantes: ' . $totalEstudiantes, 0, 1, 'L');
        
        // Salida del PDF
        $pdf->Output('reporte_cursos_estudiantes_' . date('Y-m-d') . '.pdf', 'D');
    }

    /**
     * Mostrar página de reportes
     */
    public function index()
    {
        include __DIR__ . '/../views/reportes/index.php';
    }
}