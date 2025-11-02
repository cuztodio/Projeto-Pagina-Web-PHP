<?php
// public/categories/create.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

$err = $ok = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $err = 'Nome é obrigatório.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
        $ok = 'Categoria criada!';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Nova Categoria</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Nova Categoria</h1>
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
      <input name="name" required>
      <button type="submit">Salvar</button>
    </form>
  </div>
</div>
</body>
</html>
