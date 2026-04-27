<?php
if(isset($_POST['register'])){

    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];

    // REGEX
    $namePattern = "/^[a-zA-Z ]{3,50}$/";
    $userPattern = "/^[a-zA-Z0-9_]{4,20}$/";
    $passPattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/";

    if(!preg_match($namePattern, $name)){
        $msg = "Name must be 3-50 letters only!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = "Invalid Email!";
    }
    elseif(!preg_match($userPattern, $username)){
        $msg = "Username 4-20 letters/numbers!";
    }
    elseif(!preg_match($passPattern, $pass)){
        $msg = "Password must be 6+ with letter+number!";
    }
    elseif($pass != $repass){
        $msg = "Password not matched!";
    }
    else{

        // duplicate username check
        if(file_exists("info.txt")){
            $data = file("info.txt");
            foreach($data as $line){
                $row = explode(",",$line);
                if(trim($row[4]) == $username){
                    $msg = "Username already exists!";
                    break;
                }
            }
        }

        if(!isset($msg)){
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $data = "$id,$name,$email,$pass,$username\n";
            file_put_contents("info.txt",$data,FILE_APPEND);

            header("location:login.php");
            exit();
        }
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