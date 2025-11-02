<?php
error_reporting(0);

require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

$q = trim($_GET['q'] ?? '');
$category_id = trim($_GET['category_id'] ?? '');

$sql = "SELECT p.id, p.name, p.price, c.name AS category
        FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE 1=1";
$params = [];

if ($q !== '') {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%$q%";
}

if ($category_id !== '') {
    $sql .= " AND p.category_id = ?";
    $params[] = $category_id;
}

$sql .= " ORDER BY p.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="produtos.csv"');

echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');

// ⚙️ Usa ponto e vírgula para o Excel PT-BR
fputcsv($output, ['ID', 'Nome', 'Categoria', 'Preço'], ';', '"', '\\');

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv(
        $output,
        [
            $row['id'],
            $row['name'],
            $row['category'],
            number_format((float)$row['price'], 2, ',', '')
        ],
        ';', '"', '\\'
    );
}

fclose($output);
exit;
