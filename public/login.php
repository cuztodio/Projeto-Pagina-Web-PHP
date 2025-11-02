<?php
// public/login.php
require_once __DIR__ . '/../includes/auth.php';

$err = $_GET['error'] ?? '';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password && login($email, $password)) {
        redirect('/dashboard.php');
    } else {
        $err = 'Credenciais inválidas.';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container">
  <div class="card">
    <h1>Login</h1>
    <?php if ($err): ?><div class="alert error"><?php echo e($err); ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
      <label>E-mail</label>
      <input type="email" name="email" required>
      <label>Senha</label>
      <input type="password" name="password" required>
      <button type="submit">Entrar</button>
    </form>
    <p class="badge">Use admin@exemplo.com / admin123 ou user@exemplo.com / user123</p>
  </div>
</div>
</body>
</html>
