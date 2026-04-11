<?php
$alrt_text = "";

if(isset($_POST['login_button'])){
    $userId = $_POST['userId'];
    $userpass = $_POST['user_password'];

    if(file_exists('data_store.txt')){

        $fileLocation = file('data_store.txt');
        $found = false;

        foreach($fileLocation as $data){
            list($_userId,$_userpass)= explode(",", trim($data));

            if(($userId == $_userId) && ($userpass == $_userpass)){
                $found = true;
                header("location: main_page.php");
                exit();
            }
        }

        if(!$found){
            $alrt_text = "<h3 style='color:red;'>Username or Password is incorrect!</h3>";
        }

    }else{
        $alrt_text = "<h3 style='color:red;'>Data file not found!</h3>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

</head>


<div class="box">
    <form method="post">
        <h3>Login</h3>

        <input type="text" name="userId" placeholder="User ID" required><br><br>

        <input type="password" name="user_password" placeholder="Password" required><br><br>

        <input type="submit" name="login_button" value="Log In">
    </form>

    <?php
        echo $alrt_text;
    ?>
</div>

</body>
</html>