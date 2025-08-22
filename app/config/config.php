<?php
// URL base del proyecto (para cargar CSS, JS, imágenes)
define('URL', 'http://localhost/colegio_jim/');

// Base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'colegio_champagnat');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Función para obtener PDO
function getPDOConnection() {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>