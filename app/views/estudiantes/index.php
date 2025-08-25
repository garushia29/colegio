<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes - Colegio JIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="<?= URL ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?= URL ?>public/css/style_index.css">
    <link rel="stylesheet" href="<?= URL ?>public/css/footer.css">
    <link rel="stylesheet" href="../public/css/cards.css">
</head>
<body>
           <?php include __DIR__ . '/../components/navbarEstudiante.php'; ?>

    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h2>Lista de Estudiantes</h2>
            </div>
            <div class="col-auto">
                <a href="<?php echo URL; ?>public/estudiantes/create" class="btn btn-primary">Agregar Estudiante</a>
            </div>
        </div>

        <!-- Barra de búsqueda -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="<?php echo URL; ?>public/estudiantes" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Buscar por nombre, apellidos o cédula..." 
                           value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="btn btn-outline-secondary">Buscar</button>
                    <?php if (!empty($_GET['search'])): ?>
                        <a href="<?php echo URL; ?>public/estudiantes" class="btn btn-outline-danger ms-2">Limpiar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if (!empty($_GET['search'])): ?>
            <div class="alert alert-info">
                Resultados de búsqueda para: "<strong><?php echo htmlspecialchars($_GET['search']); ?></strong>"
                (<?php echo count($estudiantes); ?> resultado<?php echo count($estudiantes) != 1 ? 's' : ''; ?>)
            </div>
        <?php endif; ?>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (empty($estudiantes)): ?>
            <div class="alert alert-info">No hay estudiantes registrados.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Apellidos</th>
                            <th>Nombres</th>
                            <th>Cédula</th>
                            <th>Curso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $estudiante): ?>
                            <tr>
                                <td><?php echo $estudiante['id']; ?></td>
                                <td><?php echo htmlspecialchars($estudiante['apellido_paterno'].' '.$estudiante['apellido_materno']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['ci'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php 
                                    if (isset($estudiante['grado']) && isset($estudiante['seccion'])) {
                                        echo htmlspecialchars($estudiante['grado'] . ' - ' . $estudiante['seccion']);
                                    } else {
                                        echo 'Sin asignar';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo URL; ?>public/estudiantes/show?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-info">Ver</a>
                                    <a href="<?php echo URL; ?>public/estudiantes/edit?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="<?php echo URL; ?>public/estudiantes/delete?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este estudiante?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
