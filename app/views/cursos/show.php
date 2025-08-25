<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Curso: <?= htmlspecialchars($curso['grado'] . ' ' . $curso['seccion']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?= URL ?>public/css/style_index.css">
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <div class="container mt-4">
        <h2>Curso: <?= htmlspecialchars($curso['grado'] . ' ' . $curso['seccion']); ?></h2>
        <p><strong>Año escolar:</strong> <?= htmlspecialchars($curso['año_escolar']); ?></p>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($curso['descripcion']); ?></p>
        
        <a href="<?php echo URL; ?>public/cursos/edit?id=<?php echo $curso['id']; ?>" class="btn btn-primary">Editar Curso</a>
        <h3 class="mt-4">Estudiantes del curso</h3>

        <!-- Formulario de búsqueda -->
        <form method="GET" class="mb-3 d-flex gap-2 align-items-center">
            <input type="hidden" name="controller" value="Curso">
            <input type="hidden" name="action" value="show">
            <input type="hidden" name="id" value="<?= $curso['id'] ?>">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o apellido"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button class="btn btn-primary btn-sm" type="submit">Buscar</button>
        </form>

        <?php if (!empty($estudiantes)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono Emergencia</th>
                        <th>Email</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): ?>
                        <tr>
                            <td><?= $est['id']; ?></td>
                            <td><?= htmlspecialchars($est['nombre'] ?? ''); ?></td>
                            <td><?= htmlspecialchars(($est['apellido_paterno'] ?? '') . ' ' . ($est['apellido_materno'] ?? '')); ?></td>
                            <td><?= htmlspecialchars($est['telefono_tutor'] ?? 'Sin contacto'); ?></td>
                            <td><?= htmlspecialchars($est['email_tutor'] ?? 'Sin correo'); ?></td>
                            <td></td>
                            <td>
                                <a href="<?php echo URL; ?>public/estudiantes/show?id=<?php echo $est['id']; ?>" class="btn btn-sm btn-primary">
                                    Ver Estudiante
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Paginación -->
            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link"
                                   href="<?= URL ?>public/index.php?controller=Curso&action=show&id=<?= $curso['id'] ?>&search=<?= urlencode($search) ?>&page=<?= $i ?>">
                                    <?= $i ?>
                                </a>                               
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>

        <?php else: ?>
            <p>No hay estudiantes asignados a este curso.</p>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
