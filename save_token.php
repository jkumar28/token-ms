<?php
require 'auth/auth.php';
require 'config/db.php';
date_default_timezone_set('Asia/Kolkata');

ini_set('display_errors',1);

$data = $_POST;

$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT MAX(CAST(challan_no AS UNSIGNED)) AS max_num FROM tokens WHERE DATE(created_at) = ?");
$stmt->execute([$today]);
$row = $stmt->fetch();
$nextNum = ((int)($row['max_num'] ?? 0)) + 1;

if ($nextNum < 100) {
    $data['challan_no'] = str_pad($nextNum, 2, '0', STR_PAD_LEFT);
} else {
    $data['challan_no'] = (string)$nextNum;
}


$stmt = $pdo->prepare("
INSERT INTO tokens
(token_no,challan_no,company_id,vehicle_no, vhl_type,
 party_name,party_address,item_name,
 gross_weight,tare_weight,net_weight,net_weight_words,
 gross_time,tare_time,charge_amount,operator_name,created_at)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())
");

$stmt->execute([
    $data['token_no'],
    $data['challan_no'],
    $data['company_id'],
    $data['vehicle_no'],
    $data['vhl_type'],
    $data['party_name'],
    $data['party_address'],
    $data['item_name'],
    $data['gross_weight'],
    $data['tare_weight'],
    $data['net_weight'],
    $data['net_weight_words'],
    $data['gross_time'],
    $data['tare_time'],
    $data['charge_amount'],
    $_SESSION['admin_username']
]);

// echo json_encode(['status' => 'success']);


$tokenId = $pdo->lastInsertId();

echo json_encode([
    'status' => 'success',
    'token_id' => $tokenId
]);