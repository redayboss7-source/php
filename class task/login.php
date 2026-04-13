<?php
session_start();

if(isset($_POST['btnLogin'])){
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];

    if($username == "admin" && $password == "123"){
        $_SESSION["user"] = $username;
        header("location: file-upload.php");
        exit();
    } else {
        $msg = "❌ Login Failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login Page</h2>

<?php
if(isset($msg)){
    echo $msg;
}
?>

<form method="post">
    Username:<br>
    <input type="text" name="txtUsername" required><br><br>

    Password:<br>
    <input type="password" name="txtPassword" required><br><br>

    <input type="submit" name="btnLogin" value="Login">
</form>

</body>
</html>