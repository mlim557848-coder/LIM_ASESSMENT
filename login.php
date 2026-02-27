<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // For now — static credentials (later move to DB + password_hash)
    if ($username === "admin" && $password === "admin") {
        $_SESSION['username'] = "ADMIN";
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalonApp - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- assuming style.css is in same folder as login.php -->
    <style>
        body { background: linear-gradient(135deg, #f0f2f5 0%, #e2e8f0 100%); }
        .login-container {
            max-width: 420px;
            margin: 10vh auto;
            padding: 2.5rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        .login-brand {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand i { color: #e94560; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-brand">
        <i class="bi bi-scissors me-2"></i>SalonApp
    </div>

    <h4 class="text-center mb-4 fw-semibold">Admin Login</h4>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label fw-medium">Username</label>
            <input type="text" name="username" class="form-control form-control-lg" required 
                   placeholder="admin" autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label fw-medium">Password</label>
            <input type="password" name="password" class="form-control form-control-lg" required 
                   placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100">
            Login <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>