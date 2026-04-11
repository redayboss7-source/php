<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
</head>
<style>
    form {
        display: flex;
        flex-direction: column;
        width: 50%;
        align-items: center;

    }

    form input {
        width: 50%;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<body>
    <form method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" name="login" Value=Login>
    </form>


    <?php

    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $password = $_POST['password'];

        if ($user === 'admin' && $password === '1234') {
            echo "Successfully logged in";
            header('location:main.php');
        } else {
            echo "Wrong username or password";
            
        }
    }


    ?>
</body>

</html>