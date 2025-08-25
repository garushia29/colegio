<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Curso - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo URL; ?>public/css/cursos_create.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">    
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
</head>

<body>
    
    <?php include __DIR__ . '/../components/navbar.php';
    ?>
    <h2>Crear Curso</h2>
    <?php if (!empty($_SESSION['error'])): ?>
        <div style="color:red"><?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <div class="container mt-4">
        <!-- #region Formulario de Creación de Curso -->
        <div class="form-container">
            <form method="POST" action="<?php echo URL; ?>public/cursos/store">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="grado" class="form-label">Grado *</label>
                        <input type="text" class="form-control" id="grado" name="grado"
                            placeholder="Ej: 1ro, 2do, 3ro, 4to, 5to, 6to"
                            value="<?php echo htmlspecialchars($_POST['grado'] ?? ''); ?>" required>
                        <small class="form-text text-muted">Ejemplos: 1ro, 2do, 3ro, 4to, 5to, 6to</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="seccion" class="form-label">Sección *</label>
                        <input type="text" class="form-control" id="seccion" name="seccion"
                            placeholder="Ej: A, B, C"
                            value="<?php echo htmlspecialchars($_POST['seccion'] ?? ''); ?>"
                            maxlength="1" style="text-transform: uppercase;" required>
                        <small class="form-text text-muted">Ejemplos: A, B, C</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="año_escolar" class="form-label">Año Escolar</label>
                    <input type="text" class="form-control" id="año_escolar" name="año_escolar"
                        value="<?php echo htmlspecialchars($_POST['año_escolar'] ?? '2025'); ?>">
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                        placeholder="Descripción opcional del curso"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?php echo URL; ?>public/cursos" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Curso</button>
                </div>
            </form>
            
        </div>
    </div>
    <!-- #endregion -->
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>

</html>