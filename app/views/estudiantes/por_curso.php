<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes del Curso - Colegio JIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style_index.css">
</head>
<body>
    <div class="container">
        <header class="d-flex justify-content-between align-items-center py-3">
            <div>
                <img src="../public/img/logo.jpeg" alt="Logo Colegio JIM" class="logo">
            </div>
            <h1 class="text-center">Sistema de Gestión Escolar</h1>
            <div></div>
        </header>

        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../public/index.php">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../public/estudiantes/index.php">Estudiantes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row mb-3">
            <div class="col">
                <h2>Estudiantes del Curso: <?php echo htmlspecialchars($curso['grado'] . ' - ' . $curso['seccion']); ?></h2>
            </div>
            <div class="col-auto">
                <a href="../public/estudiantes/agregar_estudiante.php?curso_id=<?php echo $curso['id']; ?>" class="btn btn-primary">Agregar Estudiante</a>
                <a href="../public/index.php" class="btn btn-secondary">Volver a Cursos</a>
            </div>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (empty($estudiantes)): ?>
            <div class="alert alert-info">No hay estudiantes registrados en este curso.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Apellidos</th>
                            <th>Nombres</th>
                            <th>Cédula</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $estudiante): ?>
                            <tr>
                                <td><?php echo $estudiante['id']; ?></td>
                                <td><?php echo htmlspecialchars($estudiante['apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['nombres']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['cedula'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="../public/estudiantes/ver_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-info">Ver</a>
                                    <a href="../public/estudiantes/editar_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="../public/estudiantes/eliminar_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este estudiante?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center py-3 mt-5 bg-light">
        <p>Sistema de Gestión Escolar - Colegio JIM &copy; <?php echo date('Y'); ?></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>