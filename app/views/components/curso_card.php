<?php
/**
 * Componente para mostrar una tarjeta de curso
 * @param array $curso Datos del curso a mostrar
 */
function mostrarTarjetaCurso($curso) {
?>
<div class="col">
  <div class="card h-100">
    <img src="<?php echo URL; ?>public/img/aula_completo.png" class="card-img-top" alt="Imagen de curso">
    <div class="card-body">
      <h5 class="card-title"><?php echo htmlspecialchars($curso['grado'] . ' "' . $curso['seccion'] . '"'); ?></h5>
      <p class="card-text">
        <?php if(!empty($curso['descripcion'])): ?>
          <?php echo htmlspecialchars($curso['descripcion']); ?>
        <?php else: ?>
          <em>Sin descripción</em>
        <?php endif; ?>
      </p>
      <p class="card-text"><small class="text-muted">Año escolar: <?php echo htmlspecialchars($curso['año_escolar'] ?? date('Y')); ?></small></p>
      <p class="card-text"><strong>Estudiantes:</strong> <?php echo $curso['total_estudiantes']; ?></p>
    </div>
    <div class="card-footer bg-transparent">
      <div class="d-flex justify-content-between">
        <a href="#" class="btn btn-primary btn-sm">Ver Estudiantes</a>
        <div>
          <a href="#" class="btn btn-warning btn-sm">Editar</a>
          <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este curso?');">Eliminar</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
}
?>