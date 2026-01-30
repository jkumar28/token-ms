<?php require 'auth/auth.php';
require 'config/db.php';

/* Today range (IST) */
$todayStart = date('Y-m-d 00:00:00');
$todayEnd   = date('Y-m-d 23:59:59');

/* Today Tokens */
$todayTokens = $pdo->prepare("
    SELECT COUNT(*) 
    FROM tokens 
    WHERE created_at BETWEEN ? AND ?
");
$todayTokens->execute([$todayStart, $todayEnd]);
$todayTokens = $todayTokens->fetchColumn();

/* Total Tokens */
$totalTokens = $pdo->query("
    SELECT COUNT(*) FROM tokens
")->fetchColumn();

/* Today Amount */
$todayAmount = $pdo->prepare("
    SELECT IFNULL(SUM(charge_amount),0)
    FROM tokens
    WHERE created_at BETWEEN ? AND ?
");
$todayAmount->execute([$todayStart, $todayEnd]);
$todayAmount = $todayAmount->fetchColumn();

/* Total Amount */
$totalAmount = $pdo->query("
    SELECT IFNULL(SUM(charge_amount),0) FROM tokens
")->fetchColumn();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: #f4f6f9;
        }

        .main {
            margin-left: 240px;
            padding: 20px;
        }

        .topbar {
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main">

        <div class="topbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Dashboard</h5>
            <span>Welcome, <strong><?= ucwords($_SESSION['admin_username']); ?></strong></span>
        </div>

        <div class="mt-4">
            <div class="row">

                <div class="col-md-6 my-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Today Tokens</h6>
                            <h3><?= $todayTokens; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 my-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Total Tokens</h6>
                            <h3><?= $totalTokens; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 my-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Today Amount</h6>
                            <h3>₹ <?= number_format($todayAmount, 0); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 my-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Total Amount</h6>
                            <h3>₹ <?= number_format($totalAmount, 0); ?></h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

</body>

</html>