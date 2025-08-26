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
                <h2>Lista de Usuarios</h2>
            </div>
            <div class="col-auto">
                <a href="<?php echo URL; ?>public/usuarios/create" class="btn btn-primary">Agregar Usuario</a>
            </div>
        </div>



        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (empty($usuarios)): ?>
            <div class="alert alert-info">No hay usuarios registrados.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>

                            <th>Nombre</th>


                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo htmlspecialchars($usuario['username']); ?></td>


                                <td>
                                   
                                    <a href="<?php echo URL; ?>public/usuarios/edit?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="<?php echo URL; ?>public/usuarios/delete?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este estudiante?')">Eliminar</a>
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