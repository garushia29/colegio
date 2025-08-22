<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Sistema Escolar</title>
  <link rel="stylesheet" href="<?php echo URL; ?>public/css/style_login.css" />
</head>
<body>
  <div class="login-box">
    <img src="<?php echo URL; ?>public/img/logo.jpeg" alt="Logo Colegio" class="logo" />

    <h2>Acceso al Sistema</h2>

    <div class="info">
        <strong>Datos de prueba:</strong><br>
        Usuario: admin<br>
        Contraseña: password
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <p style='color:red'><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="<?php echo URL; ?>public/login.php">

      <div class="form-group">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required placeholder="Ingrese su usuario">
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">
      </div>
      <button class="btn" type="submit">Entrar</button>
    </form>

    <div style="margin-top: 20px;">
        <small style="color: #666;">Sistema de Gestión Escolar - Marcelino Champagnat</small>
    </div>
  </div>
</body>
</html>
