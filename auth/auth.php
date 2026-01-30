<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['admin_id'])) return;

if (isset($_COOKIE['admin_remember'])) {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE remember_token=?");
    $stmt->execute([$_COOKIE['admin_remember']]);
    $admin = $stmt->fetch();
    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        return;
    }
}
header("Location: login.php");
exit;
