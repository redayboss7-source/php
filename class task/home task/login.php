<?php
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $lines = file("users.txt");

    foreach($lines as $line){
        list($fileUser, $filePass) = explode("|", trim($line));

        if($username == $fileUser && password_verify($password, $filePass)){
            $_SESSION["user"] = $username;
            header("Location: upload.php");
            exit();
        }
    }

    $msg = "❌ Invalid Login!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login Page</h2>

<?php if(isset($msg)) echo $msg; ?>

<form method="POST">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" name="login" value="Login">
</form>

<a href="register.php">Register</a>

</body>
</html>