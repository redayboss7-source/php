<?php
session_start();

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['upload'])){

    $f = $_FILES['file'];

    $name = $f['name'];
    $tmp  = $f['tmp_name'];
    $size = $f['size'];

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    $allow = ['jpg','jpeg','png'];
    $max = 2*1024*1024;

    if(!in_array($ext,$allow)){
        $msg="❌ Invalid file";
    }
    elseif($size>$max){
        $msg="❌ File too large";
    }
    else{
        $new = time()."_".$name;
        $path = "uploads/".$new;

        if(move_uploaded_file($tmp,$path)){
            $msg="✅ Upload Success";
        }else{
            $msg="❌ Upload Failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Upload</title></head>
<body>

<h2>Upload Image</h2>

<a href="index.php">Home</a> |
<a href="logout.php">Logout</a>

<?php if(isset($msg)) echo $msg; ?>

<form method="POST" enctype="multipart/form-data">
<input type="file" name="file" required><br><br>
<input type="submit" name="upload" value="Upload">
</form>

</body>
</html>