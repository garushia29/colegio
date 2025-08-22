<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Curso - Garrón y Massiel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/style_index.css" />
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

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <div class="img-placeholder me-2">
        <img src="../public/img/logo.jpeg" alt="Marist Logo">
    </div>
    <a class="navbar-brand" href="index.php">U.E. Marcelino Champagnat I</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
        </ul>
        <div class="d-flex ms-auto">
            <a class="btn btn-danger" href="logout.php">Cerrar Sesión</a>
        </div>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2 class="text-center mb-4">Editar Curso</h2>
  
  <?php if(isset($error)): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <div class="form-container">
    <form method="POST" action="actualizar_curso.php?id=<?php echo $curso['id']; ?>">
      <div class="mb-3">
        <label for="grado" class="form-label">Grado:</label>
        <input type="text" class="form-control" id="grado" name="grado" required value="<?php echo htmlspecialchars($curso['grado']); ?>">
      </div>
      <div class="mb-3">
        <label for="seccion" class="form-label">Sección:</label>
        <input type="text" class="form-control" id="seccion" name="seccion" required value="<?php echo htmlspecialchars($curso['seccion']); ?>">
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Actualizar Curso</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>

<footer>
  Derechos de Autor &copy; Fernanda Garrón y Massiel Espíndola 2025
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>