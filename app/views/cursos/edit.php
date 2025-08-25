<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Curso - Garrón y Massiel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/cursos_create.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">    
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
</head>
  <style>
    .form-container {
      max-width: 600px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn-primary {
      background-color: #7931ca;
      border-color: #7931ca;
    }
    .btn-primary:hover {
      background-color: #6c3dd1;
      border-color: #6c3dd1;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php';
    ?>

<div class="container mt-4">
  <h2 class="text-center mb-4">Editar Curso</h2>
  
  <?php if(isset($error)): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <div class="form-container">
    <form method="POST" action="<?php echo URL; ?>public/cursos/update">
      <div class="mb-3">
        <label for="grado" class="form-label">Grado:</label>
        <input type="hidden" name="id" value="<?= $curso['id'] ?>">
        <input type="text" class="form-control" id="grado" name="grado" required value="<?php echo htmlspecialchars($curso['grado']); ?>">
      </div>
      <div class="mb-3">
        <label for="seccion" class="form-label">Sección:</label>
        <input type="text" class="form-control" id="seccion" name="seccion" required value="<?php echo htmlspecialchars($curso['seccion']); ?>">
      </div>
      <div class="mb-3">
        <label for="año_escolar" class="form-label">Año Escolar:</label>
        <input type="text" class="form-control" id="año_escolar" name="año_escolar" value="<?php echo htmlspecialchars($curso['año_escolar']); ?>">
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($curso['descripcion']); ?></textarea>
      </div>
      
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Actualizar Curso</button>
        <a href="<?php echo URL; ?>public/cursos" class="btn btn-secondary" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>

  <?php include __DIR__ . '/../components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>