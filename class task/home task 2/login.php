<?php
session_start();

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $lines = file("users.txt");

    foreach($lines as $line){
        list($u,$p) = explode("|", trim($line));

        if($user == $u && password_verify($pass, $p)){
            $_SESSION["user"] = $user;
            header("Location: index.php");
            exit();
        }
    }

    $msg = "❌ Login Failed!";
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>

<h2>Login</h2>
<?php if(isset($msg)) echo $msg; ?>

<form method="POST">
<input type="text" name="username" required><br><br>
<input type="password" name="password" required><br><br>
<input type="submit" name="login" value="Login">
</form>

<a href="register.php">Register</a>

</body>
</html>