<?php
// includes/functions.php
declare(strict_types=1);

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header("Location: " . $path);
    exit;
}
