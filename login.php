<!--/* login.php - Admin Login Page */-->
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
		<link rel="icon" href="favi.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	 <style>
        body {
            background-color:#9087DD;
        }
	</style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="p-4 shadow" style="width: 300px;">
        <h3 class="text-center">Admin Login</h3>
        <form action="authenticate.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p class="text-danger text-center mt-2">Invalid Credentials</p>
        <?php endif; ?>
    </div>
</body>
</html>