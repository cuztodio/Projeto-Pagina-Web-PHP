<?php
// public/logout.php
require_once __DIR__ . '/../includes/auth.php';
logout();
redirect('/login.php?error=' . urlencode('Sessão encerrada.'));
