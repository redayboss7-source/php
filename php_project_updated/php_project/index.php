<?php
session_start();
$msg = "";
$msg_type = "";

if (isset($_GET['msg']) && $_GET['msg'] == 'registered') {
    $msg = "✅ Registration successful! Please login.";
    $msg_type = "success";
}
if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
    $msg = "✅ User deleted successfully.";
    $msg_type = "success";
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if (file_exists("data.txt")) {
        $file = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($file as $row) {
            $data = explode("|", trim($row));
            if (count($data) >= 8 && $data[6] == $username && password_verify($pass, $data[3])) {
                $_SESSION['user'] = $username;
                $_SESSION['user_id'] = $data[0];
                header("Location: admin.php");
                exit();
            }
        }
    }
    $msg = "❌ Invalid username or password!";
    $msg_type = "error";
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User Management</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon"><i class="fas fa-user-shield"></i></div>
            <h2>Welcome Back</h2>
            <p>Sign in to your account</p>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-<?= $msg_type ?>"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required autocomplete="username">
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                <span class="toggle-pass" onclick="togglePass(this)"><i class="fas fa-eye"></i></span>
            </div>
            <button type="submit" name="login" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </div>
    </div>
</div>

<script>
function togglePass(el) {
    const input = el.previousElementSibling;
    const icon = el.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
