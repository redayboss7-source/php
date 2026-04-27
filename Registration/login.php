<?php
session_start();

if(isset($_POST['login'])){

    $user=$_POST['username'];
    $pass=$_POST['password'];

    $data=file("info.txt");

    foreach($data as $line){

        $row=explode(",",$line);

        if(count($row) < 5) continue;

        $fileUser=trim($row[4]);
        $filePass=trim($row[3]);

        if($user==$fileUser && password_verify($pass,$filePass)){
            $_SESSION['user']=$user;
            header("location:admin.php");
            exit();
        }
    }

    $msg="Invalid login!";
}
?>

<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">
<div class="col-md-4 mx-auto">

<div class="card p-4 shadow">

<h3 class="text-center">Login</h3>

<?php if(isset($msg)) echo "<div class='alert alert-danger'>$msg</div>"; ?>

<form method="post">

<input class="form-control mb-3" type="text" name="username" placeholder="Username">

<input class="form-control mb-3" type="password" name="password" placeholder="Password">

<button class="btn btn-success w-100" name="login">Login</button>

</form>

</div>
</div>
</div>

</body>
</html>