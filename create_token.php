<?php
require 'auth/auth.php';
date_default_timezone_set('Asia/Kolkata');
$now = date('Y-m-d\TH:i');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Token</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: #f4f6f9;
        }

        .main {
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            border-radius: 12px;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main">

        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <h5 class="mb-0">➕ Create Token</h5>
                <a class="btn3" href="./token_list.php">Token List</a>
            </div>

            <div class="card-body">
                <form id="tokenForm">

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>RST No *</label>
                            <input class="form-control" name="token_no" required>
                        </div>
                        <div class="col-md-3">
                            <label>Vehical Type</label>
                            <input type="number" class="form-control" name="vhl_type" >
                        </div>

                        <div class="col-md-3">
                            <label>Company / Location *</label>
                            <select class="form-control" name="company_id" id="companySelect" required></select>
                        </div>
                        <div class="col-md-3">
                            <label>Address</label>
                            <input class="form-control" id="companyAddress" readonly>
                        </div>

                        <!-- <div class="col-md-3">
                            <label>Location Name</label>
                            <input class="form-control" name="location_name" value="BOKARO RAILWAY SIDING">
                        </div>
                        <div class="col-md-3">
                            <label>Location City</label>
                            <input class="form-control" name="location_city" value="BOKARO STEEL CITY">
                        </div> -->
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Vehicle No *</label>
                            <input class="form-control" name="vehicle_no" required>
                        </div>
                        <div class="col-md-3">
                            <label>Party Name</label>
                            <input class="form-control" name="party_name">
                        </div>
                        <div class="col-md-3">
                            <label>Party Address</label>
                            <input class="form-control" name="party_address">
                        </div>
                        <div class="col-md-3">
                            <label>Item</label>
                            <input class="form-control" name="item_name" >
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Gross Weight (KG) *</label>
                            <input type="number" step="0.01" class="form-control" name="gross_weight" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label>Tare Weight (KG) *</label>
                            <input type="number" step="0.01" class="form-control" name="tare_weight" required>
                        </div>
                        <div class="col-md-4">
                            <label>Time (IST)</label>
                            <input type="datetime-local" class="form-control" name="gross_time" value="<?= $now ?>">
                        </div>
                        
                        <div class="col-md-3 d-none">
                            <label>Tare Time (IST)</label>
                            <input type="datetime-local" class="form-control" name="tare_time" value="<?= $now ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Net Weight (KG)</label>
                            <input class="form-control" name="net_weight" readonly>
                        </div>
                        <div class="col-md-8">
                            <label>Net Weight (Words)</label>
                            <input class="form-control" name="net_weight_words" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Charge Amount *</label>
                            <input type="number" class="form-control" name="charge_amount" required>
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        Save & Print
                    </button>

                </form>
            </div>
        </div>

    </div>

    <script>
        function numberToWords(num) {
            const a = ['ZERO', 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX', 'SEVEN', 'EIGHT', 'NINE'];
            return num.toString().split('').map(d => a[d]).join(' ');
        }

        const gross = document.querySelector('[name="gross_weight"]');
        const tare = document.querySelector('[name="tare_weight"]');
        const net = document.querySelector('[name="net_weight"]');
        const words = document.querySelector('[name="net_weight_words"]');

        function calc() {
            let g = parseFloat(gross.value) || 0;
            let t = parseFloat(tare.value) || 0;
            let n = g - t;
            net.value = n.toFixed(2);
            words.value = numberToWords(Math.round(n));
        }
        gross.addEventListener('input', calc);
        tare.addEventListener('input', calc);


        // =============Select Company=============
        fetch('company_ajax.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'list'
            })
        }).then(r => r.json()).then(d => {
            companySelect.innerHTML = '<option value="">Select</option>';
            d.forEach(c => {
                companySelect.innerHTML += `<option value="${c.id}" data-address="${c.address}">${c.name}</option>`;
            });
        });

        companySelect.onchange = () => {
            companyAddress.value = companySelect.selectedOptions[0].dataset.address || '';
        };

        
        document.getElementById('tokenForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Save Token?',
                icon: 'question',
                showCancelButton: true
            }).then(res => {
                if (!res.isConfirmed) return;

                Swal.fire({
                    title: 'Saving...',
                    didOpen: () => Swal.showLoading(),
                    allowOutsideClick: false
                });

                fetch('save_token.php', {
                    method: 'POST',
                    body: new FormData(this)
                }).then(r => r.json()).then(r => {
                    Swal.close();
                    if (r.status === 'success') {
                        Swal.fire({
                            title: 'Token Created',
                            text: 'Print token now?',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Print',
                            cancelButtonText: 'Close'
                        }).then(res => {
                            if (res.isConfirmed) {
                                window.open(
                                    'print_token.php?id=' + r.token_id,
                                    '_blank'
                                );
                            }
                        });
                    } else {
                        Swal.fire('Error', r.message, 'error');
                    }
                });
            });
        });
    </script>

</body>

</html>