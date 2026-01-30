<?php
session_start();
require 'config/db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

$stmt = $pdo->prepare("SELECT * FROM admins WHERE username=? AND is_active=1");
$stmt->execute([$username]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    exit;
}

$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];

if ($remember) {
    $token = bin2hex(random_bytes(32));
    setcookie('admin_remember', $token, time() + 31536000, '/');
    $pdo->prepare("UPDATE admins SET remember_token=? WHERE id=?")->execute([$token, $admin['id']]);
}
echo json_encode(['status' => 'success']);
