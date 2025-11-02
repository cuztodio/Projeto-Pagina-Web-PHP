<?php
// public/products/list.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

// Filtros de busca
$q = trim($_GET['q'] ?? '');
$category_id = trim($_GET['category_id'] ?? '');

// Consulta categorias para filtro
$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

$sql = "SELECT p.id, p.name, p.price, p.image_path, c.name AS category_name
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
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Produtos</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Produtos</h1>
    <nav>
      <a href="/dashboard.php">Dashboard</a>
      <a href="/categories/list.php">Categorias</a>
      <a href="/logout.php">Sair</a>
    </nav>
  </header>

  <div class="card">
    <form class="toolbar" method="get">
      <div style="flex:1">
        <label>Buscar por nome</label>
        <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Ex.: teclado, mouse...">
      </div>
      <div>
        <label>Categoria</label>
        <select name="category_id">
          <option value="">Todas</option>
          <?php foreach ($cats as $c): ?>
            <option value="<?php echo e((string)$c['id']); ?>" <?php echo $category_id===(string)$c['id']?'selected':''; ?>>
              <?php echo e($c['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="btn-row">
        <button type="submit">Filtrar</button>
        <a href="/products/export_csv.php?q=<?php echo urlencode($q); ?>&category_id=<?php echo urlencode((string)$category_id); ?>" class="badge">Exportar CSV</a>
        <a href="/products/create.php" class="badge">+ Novo Produto</a>
      </div>
    </form>
  </div>

  <div class="card">
    <table class="table">
      <thead>
      <tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Preço</th><th>Imagem</th><th>Ações</th></tr>
      </thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?php echo e((string)$r['id']); ?></td>
          <td><?php echo e($r['name']); ?></td>
          <td><?php echo e($r['category_name'] ?? '—'); ?></td>
          <td>R$ <?php echo number_format((float)$r['price'], 2, ',', '.'); ?></td>
          <td>
            <?php if (!empty($r['image_path'])): ?>
              <img class="thumb" src="<?php echo e('/uploads/' . basename($r['image_path'])); ?>" alt="">
            <?php else: ?>
              <span class="badge">sem imagem</span>
            <?php endif; ?>
          </td>
          <td>
            <a class="badge" href="/products/edit.php?id=<?php echo e((string)$r['id']); ?>">Editar</a>
            <form style="display:inline" method="post" action="/products/delete.php" onsubmit="return confirm('Tem certeza?');">
              <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
              <input type="hidden" name="id" value="<?php echo e((string)$r['id']); ?>">
              <button class="badge" style="background:var(--danger);border-color:#7f1d1d;color:#fee2e2" type="submit">Deletar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
