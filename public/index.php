<?php
session_start();

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/AuthMiddleware.php';

// Verificar autenticación (solo en páginas privadas)
AuthMiddleware::checkAuth();

$db = getPDOConnection();

try {
    $query = "SELECT c.*, COUNT(e.id) as total_estudiantes 
              FROM cursos c 
              LEFT JOIN estudiantes e ON c.id = e.curso_id 
              GROUP BY c.id 
              ORDER BY c.grado, c.seccion";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $cursos = [];
    $error = "Error al cargar cursos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Cursos - Garrón y Massiel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/cards.css">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">
</head>
<body>
<?php include __DIR__ . '/components/navbar.php'; ?>

<h2 class="text-center mt-4">Cursos</h2>

<?php if(isset($error)): ?>
  <div class="alert alert-danger text-center"><?php echo $error; ?></div>
<?php endif; ?>

<div class="container mt-4">
  <?php if(!empty($cursos)): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      require_once __DIR__ . '/components/curso_cards.php';
      foreach($cursos as $curso): 
          mostrarTarjetaCurso($curso);
      endforeach; 
      ?>
    </div>
  <?php else: ?>
    <div class="text-center">
      <div class="alert alert-info">
        <p>No hay cursos guardados.</p>
        <a href="#" class="btn btn-primary">Crear Primer Curso</a>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php include __DIR__ . '/components/footer.php'; ?>
</body>
</html>
