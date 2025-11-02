<?php
// public/dashboard.php
require_once __DIR__ . '/../includes/auth.php';
require_login();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Dashboard</h1>
    <nav>
      <a href="/products/list.php">Produtos</a>
      <a href="/categories/list.php">Categorias</a>
      <a href="/logout.php">Sair</a>
    </nav>
  </header>
  <div class="card">
    <p>Bem-vindo, <strong><?php echo e($_SESSION['user_name'] ?? ''); ?></strong>!
      <span class="badge">Perfil: <?php echo e($_SESSION['user_role'] ?? 'user'); ?></span>
    </p>
    <p>Use o menu acima para gerenciar produtos e categorias.</p>
  </div>
  <footer>Projeto acadêmico PHP + MySQL (PDO). Segurança: Prepared, XSS, CSRF.</footer>
</div>
</body>
</html>
