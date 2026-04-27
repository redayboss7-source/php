<?php
if(isset($_POST['register'])){

    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $repass=$_POST['repass'];
    $username=$_POST['username'];

    if($pass != $repass){
        $msg="Password not matched!";
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $data="$id,$name,$email,$pass,$username\n";
        file_put_contents("info.txt",$data,FILE_APPEND);

        header("location:login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">
<div class="col-md-4 mx-auto">

<div class="card p-4 shadow">

<h3 class="text-center">Register</h3>

<?php if(isset($msg)) echo "<div class='alert alert-danger'>$msg</div>"; ?>

<form method="post">

<input class="form-control mb-2" type="number" name="id" placeholder="ID" required>

<input class="form-control mb-2" type="text" name="name" placeholder="Full Name" required>

<input class="form-control mb-2" type="email" name="email" placeholder="Email">

<input class="form-control mb-2" type="text" name="username" placeholder="Username" required>

<input class="form-control mb-2" type="password" name="pass" placeholder="Password" required>

<input class="form-control mb-2" type="password" name="repass" placeholder="Confirm Password" required>

<button class="btn btn-primary w-100" name="register">Register</button>

</form>

<a href="login.php" class="d-block text-center mt-3">Login</a>

</div>
</div>
</div>

</body>
</html>