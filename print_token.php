<?php
require 'auth/auth.php';
require 'config/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT t.* , c.name AS location_name, c.address AS location_city, c.mobile_no
FROM tokens t LEFT JOIN companies c ON t.company_id = c.id  WHERE t.id=?");
$stmt->execute([$id]);
$t = $stmt->fetch();

if (!$t) {
    die('INVALID TOKEN');
}

/* increment print count */
$pdo->prepare("UPDATE tokens SET print_count = print_count + 1 WHERE id=?")
    ->execute([$id]);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Weighbridge Slip</title>

    <style>
        @font-face {
            font-family: 'DotMatrix';
            src: url('assets/fonts/dotmatrix.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @media print {
            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        body {
            font-family: dotmatrix, monospace;
            font-size: 12px;
            background: #fff;
        }

        .receipt {
            width: 580px;
            margin: auto;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .hr {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            white-space: nowrap;
        }

        .col {
            width: 48%;
        }

        .mt {
            margin-top: 3px;
        }

        .f-15 {
            font-size: 15px;
        }
    </style>
</head>

<!--<body onload="window.print()">-->

<body>
    <div class="receipt">
        <br><br>

        <div class="center">
            <span style="font-size: 18px;" class="bold"><?= strtoupper($t['location_name'] ?? 'BOKARO RAILWAY SIDING'); ?></span><br>
            <div class="mt"></div>
            <?= strtoupper($t['location_city'] ?? 'BOKARO STEEL CITY'); ?><br>
            <div class="mt"></div>
            MOBILE NO- <?= strtoupper($t['mobile_no'] ?? '-'); ?>
        </div>

        <div class="hr"></div>

        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">RST No.</div>
                    <div class="col">: <span class="f-15 bold"><?= $t['token_no']; ?></span></div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">Vehicle No.</div>
                    <div class="col">: <?= strtoupper($t['vehicle_no']); ?></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">Vhl Typ</div>
                    <div class="col">: <?= strtoupper($t['vhl_type']); ?> Tyre</div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">Party name</div>
                    <div class="col">: <?= strtoupper($t['party_name']); ?></div>
                </div>
            </div>
        </div>

        <div class="row mt">
            <div class="col">
                <div class="row">
                    <div class="col">Address</div>
                    <div class="col">: <?= strtoupper($t['party_address'])?? ''; ?></div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">Item</div>
                    <div class="col">: <?= strtoupper($t['item_name']); ?></div>
                </div>
            </div>
        </div>

        <div class="hr"></div>

        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">Gross</div>
                    <div class="col">: <span class="f-15 bold"><?= $t['gross_weight']; ?></span> Kg</div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-8">Date : <?= date('d/m/Y', strtotime($t['gross_time'])); ?> &nbsp; <?= date('H:i', strtotime($t['gross_time'])); ?> </div>
                    <div class="col-4">&nbsp; Rs &nbsp; 0</div>
                </div>
            </div>
        </div>

        <div class="row mt">
            <div class="col">
                <div class="row">
                    <div class="col">Tare</div>
                    <div class="col">: <span class="f-15 bold"><?= $t['tare_weight']; ?></span> Kg</div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-8">Date : <?= date('d/m/Y', strtotime($t['gross_time'])); ?> &nbsp; <?= date('H:i', strtotime($t['gross_time'])); ?> </div>
                    <div class="col-4">&nbsp; Rs &nbsp; 0</div>
                </div>
            </div>
        </div>

        <div class="row mt">
            <div class="col">
                <div class="row">
                    <div class="col">Net</div>
                    <div class="col">: <span class="f-15 bold"><?= $t['net_weight']; ?></span> Kg</div>
                </div>
            </div>

        </div>

        <div class="hr"></div>
        <div class="row">
            Charges : Rs <?= number_format($t['charge_amount'], 0); ?>
        </div>
        <div class="hr"></div>
        
        <br>
        <div class="center">
            ! Thanks for your Visit !
        </div>

    </div>

</body>

</html>