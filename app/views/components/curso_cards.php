<div class="container mt-4">
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php function mostrarTarjetaCurso($curso) { ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="<?php echo URL; ?>public/img/aula_completo.png" class="card-img-top" alt="Imagen de curso">
          <div class="card-body">
            <h5 class="card-title">
              <?php echo htmlspecialchars($curso['grado'] . ' "' . $curso['seccion'] . '"'); ?>
            </h5>
            <p class="card-text">
              <?php if (!empty($curso['descripcion'])): ?>
                <?php echo htmlspecialchars($curso['descripcion']); ?>
              <?php else: ?>
                <em>Sin descripción</em>
              <?php endif; ?>
            </p>
            <p class="card-text">
              <small class="text-muted">Año escolar: <?php echo htmlspecialchars($curso['año_escolar'] ?? date('Y')); ?></small>
            </p>
            <p class="card-text">
              <strong>Estudiantes:</strong> <?php echo $curso['total_estudiantes']; ?>
            </p>
          </div>
          <div class="card-footer bg-transparent">
            <div class="d-flex justify-content-between">
              <a href="<?php echo URL; ?>public/cursos/show?id=<?php echo $curso['id']; ?>" class="btn btn-primary">Ver Curso</a>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
