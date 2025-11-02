<?php
// public/index.php
require_once __DIR__ . '/../includes/auth.php';

if (is_logged_in()) {
    redirect('/dashboard.php');
} else {
    redirect('/login.php');
}
