<?php
// public/categories/delete.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
require_admin(); // apenas admin pode excluir categorias
global $pdo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $id = (int)($_POST['id'] ?? 0);
    // Verifica relação com produtos
    $cnt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $cnt->execute([$id]);
    if ($cnt->fetchColumn() > 0) {
        redirect('/categories/list.php?error=' . urlencode('Há produtos vinculados a esta categoria.'));
    }
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    redirect('/categories/list.php');
} else {
    http_response_code(405);
    echo 'Método não permitido.';
}
