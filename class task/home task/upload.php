<?php
session_start();

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['upload'])){

    $file = $_FILES['file'];

    $name = $file['name'];
    $tmp  = $file['tmp_name'];
    $size = $file['size'];

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    $allowed = ['jpg','png','pdf'];
    $maxSize = 2 * 1024 * 1024;

    if(!in_array($ext, $allowed)){
        $msg = "❌ Invalid file type";
    }
    elseif($size > $maxSize){
        $msg = "❌ File too large";
    }
    else{
        $newName = time() . "_" . $name;
        $path = "uploads/" . $newName;

        if(move_uploaded_file($tmp, $path)){
            $msg = "✅ Upload Success";
        } else {
            $msg = "❌ Upload Failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload</title>
</head>
<body>

<h2>Welcome <?php echo $_SESSION["user"]; ?></h2>

<a href="logout.php">Logout</a>

<h3>Upload File</h3>

<?php if(isset($msg)) echo $msg; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required><br><br>
    <input type="submit" name="upload" value="Upload">
</form>

</body>
</html>