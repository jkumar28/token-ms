<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="body">

    <div class="login-box">
        <h4 class="text-center mb-3">Admin Login</h4>
        <form id="loginForm">
            <input class="form-control mb-3" name="username" placeholder="Username" required>
            <input class="form-control mb-3" name="password" type="password" placeholder="Password" required>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="remember"> Remember Me
            </div>
            <button class="btn btn-warning w-100">Login</button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Logging in...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            fetch('login_action.php', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(r => r.json()).then(r => {
                    Swal.close();
                    if (r.status === 'success') {
                        window.location = 'dashboard.php';
                    } else Swal.fire('Error', r.message, 'error');
                });
        });
    </script>
</body>

</html>