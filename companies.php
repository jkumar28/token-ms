<?php require 'auth/auth.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Companies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .main {
            margin-left: 240px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <b>Company / Location</b>
                <button class="btn btn-sm btn-primary" onclick="openForm()">+ Add</button>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="companyData"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="companyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="companyForm">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title">Company</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <label>Name</label>
                        <input class="form-control mb-2" name="name" required>
                        <label>Address</label>
                        <textarea class="form-control mb-2" name="address" required></textarea>
                        <label>Mobile</label>
                        <input class="form-control" name="mobile_no">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadCompanies() {
            fetch('company_ajax.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'list'
                })
            }).then(r => r.json()).then(d => {
                let html = '';
                d.forEach(c => {
                    html += `<tr>
                <td>${c.name}</td>
                <td>${c.address}</td>
                <td>${c.mobile_no||''}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick='edit(${JSON.stringify(c)})'>Edit</button>
                    <button class="btn btn-sm btn-danger" onclick='del(${c.id})'>Delete</button>
                </td>
            </tr>`;
                });
                companyData.innerHTML = html;
            });
        }

        let companyModal = new bootstrap.Modal(
            document.getElementById('companyModal')
        );

        function openForm() {
            companyForm.reset();
            companyForm.id.value = '';
            companyModal.show();
        }


        function edit(c) {
            companyForm.id.value = c.id;
            companyForm.name.value = c.name;
            companyForm.address.value = c.address;
            companyForm.mobile_no.value = c.mobile_no;
            companyModal.show();
        }

        companyForm.onsubmit = function(e) {
            e.preventDefault();

            let fd = new FormData(companyForm);
            fd.append('action', 'save');

            fetch('company_ajax.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(() => {
                    companyModal.hide();
                    loadCompanies();
                });
        };

        function del(id) {
            Swal.fire({
                title: 'Delete company?',
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if (r.isConfirmed) {
                    fetch('company_ajax.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            action: 'delete',
                            id: id
                        })
                    }).then(() => loadCompanies());
                }
            });
        }

        loadCompanies();
    </script>


</body>

</html>