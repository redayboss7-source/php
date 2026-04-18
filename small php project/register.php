<?php
$msg = "";

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $repass = $_POST['repassword'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];

    // Image upload
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $path = "upload/".$img;

    // Validation
    if($pass != $repass){
        $msg = "Password not match";
    }
    else{
        move_uploaded_file($tmp, $path);

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $data = "$id|$name|$email|$pass|$address|$contact|$username|$path\n";
        file_put_contents("data.txt", $data, FILE_APPEND);

        header("Location: index.php?msg=registered");
        exit();
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>Registration</h2>

<form method="POST" enctype="multipart/form-data">
<input type="text" name="id" placeholder="ID" required>
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="password" name="repassword" placeholder="Re-type Password" required>
<input type="text" name="address" placeholder="Address" required>
<input type="text" name="contact" placeholder="Contact Number" required>
<input type="text" name="username" placeholder="User Name" required>

<input type="file" name="image" required>

<button name="submit">Register</button>
</form>

<p style="color:red;"><?= $msg ?></p>

<p>Already have account? <a href="index.php">Login</a></p>
</div>