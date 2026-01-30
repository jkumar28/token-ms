<?php
require 'auth/auth.php';
require 'config/db.php';

$action = $_POST['action'] ?? '';

if ($action == 'list') {
    $rows = $pdo->query("SELECT * FROM companies WHERE is_active=1 ORDER BY id DESC")->fetchAll();
    echo json_encode($rows);
}

if ($action == 'save') {
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE companies SET name=?,address=?,mobile_no=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['address'], $_POST['mobile_no'], $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO companies (name,address,mobile_no) VALUES (?,?,?)");
        $stmt->execute([$_POST['name'], $_POST['address'], $_POST['mobile_no']]);
    }
    echo json_encode(['status' => 'success']);
}

if ($action == 'delete') {
    $pdo->prepare("UPDATE companies SET is_active=0 WHERE id=?")->execute([$_POST['id']]);
    echo json_encode(['status' => 'success']);
}
