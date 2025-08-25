<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo URL; ?>public/css/cursos_create.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">    
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
</head>
<body>
    <?php include __DIR__ . '/../components/navbarEstudiante.php'; ?>
    <div class="container"> 
        <div class="row mb-3">
            <div class="col">
                <h2>Agregar Nuevo Estudiante</h2>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="<?php echo URL; ?>public/estudiantes/store" method="POST" class="mb-4">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero">
                </div>
                <div class="col-md-4">
                    <label for="ci" class="form-label">Cédula / CI *</label>
                    <input type="text" class="form-control" id="ci" name="ci" required>
                </div>
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-4">
                    <label for="apellido_paterno" class="form-label">Apellido Paterno *</label>
                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="apellido_materno" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno">
                </div>
                <div class="col-md-6">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="genero" class="form-label">Género *</label>
                    <select class="form-select" id="genero" name="genero" required>
                        <option value="">Seleccione...</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>
                <div class="col-md-6">
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

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono">
                </div>
                
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
            </div>

            <h5>Información del Tutor</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre_tutor" class="form-label">Nombre del Tutor *</label>
                    <input type="text" class="form-control" id="nombre_tutor" name="nombre_tutor" required>
                </div>
                <div class="col-md-6">
                    <label for="telefono_tutor" class="form-label">Teléfono del Tutor</label>
                    <input type="tel" class="form-control" id="telefono_tutor" name="telefono_tutor">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email_tutor" class="form-label">Email del Tutor</label>
                    <input type="email" class="form-control" id="email_tutor" name="email_tutor">
                </div>
               
            </div>        

            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo URL; ?>public/estudiantes" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Estudiante</button>
            </div>
        </form>
    </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
