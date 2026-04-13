<?php
if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $file = fopen("users.txt", "a");
    fwrite($file, $username . "|" . $password . PHP_EOL);
    fclose($file);

    $msg = "Registration Successful! Now login.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Registration Form</h2>

<?php if(isset($msg)) echo $msg; ?>

<form method="POST">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" name="register" value="Register">
</form>

<a href="login.php">Go to Login</a>

</body>
</html>