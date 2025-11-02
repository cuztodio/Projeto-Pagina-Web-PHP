<?php
// public/categories/edit.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();
if (!$cat) {
    http_response_code(404);
    die('Categoria não encontrada.');
}

$err = $ok = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $err = 'Nome é obrigatório.';
    } else {
        $stmt = $pdo->prepare("UPDATE categories SET name=? WHERE id=?");
        $stmt->execute([$name, $id]);
        $ok = 'Categoria atualizada!';
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->execute([$id]);
        $cat = $stmt->fetch();
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Editar Categoria</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Editar Categoria</h1>
    <nav>
      <a href="/categories/list.php">Voltar</a>
      <a href="/logout.php">Sair</a>
    </nav>
  </header>
  <div class="card">
    <?php if ($err): ?><div class="alert error"><?php echo e($err); ?></div><?php endif; ?>
    <?php if ($ok): ?><div class="alert success"><?php echo e($ok); ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
      <label>Nome</label>
      <input name="name" value="<?php echo e($cat['name']); ?>" required>
      <button type="submit">Salvar</button>
    </form>
  </div>
</div>
</body>
</html>
