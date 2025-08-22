<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Estudiante - Colegio JIM</title>
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
                <h2>Detalles del Estudiante</h2>
            </div>
            <div class="col-auto">
                <a href="../public/estudiantes/editar_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-warning">Editar</a>
                <a href="../public/estudiantes/index.php" class="btn btn-secondary">Volver a la Lista</a>
            </div>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><?php echo htmlspecialchars($estudiante['apellidos'] . ', ' . $estudiante['nombres']); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> <?php echo $estudiante['id']; ?></p>
                        <p><strong>Cédula:</strong> <?php echo htmlspecialchars($estudiante['cedula'] ?? 'No registrada'); ?></p>
                        <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($estudiante['fecha_nacimiento'] ?? 'No registrada'); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($estudiante['telefono'] ?? 'No registrado'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Curso:</strong> <?php echo htmlspecialchars($estudiante['grado'] . ' - ' . $estudiante['seccion']); ?></p>
                        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($estudiante['email'] ?? 'No registrado'); ?></p>
                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($estudiante['direccion'] ?? 'No registrada'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3 mt-5 bg-light">
        <p>Sistema de Gestión Escolar - Colegio JIM &copy; <?php echo date('Y'); ?></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>