<?php
// public/categories/list.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

$rows = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Categorias</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Categorias</h1>
    <nav>
      <a href="/dashboard.php">Dashboard</a>
      <a href="/products/list.php">Produtos</a>
      <a href="/logout.php">Sair</a>
    </nav>
  </header>

  <div class="card">
    <a class="badge" href="/categories/create.php">+ Nova Categoria</a>
  </div>

  <div class="card">
    <table class="table">
      <thead><tr><th>ID</th><th>Nome</th><th>Ações</th></tr></thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?php echo e((string)$r['id']); ?></td>
          <td><?php echo e($r['name']); ?></td>
          <td>
            <a class="badge" href="/categories/edit.php?id=<?php echo e((string)$r['id']); ?>">Editar</a>
            <form style="display:inline" method="post" action="/categories/delete.php" onsubmit="return confirm('Tem certeza?');">
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
