<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Estudiante - Colegio JIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= URL ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?= URL ?>public/css/style_index.css">
    <link rel="stylesheet" href="<?= URL ?>public/css/footer.css">
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <div class="container">

      
        </nav>

        <div class="row mb-3">
            <div class="col">
                <h2>Detalles del Estudiante</h2>
            </div>
            <div class="col-auto">
                <a href="<?php echo URL; ?>public/estudiantes/edit?id=<?php echo $estudiante['id']; ?>" class="btn btn-warning">Editar</a>
                <a href="<?php echo URL; ?>public/estudiantes" class="btn btn-secondary">Volver a la Lista</a>
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
                <h3 class="card-title mb-0"><?php echo htmlspecialchars($estudiante['apellido_paterno'] . ', ' . $estudiante['nombre']); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        
                        <p><strong>Número:</strong> <?php echo htmlspecialchars($estudiante['numero'] ?? 'No asignado'); ?></p>
                        <p><strong>Cédula/CI:</strong> <?php echo htmlspecialchars($estudiante['ci'] ?? 'No registrada'); ?></p>
                        <p><strong>Apellido Materno:</strong> <?php echo htmlspecialchars($estudiante['apellido_materno'] ?? 'No registrado'); ?></p>
                        <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($estudiante['fecha_nacimiento'] ?? 'No registrada'); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($estudiante['telefono'] ?? 'No registrado'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Curso:</strong> <?php echo htmlspecialchars($estudiante['grado'] . ' - ' . $estudiante['seccion']); ?></p>                        
                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($estudiante['direccion'] ?? 'No registrada'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información del Tutor -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h4 class="card-title mb-0">Información del Tutor</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($estudiante['nombre_tutor'] ?? 'No registrado'); ?></p>
                        
                        
                    </div>
                    <div class="col-md-6">
                       <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($estudiante['telefono_tutor'] ?? 'No registrado'); ?></p>
                    </div>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($estudiante['email_tutor'] ?? 'No registrado'); ?></p>
                </div>
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/../components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>