<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo URL; ?>public/css/cursos_create.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">    
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
</head>

<body>
    
    <?php include __DIR__ . '/../components/navbar.php';
    ?>
    <h2>Crear Usuario</h2>
    <?php if (!empty($_SESSION['error'])): ?>
        <div style="color:red"><?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <div class="container mt-4">
        <!-- #region Formulario de Creación de Usuario -->
        <div class="form-container">
            <form method="POST" action="<?php echo URL; ?>public/usuarios/store">
                <div class="row">
                    <div class=" mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Ej: admin / secretaria/ docente"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                        <!-- <small class="form-text text-muted">Ej: admin / secretaria/ docente</small> -->
                    </div>

                    <div class="col-md-6 mb-3">
                        
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="" class="form-control" id="password" name="password"
                        value="<?php echo htmlspecialchars($_POST['password'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                  
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?php echo URL; ?>public/usuarios" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
            
        </div>
    </div>
    <!-- #endregion -->
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>

</html>