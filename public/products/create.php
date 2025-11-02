<?php
// public/products/create.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

// Busca categorias para combo
$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

$err = $ok = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;

    // upload (opcional)
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            $err = 'Formato de imagem inválido.';
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $err = 'Imagem muito grande (máx 2MB).';
        } elseif (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $uploadDir = __DIR__ . '/../uploads';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $newName = uniqid('img_', true) . '.' . $ext;
            $dest = $uploadDir . '/' . $newName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $err = 'Falha ao salvar a imagem.';
            } else {
                $image_path = $newName;
            }
        }
    }

    if (!$err) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, (float)$price, $category_id, $image_path]);
        $ok = 'Produto cadastrado com sucesso!';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Novo Produto</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Novo Produto</h1>
    <nav>
      <a href="/products/list.php">Voltar</a>
      <a href="/logout.php">Sair</a>
    </nav>
  </header>
  <div class="card">
    <?php if ($err): ?><div class="alert error"><?php echo e($err); ?></div><?php endif; ?>
    <?php if ($ok): ?><div class="alert success"><?php echo e($ok); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
      <label>Nome</label>
      <input name="name" required>
      <label>Preço</label>
      <input name="price" type="number" step="0.01" min="0" required>
      <label>Categoria</label>
      <select name="category_id">
        <option value="">—</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?php echo e((string)$c['id']); ?>"><?php echo e($c['name']); ?></option>
        <?php endforeach; ?>
      </select>
      <label>Imagem (opcional, até 2MB)</label>
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
      <button type="submit">Salvar</button>
    </form>
  </div>
</div>
</body>
</html>
