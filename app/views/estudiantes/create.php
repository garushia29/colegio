<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiante - Colegio JIM</title>
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
                <h2>Agregar Nuevo Estudiante</h2>
            </div>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="../public/estudiantes/guardar_estudiante.php" method="POST" class="mb-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres *</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos *</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula">
                        <small class="text-muted">Opcional.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="curso_id" class="form-label">Curso *</label>
                        <select class="form-select" id="curso_id" name="curso_id" required>
                            <option value="">Seleccione un curso</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?php echo $curso['id']; ?>">
                                    <?php echo htmlspecialchars($curso['grado'] . ' - ' . $curso['seccion']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                        <small class="text-muted">Opcional.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono">
                        <small class="text-muted">Opcional.</small>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email">
                <small class="text-muted">Opcional.</small>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="3"></textarea>
                <small class="text-muted">Opcional.</small>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="../public/estudiantes/index.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Estudiante</button>
            </div>
        </form>
    </div>

    <footer class="text-center py-3 mt-5 bg-light">
        <p>Sistema de Gestión Escolar - Colegio JIM &copy; <?php echo date('Y'); ?></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>