<?php
require 'auth/auth.php';
require 'config/db.php';

/* DELETE */
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $pdo->prepare("DELETE FROM tokens WHERE id=?")->execute([$_POST['id']]);
    echo json_encode(['status' => 'success']);
    exit;
}

/* DATATABLES */
$columns = [
    'id',
    'token_no',
    'created_at',
    'vehicle_no',
    'party_name',
    'item_name',
    'net_weight',
    'charge_amount'
];

$limit  = $_POST['length'];
$start  = $_POST['start'];
$order  = $columns[$_POST['order'][0]['column']];
$dir    = $_POST['order'][0]['dir'];
$search = $_POST['search']['value'];

$where = '';
$params = [];

if ($search) {
    $where = " WHERE token_no LIKE ? 
               OR vehicle_no LIKE ?
               OR party_name LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

/* Total Records */
$total = $pdo->query("SELECT COUNT(*) FROM tokens")->fetchColumn();

/* Filtered Records */
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tokens $where");
$stmt->execute($params);
$filtered = $stmt->fetchColumn();

/* Fetch Data */
$sql = "SELECT * FROM tokens $where 
        ORDER BY $order $dir 
        LIMIT $start,$limit";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = [];

$i=1;
while ($row = $stmt->fetch()) {
    $data[] = [
        'si_no' => $i++,
        'id' => $row['id'],
        'token_no' => $row['token_no'],
        'vhl_type' => $row['vhl_type'] ?? '-',
        'created_at' => date('d-m-Y H:i', strtotime($row['created_at'])),
        'vehicle_no' => $row['vehicle_no'],
        'party_name' => $row['party_name'],
        'item_name' => $row['item_name'],
        'net_weight' => $row['net_weight'] . ' KG',
        'charge_amount' => '₹' . number_format($row['charge_amount'], 0),
        'action' => '
            <a target="_blank" href="print_token.php?id=' . $row['id'] . '" 
               class="btn px-1 py-0 btn-primary"><i class="bi bi-printer"></i></a>
            <button class="btn px-1 py-0 btn-danger deleteToken" 
               data-id="' . $row['id'] . '"><i class="bi bi-trash"></i></button>'
    ];
}

/* OUTPUT */
echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $total,
    "recordsFiltered" => $filtered,
    "data" => $data
]);
