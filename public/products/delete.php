<?php
// public/products/delete.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    redirect('/products/list.php');
} else {
    http_response_code(405);
    echo 'Método não permitido.';
}
