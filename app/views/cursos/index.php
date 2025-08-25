<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Listado de Cursos - Colegio JIM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/navbar.css">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/cards.css">
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_index.css">
</head>

<body>
  <?php include __DIR__ . '/../components/navbar.php'; ?>
  
  <div class="container">
    <div class="row mb-3">
      <div class="col">
        <h2>Lista de Cursos</h2>
      </div>
      <div class="col-auto">
        <a href="<?php echo URL; ?>public/cursos/create" class="btn btn-primary">Agregar Curso</a>
      </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="row mb-3">
      <div class="col-md-6">
        <form method="GET" action="<?php echo URL; ?>public/cursos" class="d-flex">
          <input type="text" name="search" class="form-control me-2" 
                 placeholder="Buscar por grado, sección o descripción..." 
                 value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
          <button type="submit" class="btn btn-outline-secondary">Buscar</button>
          <?php if (!empty($_GET['search'])): ?>
            <a href="<?php echo URL; ?>public/cursos" class="btn btn-outline-danger ms-2">Limpiar</a>
          <?php endif; ?>
        </form>
      </div>
    </div>

    <?php if (!empty($_GET['search'])): ?>
      <div class="alert alert-info">
        Resultados de búsqueda para: "<strong><?php echo htmlspecialchars($_GET['search']); ?></strong>"
        (<?php echo count($cursos); ?> resultado<?php echo count($cursos) != 1 ? 's' : ''; ?>)
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success text-center"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($cursos)): ?>
      <!-- Vista de tarjetas -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        require_once __DIR__ . '/../components/curso_cards.php';
        foreach ($cursos as $curso):
          mostrarTarjetaCurso($curso);
        endforeach;
        ?>
      </div>

      <!-- Vista de tabla alternativa -->
      <div class="mt-4">
        <h4>Vista de Tabla</h4>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Grado</th>
                <th>Sección</th>
                <th>Descripción</th>
                <th>Año Escolar</th>
                <th>Total Estudiantes</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cursos as $curso): ?>
                <tr>
                  <td><?php echo $curso['id']; ?></td>
                  <td><?php echo htmlspecialchars($curso['grado']); ?></td>
                  <td><?php echo htmlspecialchars($curso['seccion']); ?></td>
                  <td><?php echo htmlspecialchars($curso['descripcion'] ?? 'Sin descripción'); ?></td>
                  <td><?php echo htmlspecialchars($curso['año_escolar']); ?></td>
                  <td>
                    <span class="badge bg-primary">
                      <?php echo $curso['total_estudiantes'] ?? 0; ?> estudiante<?php echo ($curso['total_estudiantes'] ?? 0) != 1 ? 's' : ''; ?>
                    </span>
                  </td>
                  <td>
                    <a href="<?php echo URL; ?>public/cursos/show?id=<?php echo $curso['id']; ?>" class="btn btn-sm btn-info">Ver</a>
                    <a href="<?php echo URL; ?>public/cursos/edit?id=<?php echo $curso['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="<?php echo URL; ?>public/cursos/delete?id=<?php echo $curso['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este curso? Se eliminarán también todos los estudiantes asociados.')">Eliminar</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php else: ?>
      <div class="text-center">
        <div class="alert alert-info">
          <?php if (!empty($_GET['search'])): ?>
            <p>No se encontraron cursos que coincidan con tu búsqueda.</p>
            <a href="<?php echo URL; ?>public/cursos" class="btn btn-primary">Ver todos los cursos</a>
          <?php else: ?>
            <p>No hay cursos guardados.</p>
            <a href="<?php echo URL; ?>public/cursos/create" class="btn btn-primary">Crear Primer Curso</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
  
  <?php include __DIR__ . '/../components/footer.php'; ?>
</body>

</html>
