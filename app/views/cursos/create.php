<?php
session_start();
require_once 'config/database.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Conectar a la base de datos
$db = $database->getConnection();

$success = '';
$error = '';

if ($_POST) {
    $grado = trim($_POST['grado'] ?? '');
    $seccion = strtoupper(trim($_POST['seccion'] ?? ''));
    $descripcion = trim($_POST['descripcion'] ?? '');
    $año_escolar = trim($_POST['año_escolar'] ?? '2025');
    
    if (empty($grado) || empty($seccion)) {
        $error = 'Por favor, complete todos los campos obligatorios.';
    } else {
        try {
            // Verificar si el curso ya existe
            $query = "SELECT id FROM cursos WHERE grado = :grado AND seccion = :seccion";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':grado', $grado);
            $stmt->bindParam(':seccion', $seccion);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $error = 'Ya existe un curso con esos datos.';
            } else {
                // Insertar nuevo curso
                $query = "INSERT INTO cursos (grado, seccion, descripcion, año_escolar) VALUES (:grado, :seccion, :descripcion, :año_escolar)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':grado', $grado);
                $stmt->bindParam(':seccion', $seccion);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':año_escolar', $año_escolar);
                $stmt->bindParam(':año_escolar', $año_escolar);
                
                if ($stmt->execute()) {
                    $success = 'Curso creado exitosamente.';
                    // Limpiar formulario
                    $_POST = array();
                } else {
                    $error = 'Error al crear el curso.';
                }
            }
        } catch(PDOException $e) {
            $error = 'Error en la base de datos: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Curso - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #7931ca;
        }
        .navbar-brand {
            color: white !important;
        }
        .img-placeholder {
            width: 50px;
            height: 50px;
            background-color: #e0e0e0;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .img-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body style="background-color: #f5f5f5;">
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <div class="img-placeholder me-2">
                <img src="img/logo.jpeg" alt="Logo">
            </div>
            <a class="navbar-brand" href="index.php">U.E. Marcelino Champagnat I</a>
            <div class="d-flex ms-auto">
                <a class="btn btn-success me-2" href="agregar_curso.php">Agregar Curso</a>
                <a class="btn btn-info me-2" href="gestionar_usuarios.php">Gestionar Usuarios</a>
                <a class="btn btn-danger" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="form-container">
            <h2 class="text-center mb-4" style="color: #4a34a3;">Agregar Nuevo Curso</h2>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
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
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Curso</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="mt-5 p-3 text-center" style="background-color: #7931ca; color: white;">
        <p>Derechos De Autor &copy; Fernanda Garrón y Massiel Espíndola 2025</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
