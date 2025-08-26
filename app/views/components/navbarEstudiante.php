<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <div class="img-placeholder me-2">
        <img src="<?php echo URL; ?>public/img/logo.jpeg" alt="Marist Logo">
    </div>
    <a class="navbar-brand" href="<?php echo URL; ?>public/cursos">Sistema de Gestión Escolar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link text-white" href="<?php echo URL; ?>public/usuarios">Usuarios</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?php echo URL; ?>public/cursos">Cursos</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?php echo URL; ?>public/estudiantes">Estudiantes</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL; ?>public/reportes"><i class="fas fa-chart-bar"></i> Reportes</a></li>
        </ul>
        <div class="d-flex ms-auto">
            <a class="btn btn-danger" href="<?php echo URL; ?>public/logout.php">Cerrar Sesión</a>
        </div>
    </div>
  </div>
</nav>