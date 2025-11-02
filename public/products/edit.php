<?php
// public/products/edit.php
require_once __DIR__ . '/../../includes/auth.php';
require_login();
global $pdo;

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    http_response_code(404);
    die('Produto não encontrado.');
}

$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

$err = $ok = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
    $image_path = $product['image_path'];

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $maxSize = 2 * 1024 * 1024;
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, true, $allowed)) { /* intentional order fix below */ }
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
        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, category_id=?, image_path=? WHERE id=?");
        $stmt->execute([$name, (float)$price, $category_id, $image_path, $id]);
        $ok = 'Produto atualizado com sucesso!';
        // Atualiza visão
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Editar Produto</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Editar Produto</h1>
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
      <input name="name" value="<?php echo e($product['name']); ?>" required>
      <label>Preço</label>
      <input name="price" type="number" step="0.01" min="0" value="<?php echo e((string)$product['price']); ?>" required>
      <label>Categoria</label>
      <select name="category_id">
        <option value="">—</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?php echo e((string)$c['id']); ?>" <?php echo ($product['category_id'] == $c['id'])?'selected':''; ?>>
            <?php echo e($c['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <label>Imagem (manter vazia para não trocar)</label>
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
      <?php if (!empty($product['image_path'])): ?>
        <p><img class="thumb" src="<?php echo e('/uploads/' . basename($product['image_path'])); ?>" alt=""></p>
      <?php endif; ?>
      <button type="submit">Salvar alterações</button>
    </form>
  </div>
</div>
</body>
</html>
