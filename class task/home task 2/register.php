<?php
if(isset($_POST['register'])){
    $user = trim($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    file_put_contents("users.txt", $user."|".$pass.PHP_EOL, FILE_APPEND);
    $msg = "✅ Registration Success!";
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>

<h2>Register</h2>
<?php if(isset($msg)) echo $msg; ?>

<form method="POST">
<input type="text" name="username" required><br><br>
<input type="password" name="password" required><br><br>
<input type="submit" name="register" value="Register">
</form>

<a href="login.php">Login</a>

</body>
</html>