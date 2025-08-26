<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Colegio JIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
</head>
<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col">
                <h2>Reportes del Sistema</h2>
                <p class="text-muted">Genere reportes en PDF de estudiantes y cursos</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-users"></i> Reporte de Estudiantes
                        </h5>
                        <p class="card-text">
                            Genere un reporte completo de todos los estudiantes registrados en el sistema, 
                            incluyendo su información personal y el curso al que pertenecen.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Lista completa de estudiantes</li>
                            <li><i class="fas fa-check text-success"></i> Información del curso</li>
                            <li><i class="fas fa-check text-success"></i> Datos de contacto</li>
                            <li><i class="fas fa-check text-success"></i> Estadísticas generales</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo URL; ?>public/reportes/estudiantes-curso" 
                           class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-school"></i> Reporte por Cursos
                        </h5>
                        <p class="card-text">
                            Genere un reporte organizado por cursos, mostrando todos los estudiantes 
                            que pertenecen a cada curso con su información detallada.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Agrupado por curso</li>
                            <li><i class="fas fa-check text-success"></i> Lista de estudiantes por curso</li>
                            <li><i class="fas fa-check text-success"></i> Información del tutor</li>
                            <li><i class="fas fa-check text-success"></i> Estadísticas por curso</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo URL; ?>public/reportes/estudiantes-por-curso" 
                           class="btn btn-success" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Información sobre los reportes:</h6>
                    <ul class="mb-0">
                        <li>Los reportes se generan en tiempo real con la información más actualizada</li>
                        <li>Los archivos PDF se descargan automáticamente al hacer clic en "Generar PDF"</li>
                        <li>Los reportes incluyen la fecha y hora de generación</li>
                        <li>Todos los reportes están optimizados para impresión en formato A4</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>