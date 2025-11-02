<?php
// config/db.php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ajuste aqui para o seu ambiente:
define('DB_HOST', 'localhost');
define('DB_NAME', 'php_crud_auth_app');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// Config PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Erro de conexão: " . htmlspecialchars($e->getMessage()));
}
