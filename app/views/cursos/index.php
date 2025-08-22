<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Cursos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style_index.css" />
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/cards.css">

</head>
<body>

<?php include __DIR__ . '/../../../public/components/navbar.php'; ?>


<h2 class="text-center mt-4">Administrar Cursos</h2>

<?php if(isset($error)): ?>
    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
<?php endif; ?>

<?php if(isset($success)): ?>
    <div class="alert alert-success text-center"><?php echo $success; ?></div>
<?php endif; ?>


</body>
</html>