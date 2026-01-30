<?php
session_start();
require 'config/db.php';

if (isset($_SESSION['admin_id'])) {
    $pdo->prepare("UPDATE admins SET remember_token=NULL WHERE id=?")
        ->execute([$_SESSION['admin_id']]);
}

setcookie('admin_remember', '', time() - 3600, '/');
session_destroy();

header("Location: login.php");
exit;
