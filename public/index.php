<?php
session_start();
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/AuthMiddleware.php';
require_once __DIR__ . '/../app/core/Router.php';

AuthMiddleware::checkAuth();
$pdo = getPDOConnection();
$router = new Router($pdo);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->route($path);
