<?php require 'auth/auth.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Token List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
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

        .table thead {
            background: #111827;
            color: #fff;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main">

        <div class="mb-3 d-flex justify-content-between">
            <h4>Token List</h4>
            <a class="btn2" href="./create_token.php">Create</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tokenTable" class="table table-bordered table-striped w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>RST No</th>
                                <th>Vhl typ</th>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Party</th>
                                <th>Item</th>
                                <th>Net Wt</th>
                                <th>Amount</th>
                                <th width="9%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(function() {

            let table = $('#tokenTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "token_list_ajax.php",
                    type: "POST"
                },
                columns: [{
                        data: "si_no"
                    },
                    {
                        data: "token_no"
                    },
                    {
                        data: "vhl_type"
                    },
                    {
                        data: "created_at"
                    },
                    {
                        data: "vehicle_no"
                    },
                    {
                        data: "party_name"
                    },
                    {
                        data: "item_name"
                    },
                    {
                        data: "net_weight"
                    },
                    {
                        data: "charge_amount"
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // DELETE TOKEN
            $(document).on('click', '.deleteToken', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete token?',
                    text: 'This action cannot be undone',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete'
                }).then(res => {
                    if (res.isConfirmed) {
                        fetch('token_list_ajax.php', {
                            method: 'POST',
                            body: new URLSearchParams({
                                action: 'delete',
                                id: id
                            })
                        }).then(r => r.json()).then(r => {
                            if (r.status === 'success') {
                                Swal.fire('Deleted', 'Token removed', 'success');
                                table.ajax.reload(null, false);
                            }
                        });
                    }
                });
            });

        });
    </script>

</body>

</html>