<?php
session_start();

if(!isset($_SESSION["user"])){
    header("location: login.php");
    exit();
}

if(isset($_POST['submit'])){

    $file = $_FILES['myfile'];

    $fileName = $file['name'];
    $fileTmp  = $file['tmp_name'];
    $fileSize = $file['size'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['jpg','png','pdf'];
    $maxSize = 2 * 1024 * 1024;

    if(!in_array($fileExt, $allowed)){
        $msg = "❌ Invalid file type!";
    }
    elseif($fileSize > $maxSize){
        $msg = "❌ File too large!";
    }
    else{
        $newName = time() . "_" . $fileName;
        $uploadPath = "uploads/" . $newName;

        if(move_uploaded_file($fileTmp, $uploadPath)){
            $msg = "✅ Upload Success";
        }else{
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

<h2>Welcome, <?php echo $_SESSION["user"]; ?></h2>

<a href="logout.php">Logout</a>

<h3>Upload File</h3>

<?php
if(isset($msg)){
    echo $msg;
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="myfile" required><br><br>
    <input type="submit" name="submit" value="Upload">
</form>


<script>
setInterval(function(){
    fetch("check.php")
    .then(res => res.text())
    .then(data => {
        if(data !== "OK"){
            window.location = "login.php";
        }
    });
}, 2000);
</script>

</body>
</html>