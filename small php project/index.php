<?php
session_start();
$msg = "";

if(isset($_GET['msg'])){
    $msg = "Registration successful! Please login.";
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $file = file("data.txt");

    foreach($file as $row){
        $data = explode("|", trim($row));

        if($data[6] == $username && password_verify($pass, $data[3])){
            $_SESSION['user'] = $username;
            header("Location: admin.php");
            exit();
        }
    }
    $msg = "Invalid login!";
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>Login</h2>

<form method="POST">
<input type="text" name="username" placeholder="User Name" required>
<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>
</form>

<p style="color:green;"><?= $msg ?></p>

<p>Not registered? <a href="register.php">Create Account</a></p>
</div>